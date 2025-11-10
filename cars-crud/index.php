<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>معرض السيارات الفاخرة - المغرب</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Cairo:wght@400;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body { font-family: 'Cairo', 'Inter', sans-serif; background: #0f172a; }
    .glass { backdrop-filter: blur(16px); background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(255,255,255,0.15); }
    .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .card { transition: all 0.4s ease; }
    .card:hover { transform: translateY(-8px); }
    .thumb { transition: all 0.3s ease; }
    .thumb.active { border-color: #fbbf24; transform: scale(1.1); }
    .price-glow { text-shadow: 0 0 20px rgba(251, 191, 36, 0.6); }
    @media (max-width: 640px) {
      .container { padding-left: 1rem; padding-right: 1rem; }
      .card { margin-bottom: 2rem; }
    }
  </style>
</head>
<body class="min-h-screen">

  <!-- Success Alert -->
  <?php if (isset($_GET['updated']) || isset($_GET['success'])): ?>
  <script>
    Swal.fire({
      icon: 'success',
      title: 'تم بنجاح!',
      text: 'تم حفظ التغييرات بأناقة مغربية',
      timer: 2500,
      toast: true,
      position: 'top-end',
      background: '#10b981',
      color: 'white'
    }).then(() => history.replaceState(null, null, 'index.php'));
  </script>
  <?php endif; ?>

  <!-- Hero Header - مثالي للموبايل -->
  <header class="gradient-bg text-white py-16 relative overflow-hidden">
    <div class="absolute inset-0 bg-black opacity-60"></div>
    <div class="container mx-auto px-4 relative z-10 text-center">
      <h1 class="text-4xl md:text-6xl font-black mb-4">
        معرض <span class="text-yellow-400">الفخامة</span>
      </h1>
      <p class="text-lg md:text-xl mb-8 opacity-90">أجمل السيارات في المغرب</p>
      <a href="add.php" class="inline-flex items-center gap-3 bg-yellow-500 text-black px-8 py-4 rounded-full text-lg font-bold shadow-2xl hover:shadow-yellow-500/50">
        <i class="fas fa-plus-circle"></i>
        إضافة سيارة جديدة
      </a>
    </div>
  </header>

  <!-- Cars Grid - بدون تداخل أبدًا على الموبايل -->
  <section class="container mx-auto px-4 py-12">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
      <?php
      $result = $conn->query("SELECT * FROM cars ORDER BY id DESC");
      if ($result->num_rows > 0):
        while ($car = $result->fetch_assoc()):
          $images = json_decode($car['images'], true) ?: [];
          $firstImg = $images[0] ?? 'placeholder.jpg';
      ?>
        <!-- كارت فاخر - مثالي للموبايل -->
        <article class="card bg-slate-800/90 glass rounded-3xl overflow-hidden shadow-2xl">
          <div class="relative">
            <img src="uploads/<?= htmlspecialchars($firstImg) ?>" 
                 class="w-full h-56 sm:h-64 object-cover" 
                 alt="<?= htmlspecialchars($car['name']) ?>">
            
            <!-- Badges -->
            <div class="absolute top-3 right-3 flex flex-col gap-2">
              <span class="bg-yellow-500 text-black px-3 py-1 rounded-full text-xs font-bold">PREMIUM</span>
              <?php if ($car['price'] > 800000): ?>
                <span class="bg-red-600 text-white px-3 py-1 rounded-full text-xs font-bold">LUXURY</span>
              <?php endif; ?>
            </div>

            <!-- Thumbnails - مخفية على الموبايل الصغير -->
            <?php if (count($images) > 1): ?>
            <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2 bg-black/60 backdrop-blur p-2 rounded-xl opacity-0 sm:opacity-100 transition">
              <?php foreach (array_slice($images, 0, 4) as $i => $img): ?>
                <img src="uploads/<?= htmlspecialchars($img) ?>" 
                     onclick="this.closest('article').querySelector('.main-img').src=this.src"
                     class="w-10 h-10 object-cover rounded-lg cursor-pointer thumb <?= $i===0?'active':'' ?> border-2 border-white/30">
              <?php endforeach; ?>
            </div>
            <?php endif; ?>
          </div>

          <div class="p-5">
            <h3 class="text-xl font-black text-white mb-1 line-clamp-1"><?= htmlspecialchars($car['name']) ?></h3>
            <p class="text-yellow-400 font-bold text-lg mb-3"><?= $car['brand'] ?> <?= $car['model'] ?></p>
            
            <div class="flex flex-wrap gap-2 mb-4 text-xs">
              <span class="bg-slate-700 px-3 py-1 rounded-full"><i class="fas fa-gas-pump"></i> <?= $car['fuel_type'] ?></span>
              <span class="bg-slate-700 px-3 py-1 rounded-full"><i class="fas fa-cog"></i> <?= $car['transmission'] ?></span>
              <span class="bg-slate-700 px-3 py-1 rounded-full"><i class="fas fa-chair"></i> <?= $car['seats'] ?></span>
            </div>

            <div class="flex items-center justify-between">
              <div class="text-right">
                <p class="text-2xl font-black text-yellow-400 price-glow">
                  <?= number_format($car['price']) ?>
                  <span class="text-sm">درهم</span>
                </p>
              </div>
              <div class="flex gap-3">
                <a href="edit.php?id=<?= $car['id'] ?>" class="bg-emerald-600 text-white p-3 rounded-xl hover:bg-emerald-700 transition">
                  <i class="fas fa-edit"></i>
                </a>
                <button onclick="confirmDelete(<?= $car['id'] ?>)" class="bg-red-600 text-white p-3 rounded-xl hover:bg-red-700 transition">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </div>
          </div>
        </article>
      <?php
        endwhile;
      else:
      ?>
        <!-- Empty State - مثالي للموبايل -->
        <div class="col-span-full text-center py-20">
          <div class="bg-slate-700/50 border-4 border-dashed border-slate-600 rounded-3xl w-32 h-32 mx-auto mb-8 animate-pulse"></div>
          <h2 class="text-3xl font-bold text-yellow-400 mb-4">لا توجد سيارات بعد</h2>
          <p class="text-gray-400 mb-8 text-lg">ابدأ مجموعتك الفاخرة الآن</p>
          <a href="add.php" class="inline-flex items-center gap-3 bg-yellow-500 text-black px-10 py-5 rounded-full text-xl font-bold">
            <i class="fas fa-sparkles"></i>
            أضف أول سيارة
          </a>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- Floating Add Button - للموبايل فقط -->
  <a href="add.php" class="fixed bottom-6 right-6 bg-yellow-500 text-black p-5 rounded-full shadow-2xl z-50 hover:scale-110 transition">
    <i class="fas fa-plus text-3xl"></i>
  </a>

  <script>
    function confirmDelete(id) {
      Swal.fire({
        title: 'هل أنت متأكد؟',
        text: "هذه السيارة الفاخرة ستُحذف نهائيًا!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'نعم، احذفها',
        cancelButtonText: 'لا، احتفظ بها',
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        background: '#1e293b',
        color: '#fff'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = `delete.php?id=${id}`;
        }
      });
    }
  </script>
</body>
</html>