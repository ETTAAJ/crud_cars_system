<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // جلب البيانات
    $name         = $_POST['name'];
    $brand        = $_POST['brand'];
    $model        = $_POST['model'];
    $price        = $_POST['price'];
    $fuel_type    = $_POST['fuel_type'];
    $color        = $_POST['color'];
    $seats        = $_POST['seats'] ?? 5;
    $transmission = $_POST['transmission'];
    $horsepower   = $_POST['horsepower'] ?? null;
    $description  = $_POST['description'] ?? '';

    // رفع الصور
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $uploadedImages = [];
    if (!empty($_FILES['images']['name'][0])) {
        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['images']['error'][$key] === 0) {
                $exts = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                $ext = strtolower(pathinfo($_FILES['images']['name'][$key], PATHINFO_EXTENSION));
                if (in_array($ext, $exts)) {
                    $fileName = uniqid('car_') . '.' . $ext;
                    $filePath = $uploadDir . $fileName;
                    if (move_uploaded_file($tmp_name, $filePath)) {
                        $uploadedImages[] = $fileName;
                    }
                }
            }
        }
    }

    $imagesJson = json_encode($uploadedImages);

    // إدخال في قاعدة البيانات
    $stmt = $conn->prepare("INSERT INTO cars (name, brand, model, price, fuel_type, color, seats, transmission, horsepower, description, images) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdssisiss", $name, $brand, $model, $price, $fuel_type, $color, $seats, $transmission, $horsepower, $description, $imagesJson);

    if ($stmt->execute()) {
        // نجاح → إعادة توجيه مع رسالة
        header("Location: add.php?success=1");
        exit();
    } else {
        die("خطأ في الحفظ: " . $stmt->error);
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>إضافة سيارة</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<?php if (isset($_GET['success'])): ?>
<script>
  Swal.fire({
    icon: 'success',
    title: 'تم بنجاح!',
    text: 'تم إضافة السيارة بنجاح',
    timer: 2000,
    showConfirmButton: false
  }).then(() => {
    window.location.href = 'index.php';
  });
</script>
<?php endif; ?>

</body>
</html>