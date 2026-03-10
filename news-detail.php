<?php
require_once 'connect.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) { header('Location: news.php'); exit; }

$stmt = $conn->prepare("SELECT * FROM news WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$article = $stmt->get_result()->fetch_assoc();
if (!$article) { header('Location: news.php'); exit; }

// Get prev/next for navigation
$prev = $conn->query("SELECT id, title FROM news WHERE id < $id ORDER BY id DESC LIMIT 1")->fetch_assoc();
$next = $conn->query("SELECT id, title FROM news WHERE id > $id ORDER BY id ASC LIMIT 1")->fetch_assoc();

// Related articles (3 latest excluding current)
$related = $conn->query("SELECT id, title, image, date FROM news WHERE id != $id ORDER BY date DESC LIMIT 3")->fetch_all(MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= htmlspecialchars($article['title']) ?> | Dabs Dynamic International Schools</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .article-body { line-height: 1.9; font-size: 1.05rem; color: #374151; }
    .article-body p  { margin-bottom: 1.4rem; }
    .article-body h2 { font-size: 1.5rem; font-weight: 700; color: #14532d; margin: 2rem 0 1rem; }
    .article-body h3 { font-size: 1.2rem; font-weight: 600; color: #166534; margin: 1.5rem 0 0.75rem; }
    .article-body ul, .article-body ol { padding-left: 1.5rem; margin-bottom: 1.4rem; }
    .article-body ul { list-style-type: disc; }
    .article-body ol { list-style-type: decimal; }
    .article-body li { margin-bottom: 0.5rem; }
    .article-body blockquote { border-left: 4px solid #16a34a; padding: 1rem 1.5rem; background: #f0fdf4; margin: 1.5rem 0; border-radius: 0 0.5rem 0.5rem 0; font-style: italic; color: #166534; }
    #menuBtn .bar:nth-child(1){top:8px} #menuBtn .bar:nth-child(2){top:13px} #menuBtn .bar:nth-child(3){top:18px}
    #menuBtn.open .bar:nth-child(1){transform:rotate(45deg);top:13px}
    #menuBtn.open .bar:nth-child(2){opacity:0}
    #menuBtn.open .bar:nth-child(3){transform:rotate(-45deg);top:13px}
  </style>
</head>
<body class="font-sans text-gray-800 bg-gray-50">

  <!-- NAVBAR -->
  <header class="bg-green-100">
    <nav class="max-w-7xl mx-auto flex items-center justify-between p-4">
      <div class="flex items-center gap-3">
        <img src="dabs-logo.png" alt="Logo" class="h-16 w-16 object-contain"/>
        <div class="leading-tight">
          <span class="block text-lg font-bold text-green-900">Dabs Dynamic Int'l Schools</span>
          <span class="block text-xs font-medium text-green-700">GOVT. APPROVED • RC NO: 2435402</span>
        </div>
      </div>
      <ul class="hidden md:flex space-x-6 font-medium">
        <li><a href="home.php" class="hover:text-green-700">Home</a></li>
        <li><a href="news.php" class="font-bold text-green-900">News</a></li>
        <li><a href="about.php" class="hover:text-green-700">About</a></li>
        <li><a href="academics.php" class="hover:text-green-700">Academics</a></li>
        <li><a href="admissions.php" class="hover:text-green-700">Admissions</a></li>
        <li><a href="gallery.php" class="hover:text-green-700">Gallery</a></li>
        <li><a href="contact.php" class="hover:text-green-700">Contact</a></li>
      </ul>
      <button id="menuBtn" class="md:hidden relative w-7 h-7 flex items-center justify-center focus:outline-none">
        <span class="bar absolute w-6 h-0.5 bg-green-900 transition-all duration-300"></span>
        <span class="bar absolute w-6 h-0.5 bg-green-900 transition-all duration-300"></span>
        <span class="bar absolute w-6 h-0.5 bg-green-900 transition-all duration-300"></span>
      </button>
    </nav>
  </header>

  <!-- BREADCRUMB -->
  <div class="bg-white border-b border-gray-100 px-6 py-3">
    <div class="max-w-4xl mx-auto text-sm text-gray-500 flex items-center gap-2">
      <a href="home.php" class="hover:text-green-700">Home</a>
      <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
      <a href="news.php" class="hover:text-green-700">News</a>
      <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
      <span class="text-gray-700 truncate max-w-xs"><?= htmlspecialchars($article['title']) ?></span>
    </div>
  </div>

  <!-- ARTICLE -->
  <main class="py-12 px-6">
    <div class="max-w-4xl mx-auto">

      <!-- Title & Meta -->
      <div class="mb-8">
        <div class="flex items-center gap-3 mb-4">
          <span class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">School News</span>
          <span class="text-gray-400 text-sm"><?= date('F j, Y', strtotime($article['date'])) ?></span>
        </div>
        <h1 class="text-3xl md:text-4xl font-bold text-green-900 leading-tight mb-4"><?= htmlspecialchars($article['title']) ?></h1>
        <div class="h-1 w-16 bg-green-600 rounded-full"></div>
      </div>

      <!-- Hero Image -->
      <?php if (!empty($article['image'])): ?>
        <div class="mb-10 rounded-2xl overflow-hidden shadow-lg">
          <img src="<?= (strpos($article['image'], 'uploads/') === 0 ? '' : 'uploads/') . htmlspecialchars($article['image']) ?>" alt="<?= htmlspecialchars($article['title']) ?>" class="w-full max-h-[500px] object-cover"/>
        </div>
      <?php endif; ?>

      <!-- Article Body -->
      <div class="bg-white rounded-2xl shadow-sm p-8 md:p-12 mb-10">
        <div class="article-body">
          <?= nl2br(htmlspecialchars($article['content'])) ?>
        </div>
      </div>

      <!-- Prev / Next Navigation -->
      <div class="grid md:grid-cols-2 gap-4 mb-12">
        <?php if ($prev): ?>
          <a href="news-detail.php?id=<?= $prev['id'] ?>" class="flex items-center gap-3 bg-white p-5 rounded-xl shadow hover:shadow-md border border-gray-100 hover:border-green-200 transition group">
            <svg class="w-5 h-5 text-green-700 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            <div><p class="text-xs text-gray-400 mb-1">Previous Article</p><p class="text-sm font-medium text-green-900 group-hover:text-green-700 line-clamp-2"><?= htmlspecialchars($prev['title']) ?></p></div>
          </a>
        <?php else: ?><div></div><?php endif; ?>

        <?php if ($next): ?>
          <a href="news-detail.php?id=<?= $next['id'] ?>" class="flex items-center justify-end gap-3 bg-white p-5 rounded-xl shadow hover:shadow-md border border-gray-100 hover:border-green-200 transition group text-right">
            <div><p class="text-xs text-gray-400 mb-1">Next Article</p><p class="text-sm font-medium text-green-900 group-hover:text-green-700 line-clamp-2"><?= htmlspecialchars($next['title']) ?></p></div>
            <svg class="w-5 h-5 text-green-700 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
          </a>
        <?php endif; ?>
      </div>

      <!-- Back to News -->
      <div class="text-center mb-12">
        <a href="news.php" class="inline-flex items-center gap-2 bg-green-800 text-white px-8 py-3 rounded-xl font-semibold hover:bg-green-700 transition">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
          Back to All News
        </a>
      </div>

      <!-- Related Articles -->
      <?php if (!empty($related)): ?>
        <div>
          <h2 class="text-2xl font-bold text-green-900 mb-6">More Articles</h2>
          <div class="grid sm:grid-cols-3 gap-5">
            <?php foreach ($related as $r): ?>
              <a href="news-detail.php?id=<?= $r['id'] ?>" class="group bg-white rounded-xl overflow-hidden shadow hover:shadow-lg transition hover:-translate-y-1 duration-300">
                <div class="h-36 overflow-hidden bg-green-50">
                  <?php if (!empty($r['image'])): ?>
                    <img src="<?= (strpos($r['image'], 'uploads/') === 0 ? '' : 'uploads/') . htmlspecialchars($r['image']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" alt=""/>
                  <?php else: ?>
                    <div class="w-full h-full flex items-center justify-center text-3xl text-green-200">📰</div>
                  <?php endif; ?>
                </div>
                <div class="p-4">
                  <p class="text-xs text-gray-400 mb-1"><?= date('M j, Y', strtotime($r['date'])) ?></p>
                  <h3 class="text-sm font-semibold text-green-900 group-hover:text-green-700 line-clamp-2"><?= htmlspecialchars($r['title']) ?></h3>
                </div>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>

    </div>
  </main>

  <!-- FOOTER -->
  <section class="bg-green-900 text-white pt-16 pb-6">
    <div class="max-w-7xl mx-auto px-6">
      <div class="grid md:grid-cols-3 gap-12 mb-10">
        <div><h4 class="text-white font-semibold mb-4 text-lg">About Dabs Dynamic</h4><p class="text-slate-400 leading-relaxed">Since 2006, Dabs Dynamic International Schools has upheld global academic standards while nurturing strong moral values and disciplined leadership.</p></div>
        <div>
          <h4 class="text-white font-semibold mb-4 text-lg">Quick Links</h4>
          <ul class="space-y-3 text-slate-400">
            <li><a href="about.php" class="hover:text-amber-400 transition">About</a></li>
            <li><a href="academics.php" class="hover:text-amber-400 transition">Academics</a></li>
            <li><a href="admissions.php" class="hover:text-amber-400 transition">Admissions</a></li>
            <li><a href="news.php" class="hover:text-amber-400 transition">News</a></li>
            <li><a href="contact.php" class="hover:text-amber-400 transition">Contact</a></li>
          </ul>
        </div>
        <div>
          <h4 class="text-white font-semibold mb-4 text-lg">Stay Connected</h4>
          <form class="flex flex-col space-y-4">
            <input type="email" placeholder="Enter your email address" class="px-4 py-3 rounded-lg bg-slate-800 border border-slate-700 text-white focus:outline-none focus:ring-2 focus:ring-green-400"/>
            <button type="submit" class="bg-green-700 text-white py-3 rounded-lg font-semibold hover:bg-green-800 transition">Subscribe</button>
          </form>
        </div>
      </div>
      <div class="border-t border-green-800 pt-6 text-center">
        <p class="text-sm text-green-200">Knowledge Cum Discipline © 2006 – 2026 | All Rights Reserved</p>
      </div>
    </div>
  </section>

  <!-- Mobile Menu -->
  <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>
  <div id="mobileMenu" class="fixed top-0 right-0 h-full w-80 bg-white shadow-xl transform translate-x-full transition-transform duration-300 ease-in-out z-50">
    <div class="flex items-center justify-between px-5 py-4 border-b bg-green-100">
      <span class="font-bold text-green-900">Menu</span>
      <button id="closeMenu" class="w-8 h-8 flex items-center justify-center bg-green-700 text-white rounded-full">✕</button>
    </div>
    <nav class="px-6 py-6 space-y-6 font-medium text-gray-700">
      <a href="home.php" class="block border-b pb-3">Home</a>
      <a href="news.php" class="block border-b pb-3 font-bold text-green-900">News</a>
      <a href="about.php" class="block border-b pb-3">About</a>
      <a href="academics.php" class="block border-b pb-3">Academics</a>
      <a href="admissions.php" class="block border-b pb-3">Admissions</a>
      <a href="gallery.php" class="block border-b pb-3">Gallery</a>
      <a href="contact.php" class="block border-b pb-3">Contact</a>
    </nav>
  </div>
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const menuBtn = document.getElementById("menuBtn");
      const closeMenu = document.getElementById("closeMenu");
      const mobileMenu = document.getElementById("mobileMenu");
      const overlay = document.getElementById("overlay");
      function openMenu()     { mobileMenu.classList.remove("translate-x-full"); overlay.classList.remove("hidden"); menuBtn.classList.add("open"); }
      function closeSidebar() { mobileMenu.classList.add("translate-x-full");    overlay.classList.add("hidden");    menuBtn.classList.remove("open"); }
      menuBtn.addEventListener("click", openMenu);
      closeMenu.addEventListener("click", closeSidebar);
      overlay.addEventListener("click", closeSidebar);
      mobileMenu.querySelectorAll("a").forEach(l => l.addEventListener("click", closeSidebar));
    });
  </script>
</body>
</html>