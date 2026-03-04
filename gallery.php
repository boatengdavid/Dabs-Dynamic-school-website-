<?php require_once 'connect.php'; ?>
<?php
// Fetch all gallery images from database, newest first
$gallery = [];
$result = $conn->query("SELECT * FROM gallery ORDER BY date DESC");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $gallery[] = $row;
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gallery | Dabs Dynamic International Schools</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            keyframes: {
              slideIn: { "0%": { transform: "translateX(-100%)", opacity: 0 }, "100%": { transform: "translateX(0)", opacity: 1 } },
              slideInDelay: { "0%": { transform: "translateX(100%)", opacity: 0 }, "100%": { transform: "translateX(0)", opacity: 1 } },
              slideUp: { "0%": { transform: "translateY(50px)", opacity: 0 }, "100%": { transform: "translateY(0)", opacity: 1 } },
              fadeIn: { "0%": { opacity: 0 }, "100%": { opacity: 1 } },
            },
            animation: {
              slideIn: "slideIn 1s forwards",
              slideInDelay: "slideInDelay 1s 0.5s forwards",
              slideUp: "slideUp 1s 1s forwards",
              fadeIn: "fadeIn 1.5s 1s forwards",
            },
          },
        },
      };
    </script>
  </head>
  <body class="font-sans text-gray-800">
    <!-- NAVBAR -->
    <header class="bg-green-100">
      <nav class="max-w-7xl mx-auto flex items-center justify-between p-4">
        <div class="flex items-center gap-3">
          <img src="dabs-logo.png" alt="Dabs Dynamic International Schools Logo" class="h-16 w-16 object-contain" />
          <div class="leading-tight">
            <span class="block text-lg font-bold text-green-900">Dabs Dynamic Int'l Schools</span>
            <span class="block text-xs font-medium text-green-700">GOVT. APPROVED • RC NO: 2435402</span>
          </div>
        </div>

        <ul class="hidden md:flex space-x-6 font-medium">
          <li><a href="index.php" class="hover:text-green-700">Home</a></li>
          <li><a href="news.php" class="hover:text-green-700">News</a></li>
          <li><a href="about.php" class="hover:text-green-700">About</a></li>
          <li><a href="academics.php" class="hover:text-green-700">Academics</a></li>
          <li><a href="admissions.php" class="hover:text-green-700">Admissions</a></li>
          <li><a href="gallery.php" class="hover:text-green-700 font-bold text-green-900">Gallery</a></li>
          <li><a href="contact.php" class="hover:text-green-700">Contact</a></li>
        </ul>

        <button id="menuBtn" class="md:hidden relative w-7 h-7 flex items-center justify-center focus:outline-none">
          <span class="bar absolute w-6 h-0.5 bg-green-900 transition-all duration-300"></span>
          <span class="bar absolute w-6 h-0.5 bg-green-900 transition-all duration-300"></span>
          <span class="bar absolute w-6 h-0.5 bg-green-900 transition-all duration-300"></span>
        </button>
      </nav>
    </header>

    <!-- INTRO -->
    <section class="bg-green-900 text-white py-32 text-center relative overflow-hidden">
      <div class="max-w-4xl mx-auto px-6" data-aos="fade-up">
        <h1 class="text-5xl font-bold mb-6">Explore Life at Dabs Dynamic International Schools</h1>
        <p class="text-lg text-green-200">Celebrating Academic Excellence, Sports, and Vibrant School Life</p>
      </div>
    </section>

    <!-- CATEGORIES FILTER -->
    <section class="py-12 bg-green-50">
      <div class="max-w-6xl mx-auto px-6 text-center">
        <div class="flex flex-wrap justify-center gap-4">
          <button class="px-6 py-2 bg-green-700 text-white rounded-full hover:bg-green-800 transition filter-btn" data-filter="all">All</button>
          <button class="px-6 py-2 bg-green-100 text-green-900 rounded-full hover:bg-green-200 transition filter-btn" data-filter="academics">Academics</button>
          <button class="px-6 py-2 bg-green-100 text-green-900 rounded-full hover:bg-green-200 transition filter-btn" data-filter="sports">Sports</button>
          <button class="px-6 py-2 bg-green-100 text-green-900 rounded-full hover:bg-green-200 transition filter-btn" data-filter="cultural">Cultural Events</button>
          <button class="px-6 py-2 bg-green-100 text-green-900 rounded-full hover:bg-green-200 transition filter-btn" data-filter="campus">Campus Life</button>
        </div>
      </div>
    </section>

    <!-- GALLERY GRID -->
    <section class="py-16 bg-white">
      <div class="max-w-6xl mx-auto px-6">
        <?php if (count($gallery) > 0): ?>
          <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6" id="galleryGrid">
            <?php foreach ($gallery as $item): ?>
              <div
                class="overflow-hidden rounded-xl shadow-lg transition transform"
                data-category="<?= htmlspecialchars($item['category']) ?>"
                data-aos="fade-up"
              >
                <img
                  src="uploads/<?= htmlspecialchars($item['image']) ?>"
                  alt="<?= htmlspecialchars($item['title']) ?>"
                  class="w-full h-64 object-cover transition duration-500 hover:scale-110"
                />
                <div class="p-4 text-center">
                  <h3 class="font-bold text-green-900"><?= htmlspecialchars($item['title']) ?></h3>
                  <p class="text-sm text-gray-600">
                    <?= date('M Y', strtotime($item['date'])) ?> • <?= ucfirst(htmlspecialchars($item['category'])) ?>
                  </p>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <div id="galleryGrid" class="text-center py-20 text-gray-500">
            <p class="text-xl">No gallery images available yet.</p>
            <p class="text-sm mt-2">Check back soon for updates!</p>
          </div>
        <?php endif; ?>
      </div>
    </section>

    <!-- ================= PRE FOOTER ================= -->
    <section class="bg-green-900 text-white py-6">
      <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-20">
          <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Excellence. Discipline. Leadership.</h2>
          <p class="max-w-2xl mx-auto text-slate-400 mb-8">
            Join a community dedicated to shaping confident, disciplined, and globally competitive leaders.
          </p>
          <a href="admissions.php" class="inline-block bg-gradient-to-r from-green-600 to-green-800 text-white px-12 py-4 rounded-xl font-semibold text-lg shadow-lg hover:scale-105 transition-transform duration-300">
            Begin Admission Process
          </a>
        </div>

        <div class="border-t border-slate-700 mb-16"></div>

        <div class="grid md:grid-cols-3 gap-12">
          <div>
            <h4 class="text-white font-semibold mb-6 text-lg">About Dabs Dynamic</h4>
            <p class="text-slate-400 leading-relaxed">
              Since 2006, Dabs Dynamic International Schools has upheld global academic standards while nurturing strong moral values and disciplined leadership.
            </p>
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
            <h4 class="text-white font-semibold mb-6 text-lg">Stay Connected</h4>
            <form class="flex flex-col space-y-4 mb-8">
              <input type="email" placeholder="Enter your email address" class="px-4 py-3 rounded-lg bg-slate-800 border border-slate-700 text-white focus:outline-none focus:ring-2 focus:ring-green-400" />
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
      #menuBtn .bar:nth-child(1) { top: 8px; }
      #menuBtn .bar:nth-child(2) { top: 13px; }
      #menuBtn .bar:nth-child(3) { top: 18px; }
      #menuBtn.open .bar:nth-child(1) { transform: rotate(45deg); top: 13px; }
      #menuBtn.open .bar:nth-child(2) { opacity: 0; }
      #menuBtn.open .bar:nth-child(3) { transform: rotate(-45deg); top: 13px; }
    </style>

    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40 transition-opacity duration-300"></div>

    <div id="mobileMenu" class="fixed top-0 right-0 h-full w-80 bg-white shadow-xl transform translate-x-full transition-transform duration-300 ease-in-out z-50">
      <div class="flex items-center justify-between px-5 py-4 border-b bg-green-100">
        <span class="font-bold text-green-900">Menu</span>
        <button id="closeMenu" class="w-8 h-8 flex items-center justify-center bg-green-700 text-white rounded-full hover:bg-green-800 transition">✕</button>
      </div>
      <nav class="px-6 py-6 space-y-6 font-medium text-gray-700">
        <a href="index.php" class="block border-b pb-3">Home</a>
        <a href="news.php" class="block border-b pb-3">News</a>
        <a href="about.php" class="block border-b pb-3">About</a>
        <a href="academics.php" class="block border-b pb-3">Academics</a>
        <a href="admissions.php" class="block border-b pb-3">Admissions</a>
        <a href="gallery.php" class="block border-b pb-3 font-bold text-green-900">Gallery</a>
        <a href="contact.php" class="block border-b pb-3">Contact</a>
      </nav>
    </div>

    <script>
      document.addEventListener("DOMContentLoaded", () => {
        const menuBtn = document.getElementById("menuBtn");
        const closeMenu = document.getElementById("closeMenu");
        const mobileMenu = document.getElementById("mobileMenu");
        const overlay = document.getElementById("overlay");

        function openMenu() {
          mobileMenu.classList.remove("translate-x-full");
          overlay.classList.remove("hidden");
          menuBtn.classList.add("open");
        }
        function closeSidebar() {
          mobileMenu.classList.add("translate-x-full");
          overlay.classList.add("hidden");
          menuBtn.classList.remove("open");
        }

        menuBtn.addEventListener("click", openMenu);
        closeMenu.addEventListener("click", closeSidebar);
        overlay.addEventListener("click", closeSidebar);
        mobileMenu.querySelectorAll("a").forEach((link) => {
          link.addEventListener("click", closeSidebar);
        });
      });
    </script>

    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
      AOS.init({ duration: 1000, once: true });

      const filterBtns = document.querySelectorAll(".filter-btn");
      const galleryItems = document.querySelectorAll("#galleryGrid > div");

      filterBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
          const filter = btn.dataset.filter;
          galleryItems.forEach((item) => {
            if (filter === "all" || item.dataset.category === filter) {
              item.classList.remove("hidden");
            } else {
              item.classList.add("hidden");
            }
          });
          filterBtns.forEach((b) => b.classList.replace("bg-green-700", "bg-green-100"));
          btn.classList.add("bg-green-700", "text-white");
        });
      });
    </script>
  </body>
</html>