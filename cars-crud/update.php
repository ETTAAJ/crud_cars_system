<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $price = $_POST['price'];
    $fuel_type = $_POST['fuel_type'];
    $color = $_POST['color'];
    $seats = $_POST['seats'];
    $transmission = $_POST['transmission'];
    $horsepower = $_POST['horsepower'];
    $description = $_POST['description'];
    $existing_images = $_POST['existing_images'] ?? [];

    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $newImages = [];
    if (!empty($_FILES['images']['name'][0])) {
        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            $fileName = uniqid() . '_' . basename($_FILES['images']['name'][$key]);
            $filePath = $uploadDir . $fileName;
            if (move_uploaded_file($tmp_name, $filePath)) {
                $newImages[] = $fileName;
            }
        }
    }

    $allImages = array_merge($existing_images, $newImages);
    $imagesJson = json_encode($allImages);

    $stmt = $conn->prepare("UPDATE cars SET name=?, brand=?, model=?, price=?, fuel_type=?, color=?, seats=?, transmission=?, horsepower=?, description=?, images=? WHERE id=?");
    $stmt->bind_param("sssdssisissi", $name, $brand, $model, $price, $fuel_type, $color, $seats, $transmission, $horsepower, $description, $imagesJson, $id);

    if ($stmt->execute()) {
        header("Location: edit.php?id=$id&success=1");
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>