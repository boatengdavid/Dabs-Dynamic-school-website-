<?php require_once 'connect.php'; ?>
<?php
$news = [];
$result = $conn->query("SELECT * FROM news ORDER BY date DESC");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $news[] = $row;
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>News | Dabs Dynamic International Schools</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="description" content="Stay updated with the latest news, events, and achievements from Dabs Dynamic International Schools." />
    <meta name="keywords" content="Dabs School News, School Events, Education Updates Nigeria" />
    <meta property="og:title" content="News | Dabs Dynamic International Schools" />
    <meta property="og:description" content="Latest happenings and announcements from Dabs Dynamic International Schools." />
    <meta property="og:type" content="website" />
  </head>

  <body class="font-sans text-gray-800">

    <!-- NAVBAR -->
    <header class="bg-green-100">
      <nav class="max-w-7xl mx-auto flex items-center justify-between p-4">
        <div class="flex items-center gap-3">
          <img src="dabs-logo.png" class="h-16 w-16 object-contain" alt="Dabs Logo" />
          <div class="leading-tight">
            <span class="block text-lg font-bold text-green-900">Dabs Dynamic Int'l Schools</span>
            <span class="block text-xs font-medium text-green-700">GOVT. APPROVED • RC NO: 2435402</span>
          </div>
        </div>
        <ul class="hidden md:flex space-x-6 font-medium">
          <li><a href="home.php" class="hover:text-green-700">Home</a></li>
          <li><a href="news.php" class="hover:text-green-700 font-bold text-green-900">News</a></li>
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

    <!-- PAGE TITLE -->
    <section class="relative bg-green-900 text-white py-24 text-center overflow-hidden">
      <div class="absolute inset-0 opacity-10 bg-[url('intro-image.jpg')] bg-cover bg-center"></div>
      <div class="relative z-10 max-w-4xl mx-auto px-4">
        <h1 class="text-4xl md:text-5xl font-bold mb-6 tracking-tight">News & Updates</h1>
        <p class="text-lg md:text-xl text-green-100">Discover the latest events, achievements, and important announcements from Dabs Dynamic International Schools.</p>
      </div>
    </section>

    <!-- NEWS GRID -->
    <section class="py-24 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4">
        <?php if (count($news) > 0): ?>
          <div class="grid md:grid-cols-3 gap-10">
            <?php foreach ($news as $item): ?>
              <a href="news-detail.php?id=<?= $item['id'] ?>"
                 class="news-item group bg-white rounded-2xl shadow-md hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 overflow-hidden block"
                 data-date="<?= htmlspecialchars($item['date']) ?>"
                 data-title="<?= htmlspecialchars($item['title']) ?>">

                <!-- Image -->
                <div class="overflow-hidden relative">
                  <?php if (!empty($item['image'])): ?>
                    <img
                      src="<?= (strpos($item['image'], 'uploads/') === 0 ? '' : 'uploads/') . htmlspecialchars($item['image']) ?>"
                      alt="<?= htmlspecialchars($item['title']) ?>"
                      class="w-full h-52 object-cover transition-transform duration-500 group-hover:scale-110"
                    />
                  <?php else: ?>
                    <div class="w-full h-52 bg-green-50 flex items-center justify-center text-5xl text-green-200">📰</div>
                  <?php endif; ?>
                  <!-- Date badge over image -->
                  <div class="absolute top-3 left-3 bg-green-800 text-white text-xs font-semibold px-3 py-1 rounded-full">
                    <?= date('M j, Y', strtotime($item['date'])) ?>
                  </div>
                </div>

                <!-- Card body -->
                <div class="p-6">
                  <h3 class="text-xl font-bold mb-4 text-gray-900 group-hover:text-green-800 transition">
                    <?= htmlspecialchars($item['title']) ?>
                  </h3>
                  <span class="inline-flex items-center gap-1 text-sm text-green-700 font-semibold">
                    Read full article
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                  </span>
                </div>
              </a>
            <?php endforeach; ?>
          </div>

        <?php else: ?>
          <div class="text-center py-20 text-gray-500">
            <p class="text-xl">No news articles available yet.</p>
            <p class="text-sm mt-2">Check back soon for updates!</p>
          </div>
        <?php endif; ?>
      </div>
    </section>

    <!-- SCHOOL STATS -->
    <section class="py-24 bg-white">
      <div class="max-w-7xl mx-auto px-6 text-center">
        <h3 class="text-3xl md:text-4xl font-bold mb-16 text-gray-900">Our Impact in Numbers</h3>
        <div class="grid md:grid-cols-4 gap-12">
          <div><h4 class="text-4xl font-bold text-green-700 mb-2">20+</h4><p class="text-gray-600">Years of Excellence</p></div>
          <div><h4 class="text-4xl font-bold text-green-700 mb-2">1,000+</h4><p class="text-gray-600">Students Enrolled</p></div>
          <div><h4 class="text-4xl font-bold text-green-700 mb-2">100%</h4><p class="text-gray-600">Examination Success</p></div>
          <div><h4 class="text-4xl font-bold text-green-700 mb-2">50+</h4><p class="text-gray-600">Qualified Teachers</p></div>
        </div>
      </div>
    </section>

    <!-- ADMISSION CTA -->
    <section class="bg-green-900 text-white py-24 text-center">
      <div class="max-w-4xl mx-auto px-6">
        <h3 class="text-3xl md:text-4xl font-bold mb-6">Admissions Open for 2026 Academic Session</h3>
        <p class="text-lg text-green-100 mb-10">Give your child the advantage of a disciplined, value-driven, and globally competitive education.</p>
        <a href="admissions.php" class="bg-white text-green-900 font-semibold px-8 py-4 rounded-full hover:bg-green-100 transition duration-300">Apply Now</a>
      </div>
    </section>

    <!-- PRE FOOTER -->
    <section class="bg-green-900 text-white py-6">
      <div class="max-w-7xl mx-auto px-6">
        <div class="border-t border-slate-700 mb-16"></div>
        <div class="grid md:grid-cols-3 gap-12">
          <div>
            <h4 class="text-white font-semibold mb-6 text-lg">About Dabs Dynamic</h4>
            <p class="text-slate-400 leading-relaxed">Since 2006, Dabs Dynamic International Schools has upheld global academic standards while nurturing strong moral values and disciplined leadership.</p>
          </div>
          <div>
            <h4 class="text-white font-semibold mb-6 text-lg">Quick Links</h4>
            <ul class="space-y-3 text-slate-400">
              <li><a href="about.php" class="hover:text-amber-400 transition">About</a></li>
              <li><a href="academics.php" class="hover:text-amber-400 transition">Academics</a></li>
              <li><a href="admissions.php" class="hover:text-amber-400 transition">Admissions</a></li>
              <li><a href="news.php" class="hover:text-amber-400 transition">News</a></li>
              <li><a href="contact.php" class="hover:text-amber-400 transition">Contact</a></li>
            </ul>
          </div>
          <div>
            <h4 class="text-white font-semibold mb-6 text-lg">Join the DABS SCHOOL Community</h4>
            <p class="text-slate-400 leading-relaxed">Sign up for our newsletter to stay connected with our students, faculty, and latest happenings.</p>
            <form class="flex flex-col space-y-4 mb-8">
              <input type="email" placeholder="Enter your email address" class="px-4 py-3 rounded-lg bg-slate-800 border border-slate-700 text-white focus:outline-none focus:ring-2 focus:ring-green-400"/>
              <button type="submit" class="bg-green-700 text-white py-3 rounded-lg font-semibold hover:bg-green-800 transition">Subscribe</button>
            </form>
            <div class="flex space-x-4 justify-center">
              <a href="#" class="w-11 h-11 flex items-center justify-center rounded-xl bg-black hover:opacity-90 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 relative" viewBox="0 0 256 256">
                  <path d="M204.72 48.35a92.45 92.45 0 01-54.3-17.61v97.12a40.08 40.08 0 11-40-40V50.12a92.45 92.45 0 1154.3 17.61V128a92.44 92.44 0 0055.6-79.65z" fill="#69C9D0"/>
                  <path d="M204.72 48.35a92.45 92.45 0 01-54.3-17.61v97.12a40.08 40.08 0 11-40-40V50.12a92.45 92.45 0 1154.3 17.61V128a92.44 92.44 0 0055.6-79.65z" fill="#EE1D52" transform="translate(-2,0)"/>
                  <path d="M204.72 48.35a92.45 92.45 0 01-54.3-17.61v97.12a40.08 40.08 0 11-40-40V50.12a92.45 92.45 0 1154.3 17.61V128a92.44 92.44 0 0055.6-79.65z" fill="white" transform="translate(-1,0)"/>
                </svg>
              </a>
              <a href="#" class="w-11 h-11 flex items-center justify-center rounded-xl bg-gradient-to-tr from-[#feda75] via-[#d62976] to-[#4f5bd5] hover:opacity-90 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 fill-white" viewBox="0 0 24 24">
                  <path d="M7 2C4.24 2 2 4.24 2 7v10c0 2.76 2.24 5 5 5h10c2.76 0 5-2.24 5-5V7c0-2.76-2.24-5-5-5H7zm5 4a5 5 0 110 10 5 5 0 010-10zm6.5-.75a1.25 1.25 0 110 2.5 1.25 1.25 0 010-2.5z"/>
                </svg>
              </a>
              <a href="#" class="w-11 h-11 flex items-center justify-center rounded-xl bg-[#1877F2] hover:opacity-90 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 fill-white" viewBox="0 0 24 24">
                  <path d="M22 12a10 10 0 10-11.63 9.87v-6.99H7.9V12h2.47V9.8c0-2.43 1.45-3.78 3.68-3.78 1.07 0 2.18.19 2.18.19v2.4h-1.23c-1.21 0-1.59.75-1.59 1.52V12h2.71l-.43 2.88h-2.28v6.99A10 10 0 0022 12z"/>
                </svg>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <div class="h-[1px] bg-white"></div>
    <footer class="bg-green-900 text-white py-6">
      <div class="max-w-7xl mx-auto px-4 text-center">
        <p class="text-sm text-green-200">Knowledge Cum Discipline © 2006 – 2026 | All Rights Reserved</p>
      </div>
    </footer>

    <style>
      #menuBtn .bar:nth-child(1){top:8px} #menuBtn .bar:nth-child(2){top:13px} #menuBtn .bar:nth-child(3){top:18px}
      #menuBtn.open .bar:nth-child(1){transform:rotate(45deg);top:13px}
      #menuBtn.open .bar:nth-child(2){opacity:0}
      #menuBtn.open .bar:nth-child(3){transform:rotate(-45deg);top:13px}
    </style>
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>
    <div id="mobileMenu" class="fixed top-0 right-0 h-full w-80 bg-white shadow-xl transform translate-x-full transition-transform duration-300 z-50">
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
        const menuBtn   = document.getElementById("menuBtn");
        const closeMenu = document.getElementById("closeMenu");
        const mobileMenu = document.getElementById("mobileMenu");
        const overlay   = document.getElementById("overlay");
        function openMenu()    { mobileMenu.classList.remove("translate-x-full"); overlay.classList.remove("hidden"); menuBtn.classList.add("open"); }
        function closeSidebar(){ mobileMenu.classList.add("translate-x-full");    overlay.classList.add("hidden");    menuBtn.classList.remove("open"); }
        menuBtn.addEventListener("click", openMenu);
        closeMenu.addEventListener("click", closeSidebar);
        overlay.addEventListener("click", closeSidebar);
      });

      // Scroll animation
      const cards = document.querySelectorAll(".news-item");
      const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) entry.target.classList.add("opacity-100", "translate-y-0");
        });
      }, { threshold: 0.1 });
      cards.forEach((card) => {
        card.classList.add("opacity-0", "translate-y-6", "transition-all", "duration-700");
        observer.observe(card);
      });
    </script>
  </body>
</html>