<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Masterpiece - Morocco Luxury Cars</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body { font-family: 'Inter', sans-serif; background: #0f172a; }
    .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .glass { 
      backdrop-filter: blur(20px); 
      background: rgba(15, 23, 42, 0.65); 
      border: 1px solid rgba(255, 255, 255, 0.2); 
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
    }
    .input-field {
      background: rgba(30, 41, 59, 0.7) !important;
      border: 2px solid rgba(255, 255, 255, 0.3) !important;
      color: #ffffff !important;
      backdrop-filter: blur(12px);
      transition: all 0.4s ease;
    }
    .input-field:focus {
      border-color: #fbbf24 !important;
      box-shadow: 0 0 0 4px rgba(251, 191, 36, 0.3), 0 20px 40px rgba(102, 126, 234, 0.4) !important;
      transform: translateY(-4px);
    }
    .float-label {
      color: #e2e8f0 !important;
      transition: all 0.3s ease;
    }
    .float { animation: float 10s ease-in-out infinite; }
    @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
    .preview-img:hover { transform: scale(1.15) rotate(4deg); }
    .file-btn {
      background: linear-gradient(to right, #fbbf24, #f59e0b) !important;
      color: #1e293b !important;
    }
  </style>
</head>
<body class="min-h-screen">

  <!-- Success Toast -->
  <?php if (isset($_GET['success'])): ?>
  <script>
    Swal.fire({
      icon: 'success',
      title: 'تمت الإضافة بنجاح!',
      text: 'سيارتك الفاخرة أصبحت في المجموعة المغربية الآن',
      timer: 3000,
      toast: true,
      position: 'top-end',
      background: '#10b981',
      color: 'white',
      iconColor: 'white'
    }).then(() => window.location = 'index.php');
  </script>
  <?php endif; ?>

  <!-- Hero Header -->
  <header class="gradient-bg text-white py-24 relative overflow-hidden">
    <div class="absolute inset-0 bg-black opacity-70"></div>
    <div class="container mx-auto px-6 relative z-10 text-center">
      <h1 class="text-5xl md:text-7xl font-black mb-6 tracking-tight float drop-shadow-2xl">
        Add <span class="text-yellow-400">Masterpiece</span>
      </h1>
      <p class="text-xl md:text-2xl font-light max-w-3xl mx-auto drop-shadow-lg">
        ارفع مستوى مجموعة السيارات الفاخرة في المغرب
      </p>
    </div>
  </header>

  <!-- Form -->
  <section class="container mx-auto px-6 -mt-20 relative z-20">
    <div class="max-w-6xl mx-auto">
      <div class="glass rounded-3xl shadow-3xl p-10">
        <form action="store.php" method="POST" enctype="multipart/form-data" class="space-y-12">
          
          <div class="text-center mb-12">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-4 float drop-shadow-xl">Craft Your Legend</h2>
            <p class="text-lg md:text-xl text-gray-200 max-w-2xl mx-auto">كل تفصيلة مهمة في عالم الفخامة</p>
          </div>

          <!-- Inputs Grid -->
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 justify-items-center">
            <?php
            $fields = [
              'name' => 'Car Name', 'brand' => 'Brand', 'model' => 'Model',
              'price' => 'Price (MAD)', 'color' => 'Color', 'seats' => 'Seats',
              'horsepower' => 'Horsepower'
            ];
            foreach ($fields as $key => $label):
              $type = in_array($key, ['price','seats','horsepower']) ? 'number' : 'text';
              $required = in_array($key, ['name','brand','model','price']) ? 'required' : '';
              $extra = $key === 'seats' ? 'min="2" max="9"' : '';
            ?>
            <div class="relative w-full max-w-sm">
              <input type="<?= $type ?>" name="<?= $key ?>" <?= $required ?> <?= $extra ?> placeholder=" "
                     class="w-full px-6 py-5 input-field rounded-2xl placeholder-gray-400 text-white focus:outline-none text-base md:text-lg font-medium">
              <label class="float-label absolute top-5 left-6 pointer-events-none text-sm md:text-base">
                <?= $label ?>
              </label>
            </div>
            <?php endforeach; ?>

            <div class="relative w-full max-w-sm">
              <select name="fuel_type" required class="w-full px-6 py-5 input-field rounded-2xl text-white text-base md:text-lg font-medium appearance-none">
                <option value="" class="text-gray-600"></option>
                <option>Petrol</option><option>Diesel</option><option>Electric</option><option>Hybrid</option>
              </select>
              <label class="float-label absolute top-5 left-6 text-sm md:text-base">Fuel Type</label>
            </div>

            <div class="relative w-full max-w-sm">
              <select name="transmission" class="w-full px-6 py-5 input-field rounded-2xl text-white text-base md:text-lg font-medium appearance-none">
                <option value="Manual">Manual</option>
                <option value="Automatic">Automatic</option>
              </select>
              <label class="float-label absolute top-5 left-6 text-sm md:text-base">Transmission</label>
            </div>
          </div>

          <!-- Description -->
          <div class="max-w-3xl mx-auto">
            <div class="relative">
              <textarea name="description" rows="5" placeholder=" "
                        class="w-full px-6 py-5 input-field rounded-2xl placeholder-gray-400 text-white resize-none text-base md:text-lg"></textarea>
              <label class="float-label absolute top-5 left-6 text-sm md:text-base">
                Description (Optional)
              </label>
            </div>
          </div>

          <!-- Image Upload -->
          <div class="max-w-5xl mx-auto">
            <div class="bg-slate-800/70 backdrop-blur-xl rounded-3xl p-10 border-2 border-dashed border-yellow-500/50">
              <label class="block text-2xl md:text-3xl font-black text-white mb-8 text-center">
                صور المعرض (متعددة)
              </label>
              <input type="file" name="images[]" multiple accept="image/*" required
                     class="w-full max-w-2xl mx-auto px-6 py-10 bg-slate-700/80 backdrop-blur-lg border-4 border-dashed border-yellow-500 rounded-3xl text-white file:mr-6 file:py-5 file:px-10 file:rounded-full file:border-0 file:text-base file:font-bold file-btn cursor-pointer block text-center"
                     onchange="previewImages(this)">
              <div id="imagePreview" class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6 mt-10 justify-items-center"></div>
            </div>
          </div>

          <!-- Submit -->
          <div class="text-center pt-12">
            <button type="submit" class="inline-flex items-center gap-4 bg-gradient-to-r from-yellow-500 to-orange-600 text-black px-14 py-7 rounded-full text-xl md:text-2xl font-black shadow-2xl hover:shadow-yellow-500/60 transform hover:scale-105 transition duration-300">
              Add to Elite Collection
            </button>
            <a href="index.php" class="block mt-6 text-gray-300 hover:text-white text-lg underline">
              ← العودة إلى المعرض
            </a>
          </div>
        </form>
      </div>
    </div>
  </section>

  <script>
    // Floating Labels - مثالية
    document.querySelectorAll('input, textarea, select').forEach(field => {
      const label = field.parentElement.querySelector('.float-label');
      const update = () => {
        if (field.value) {
          label.style.transform = 'translateY(-36px) scale(0.85)';
          label.style.color = '#fbbf24';
        } else {
          label.style.transform = 'translateY(0) scale(1)';
          label.style.color = '#e2e8f0';
        }
      };
      field.addEventListener('focus', () => {
        label.style.transform = 'translateY(-36px) scale(0.85)';
        label.style.color = '#fbbf24';
      });
      field.addEventListener('blur', update);
      update();
    });

    // Image Preview
    function previewImages(input) {
      const preview = document.getElementById('imagePreview');
      preview.innerHTML = '';
      [...input.files].forEach((file, i) => {
        if (file.type.startsWith('image/')) {
          const reader = new FileReader();
          reader.onload = e => {
            preview.innerHTML += `
              <div class="relative group overflow-hidden rounded-2xl shadow-2xl">
                <img src="${e.target.result}" class="w-full h-48 object-cover preview-img">
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 to-transparent opacity-0 group-hover:opacity-100 transition flex items-end">
                  <span class="text-white font-bold text-lg p-4">صورة ${i + 1}</span>
                </div>
              </div>`;
          };
          reader.readAsDataURL(file);
        }
      });
    }
  </script>
</body>
</html>