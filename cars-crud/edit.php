<?php
include 'db.php';
$id = $_GET['id'] ?? 0;
$car = $conn->query("SELECT * FROM cars WHERE id = " . (int)$id)->fetch_assoc();

if (!$car) {
    die("<div class='text-center py-20'><h1 class='text-4xl text-red-500'>Car Not Found!</h1></div>");
}

$images = json_decode($car['images'], true) ?: [];
?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>Edit Luxury Car - Morocco Elite</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body { 
      font-family: 'Inter', sans-serif; 
      background: #0f172a;
      -webkit-tap-highlight-color: transparent;
    }
    .glass { 
      backdrop-filter: blur(20px); 
      background: rgba(15, 23, 42, 0.8); 
      border: 1px solid rgba(255,255,255,0.15);
      box-shadow: 0 8px 32px rgba(0,0,0,0.5);
    }
    .input-field {
      background: rgba(30, 41, 59, 0.8);
      border: 2px solid rgba(255,255,255,0.3);
      transition: all 0.4s ease;
    }
    .input-field:focus {
      border-color: #fbbf24 !important;
      box-shadow: 0 0 0 4px rgba(251, 191, 36, 0.3);
      transform: translateY(-4px);
    }
    .float-label {
      color: #e2e8f0;
      transition: all 0.3s ease;
      pointer-events: none;
    }
    .fixed-bottom {
      backdrop-filter: blur(20px);
      background: linear-gradient(to top, rgba(15,23,42,0.98), rgba(15,23,42,0.9));
      border-top: 1px solid rgba(251,191,36,0.3);
    }
    .delete-btn {
      background: rgba(239,68,68,0.9);
      backdrop-filter: blur(10px);
    }
    .delete-btn:active {
      transform: scale(1.4) rotate(90deg);
    }
    .scrollbar-hide {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .preview-img {
      transition: all 0.3s ease;
    }
    .preview-img:hover {
      transform: scale(1.05);
    }
  </style>
</head>
<body class="min-h-screen text-white">

  <!-- Success Message -->
  <?php if (isset($_GET['success'])): ?>
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Updated!',
      text: 'Your masterpiece shines brighter in Morocco!',
      timer: 3000,
      toast: true,
      position: 'top',
      background: '#10b981',
      color: 'white',
      showConfirmButton: false
    }).then(() => window.location = 'index.php');
  </script>
  <?php endif; ?>

  <!-- Header -->
  <header class="bg-gradient-to-br from-purple-600 to-pink-600 py-16 text-center relative overflow-hidden">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class="relative z-10 px-4">
      <h1 class="text-4xl md:text-5xl font-black mb-3">
        Edit <span class="text-yellow-400">Masterpiece</span>
      </h1>
      <p class="text-lg opacity-90">Refine your luxury legend</p>
    </div>
  </header>

  <!-- Edit Form -->
  <section class="px-4 pb-32 -mt-16">
    <div class="glass rounded-3xl p-6 max-w-lg mx-auto">
      <form action="update.php" method="POST" enctype="multipart/form-data" class="space-y-6">
        <input type="hidden" name="id" value="<?= $car['id'] ?>">

        <!-- Input Fields -->
        <?php 
        $fields = [
          'name' => 'Car Name', 'brand' => 'Brand', 'model' => 'Model',
          'price' => ['label' => 'Price (MAD)', 'type' => 'number'],
          'color' => 'Color', 'seats' => ['label' => 'Seats', 'type' => 'number', 'min' => 2, 'max' => 9],
          'horsepower' => ['label' => 'Horsepower', 'type' => 'number']
        ];
        foreach ($fields as $key => $val): 
          $label = is_array($val) ? $val['label'] : $val;
          $type = $val['type'] ?? 'text';
        ?>
        <div class="relative">
          <input 
            type="<?= $type ?>" 
            name="<?= $key ?>" 
            value="<?= htmlspecialchars($car[$key] ?? '') ?>" 
            <?= in_array($key, ['name','brand','model','price']) ? 'required' : '' ?>
            <?= isset($val['min']) ? "min=\"{$val['min']}\"" : '' ?>
            <?= isset($val['max']) ? "max=\"{$val['max']}\"" : '' ?>
            class="w-full px-5 py-4 input-field rounded-2xl text-white placeholder-gray-400 focus:outline-none text-lg font-medium"
            placeholder=" ">
          <label class="float-label absolute top-4 left-5 text-sm">
            <?= $label ?>
          </label>
        </div>
        <?php endforeach; ?>

        <!-- Selects -->
        <div class="grid grid-cols-2 gap-4">
          <div class="relative">
            <select name="fuel_type" required class="w-full px-5 py-4 input-field rounded-2xl text-white text-lg font-medium appearance-none">
              <option value="Petrol" <?= $car['fuel_type']=='Petrol'?'selected':'' ?>>Petrol</option>
              <option value="Diesel" <?= $car['fuel_type']=='Diesel'?'selected':'' ?>>Diesel</option>
              <option value="Electric" <?= $car['fuel_type']=='Electric'?'selected':'' ?>>Electric</option>
              <option value="Hybrid" <?= $car['fuel_type']=='Hybrid'?'selected':'' ?>>Hybrid</option>
            </select>
            <label class="float-label absolute top-4 left-5 text-sm">Fuel Type</label>
          </div>
          <div class="relative">
            <select name="transmission" class="w-full px-5 py-4 input-field rounded-2xl text-white text-lg font-medium appearance-none">
              <option value="Manual" <?= $car['transmission']=='Manual'?'selected':'' ?>>Manual</option>
              <option value="Automatic" <?= $car['transmission']=='Automatic'?'selected':'' ?>>Automatic</option>
            </select>
            <label class="float-label absolute top-4 left-5 text-sm">Transmission</label>
          </div>
        </div>

        <!-- Description -->
        <div class="relative">
          <textarea name="description" rows="3" 
                    class="w-full px-5 py-4 input-field rounded-2xl text-white placeholder-gray-400 resize-none text-lg"
                    placeholder=" "><?= htmlspecialchars($car['description'] ?? '') ?></textarea>
          <label class="float-label absolute top-4 left-5 text-sm">Description (Optional)</label>
        </div>

        <!-- Current Images -->
        <?php if (!empty($images)): ?>
        <div class="bg-slate-700/70 rounded-3xl p-5">
          <h3 class="text-xl font-bold mb-4 text-center">Current Photos</h3>
          <div class="grid grid-cols-3 gap-3 overflow-x-auto scrollbar-hide">
            <?php foreach ($images as $img): ?>
            <div class="relative group">
              <img src="uploads/<?= htmlspecialchars($img) ?>" class="w-full aspect-square object-cover rounded-2xl preview-img">
              <button type="button" onclick="this.parentElement.remove();" 
                      class="delete-btn absolute top-2 right-2 w-10 h-10 rounded-full flex items-center justify-center text-2xl font-black shadow-2xl">
                ×
              </button>
              <input type="hidden" name="existing_images[]" value="<?= $img ?>">
            </div>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>

        <!-- Add New Images -->
        <div class="bg-slate-700/70 rounded-3xl p-6 border-2 border-dashed border-yellow-500">
          <h3 class="text-xl font-bold mb-4 text-center text-yellow-400">Add New Photos</h3>
          <input type="file" name="images[]" multiple accept="image/*"
                 class="w-full px-4 py-8 bg-slate-600/50 rounded-2xl border-4 border-dashed border-yellow-500 text-center file:mr-4 file:py-3 file:px-6 file:rounded-full file:bg-yellow-500 file:text-black file:font-bold cursor-pointer"
                 onchange="previewNew(this)">
          <div id="newPreview" class="grid grid-cols-3 gap-3 mt-4"></div>
        </div>

        <!-- Fixed Bottom Bar -->
        <div class="fixed-bottom bottom-0 left-0 right-0 p-4">
          <div class="flex gap-4 max-w-lg mx-auto">
            <button type="submit" class="flex-1 bg-gradient-to-r from-yellow-500 to-orange-600 text-black py-5 rounded-2xl text-2xl font-black shadow-2xl active:scale-95 transition">
              UPDATE CAR
            </button>
            <a href="index.php" class="flex-1 bg-white/20 backdrop-blur-xl text-white py-5 rounded-2xl text-2xl font-bold text-center border-2 border-white/30 active:scale-95 transition">
              CANCEL
            </a>
          </div>
        </div>
      </form>
    </div>
  </section>

  <script>
    // Floating Labels
    document.querySelectorAll('input, textarea, select').forEach(field => {
      const label = field.parentElement.querySelector('.float-label');
      const update = () => {
        if (field.value) {
          label.style.transform = 'translateY(-32px) scale(0.85)';
          label.style.color = '#fbbf24';
        } else {
          label.style.transform = 'translateY(0) scale(1)';
          label.style.color = '#e2e8f0';
        }
      };
      field.addEventListener('focus', () => {
        label.style.transform = 'translateY(-32px) scale(0.85)';
        label.style.color = '#fbbf24';
      });
      field.addEventListener('blur', update);
      update();
    });

    // Preview New Images
    function previewNew(input) {
      const preview = document.getElementById('newPreview');
      preview.innerHTML = '';
      [...input.files].forEach(file => {
        if (file.type.startsWith('image/')) {
          const reader = new FileReader();
          reader.onload = e => {
            preview.innerHTML += `
              <div class="relative">
                <img src="${e.target.result}" class="w-full aspect-square object-cover rounded-2xl">
                <div class="absolute bottom-2 left-2 bg-yellow-500 text-black px-2 py-1 rounded-full text-xs font-bold">NEW</div>
              </div>`;
          };
          reader.readAsDataURL(file);
        }
      });
    }
  </script>
</body>
</html>