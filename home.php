<?php
require_once 'connect.php';

// Fetch content sections
$contentRows = $conn->query("SELECT section_name, content_text FROM content");
$content = [];
while ($row = $contentRows->fetch_assoc()) {
    $content[$row['section_name']] = $row['content_text'];
}

// Fetch latest 3 news articles
$latestNews = $conn->query("SELECT * FROM news ORDER BY date DESC LIMIT 3");

// Fetch latest 3 gallery images
$galleryPreview = $conn->query("SELECT * FROM gallery ORDER BY date DESC LIMIT 3");

// Fetch images by key name
$imageRows = $conn->query("SELECT image_name, image_path FROM images");
$images = [];
while ($row = $imageRows->fetch_assoc()) {
    $images[$row['image_name']] = $row['image_path'];
}

function c($content, $key, $fallback = '') {
    return htmlspecialchars($content[$key] ?? $fallback);
}
function img($images, $key, $fallback = '') {
    return htmlspecialchars($images[$key] ?? $fallback);
}
?>
<!doctype html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dabs Dynamic International Schools</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          keyframes: {
            slideIn: {"0%":{transform:"translateX(-100%)",opacity:0},"100%":{transform:"translateX(0)",opacity:1}},
            slideUp: {"0%":{transform:"translateY(50px)",opacity:0},"100%":{transform:"translateY(0)",opacity:1}},
            fadeIn:  {"0%":{opacity:0},"100%":{opacity:1}},
          },
          animation: {
            slideIn: "slideIn 1s forwards",
            slideUp: "slideUp 1s 1s forwards",
            fadeIn:  "fadeIn 1.5s 1s forwards",
          },
        },
      },
    };
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
</head>
<body class="font-sans text-gray-800">

<!-- NAVBAR -->
<header class="bg-green-100">
  <nav class="max-w-7xl mx-auto flex items-center justify-between p-4">
    <div class="flex items-center gap-3">
      <img src="dabs-logo.png" alt="Dabs Dynamic International Schools Logo" class="h-16 w-16 object-contain"/>
      <div class="leading-tight">
        <span class="block text-lg font-bold text-green-900">Dabs Dynamic Int'l Schools</span>
        <span class="block text-xs font-medium text-green-700">GOVT. APPROVED • RC NO: 2435402</span>
      </div>
    </div>
    <ul class="hidden md:flex space-x-6 font-medium">
      <li><a href="home.php" class="font-bold text-green-900">Home</a></li>
      <li><a href="news.php" class="hover:text-green-700">News</a></li>
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

<!-- HERO SECTION -->
<section class="relative min-h-screen flex items-center bg-cover bg-center"
  style="background-image: url('<?= img($images, 'hero_banner', 'intro-image.jpg') ?>')">
  <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/60 to-black/80 opacity-0 animate-fadeIn"></div>
  <div class="relative max-w-6xl mx-auto px-6 text-center text-white">
    <h1 class="text-4xl md:text-6xl font-extrabold leading-tight mb-6 opacity-0 animate-slideIn">
      <?= c($content, 'hero_headline', 'Raising Leaders of Tomorrow') ?>
    </h1>
    <p class="text-lg md:text-xl max-w-3xl mx-auto mb-10 opacity-0 animate-slideIn">
      <?= c($content, 'hero_subtext', 'At Dabs Dynamic International Schools, we combine academic excellence, discipline, and strong moral values to shape future global leaders.') ?>
    </p>
    <div class="flex flex-col sm:flex-row justify-center gap-4 opacity-0 animate-slideUp">
      <a href="admissions.php" class="bg-green-700 px-8 py-4 rounded-xl font-semibold shadow-lg hover:bg-green-800 hover:scale-105 transition duration-300">Apply for Admission</a>
      <a href="about.php" class="border border-white px-8 py-4 rounded-xl font-semibold hover:bg-white hover:text-green-800 transition duration-300">Learn More</a>
    </div>
  </div>
</section>

<!-- LATEST NEWS -->
<section class="py-16 bg-green-50">
  <div class="max-w-7xl mx-auto px-4">
    <h3 class="text-3xl font-bold text-center mb-10">Latest News</h3>
    <?php if ($latestNews && $latestNews->num_rows > 0): ?>
      <div class="grid md:grid-cols-3 gap-6">
        <?php while ($n = $latestNews->fetch_assoc()): ?>
          <div class="bg-white rounded-xl shadow p-6 flex flex-col justify-between">
            <?php if (!empty($n['image'])): ?>
              <img src="uploads/<?= htmlspecialchars($n['image']) ?>" alt="<?= htmlspecialchars($n['title']) ?>" class="w-full h-48 object-cover rounded-lg mb-4"/>
            <?php endif; ?>
            <div>
              <p class="text-sm text-gray-400 mb-1"><?= date('F j, Y', strtotime($n['date'])) ?></p>
              <h4 class="font-bold text-xl mb-2"><?= htmlspecialchars($n['title']) ?></h4>
              <p class="text-gray-600 mb-4"><?= htmlspecialchars(substr($n['content'], 0, 100)) ?>...</p>
            </div>
            <a href="news.php" class="mt-auto bg-green-700 text-white px-4 py-2 rounded-lg hover:bg-green-800 transition text-center">Read More</a>
          </div>
        <?php endwhile; ?>
      </div>
    <?php else: ?>
      <p class="text-center text-gray-500">No news available yet. Check back soon!</p>
    <?php endif; ?>
    <div class="text-center mt-10">
      <a href="news.php" class="bg-green-900 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition">View All News</a>
    </div>
  </div>
</section>

<!-- ABOUT SNAPSHOT -->
<section class="py-24 bg-white">
  <div class="max-w-6xl mx-auto px-6">
    <div class="grid md:grid-cols-2 gap-16 items-center">
      <div>
        <h2 class="text-4xl font-bold text-slate-900 mb-6">About Dabs Dynamic International Schools</h2>
        <p class="text-slate-600 leading-relaxed mb-6"><?= c($content, 'about_paragraph_1', '') ?></p>
        <p class="text-slate-600 leading-relaxed mb-8"><?= c($content, 'about_paragraph_2', '') ?></p>
        <a href="about.php" class="inline-block bg-green-700 text-white px-10 py-4 rounded-lg font-semibold hover:bg-green-800 transition duration-300 shadow-md">Learn More About Us</a>
      </div>
      <div>
        <img src="<?= img($images, 'about_photo', 'images/school-building.jpg') ?>" alt="School Building" class="rounded-2xl shadow-xl w-full"/>
      </div>
    </div>
  </div>
</section>

<!-- WHY CHOOSE US -->
<section class="py-24 bg-gray-50">
  <div class="max-w-7xl mx-auto px-6 text-center">
    <h2 class="text-4xl font-bold mb-14">Why Parents Choose Us</h2>
    <div class="grid md:grid-cols-3 gap-8">
      <div class="bg-white p-10 rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-2 transition duration-300">
        <div class="text-green-700 text-3xl mb-4">🎓</div>
        <h4 class="font-semibold text-xl mb-3">Academic Excellence</h4>
        <p class="text-gray-600">Our curriculum ensures strong academic foundations for lifelong success.</p>
      </div>
      <div class="bg-white p-10 rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-2 transition duration-300">
        <div class="text-green-700 text-3xl mb-4">🌍</div>
        <h4 class="font-semibold text-xl mb-3">Global Standards</h4>
        <p class="text-gray-600">We integrate modern teaching methods with international best practices.</p>
      </div>
      <div class="bg-white p-10 rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-2 transition duration-300">
        <div class="text-green-700 text-3xl mb-4">💡</div>
        <h4 class="font-semibold text-xl mb-3">Character Development</h4>
        <p class="text-gray-600">Discipline and moral values are central to our educational philosophy.</p>
      </div>
    </div>
  </div>
</section>

<!-- TESTIMONIALS -->
<section class="py-24 bg-white">
  <div class="max-w-6xl mx-auto px-6 text-center">
    <h2 class="text-4xl font-bold mb-12">What Parents Say</h2>
    <div class="grid md:grid-cols-2 gap-8">
      <div class="bg-gray-50 p-8 rounded-2xl shadow-md">
        <div class="text-green-600 text-4xl mb-4">"</div>
        <p class="text-gray-700 italic mb-6">"As a parent who has seen multiple children pass through Dabs Dynamic, I can confidently say it is a center of excellence. From those who have already graduated to those still in classes, the results have been consistently outstanding. The school doesn’t just teach; they mold characters and build futures."</p>
        <div class="flex items-center justify-center gap-3">
          <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold">C</div>
          <div class="text-left">
            <h4 class="font-semibold text-green-800">Satisfied Parent</h4>
            <p class="text-sm text-gray-500">Mr. Chijindu</p>
          </div>
        </div>
      </div>
      <div class="bg-gray-50 p-8 rounded-2xl shadow-md">
        <div class="text-green-600 text-4xl mb-4">"</div>
        <p class="text-gray-700 italic mb-6">"Watching my children graduate from Dabs Dynamic with such stellar results has been one of my proudest moments as a father. The school didn't just provide an education; they nurtured their souls and sharpened their intellects. Seeing the Godly character and academic brilliance they carry today is a testament to the school's impact. It has been a true blessing to our family."</p>
        <div class="flex items-center justify-center gap-3">
          <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold">DT</div>
          <div class="text-left">
            <h4 class="font-semibold text-green-800">Proud Parent</h4>
            <p class="text-sm text-gray-500">Pastor Dina Tosin</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ACADEMIC LEVELS -->
<section class="py-24 bg-slate-50">
  <div class="max-w-6xl mx-auto px-6 text-center">
    <h2 class="text-4xl font-bold text-slate-900 mb-6">Our Academic Structure</h2>
    <p class="text-slate-600 max-w-3xl mx-auto mb-16">We provide a comprehensive educational pathway designed to guide students from foundational learning to advanced academic excellence.</p>
    <div class="grid md:grid-cols-3 gap-10">
      <div class="bg-white p-10 rounded-2xl shadow-md hover:shadow-xl transition">
        <h3 class="text-2xl font-semibold text-slate-900 mb-4">Early Years</h3>
        <p class="text-slate-600 leading-relaxed">Our early childhood programme builds strong foundations in literacy, numeracy, creativity, and social development.</p>
      </div>
      <div class="bg-white p-10 rounded-2xl shadow-md hover:shadow-xl transition">
        <h3 class="text-2xl font-semibold text-slate-900 mb-4">Primary School</h3>
        <p class="text-slate-600 leading-relaxed">We cultivate intellectual curiosity and independent thinking, equipping pupils with essential academic skills and strong character values.</p>
      </div>
      <div class="bg-white p-10 rounded-2xl shadow-md hover:shadow-xl transition">
        <h3 class="text-2xl font-semibold text-slate-900 mb-4">Secondary School</h3>
        <p class="text-slate-600 leading-relaxed">Our secondary programme prepares students for global examinations and higher education through rigorous academics and leadership training.</p>
      </div>
    </div>
  </div>
</section>

<!-- GALLERY PREVIEW -->
<section class="py-24 bg-gray-50">
  <div class="max-w-7xl mx-auto px-6">
    <div class="text-center mb-16">
      <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Life at Dabs Dynamic</h3>
      <p class="text-gray-600">A glimpse into our vibrant academic and extracurricular activities.</p>
    </div>
    <?php if ($galleryPreview && $galleryPreview->num_rows > 0): ?>
      <div class="grid md:grid-cols-3 gap-6">
        <?php while ($g = $galleryPreview->fetch_assoc()): ?>
          <img src="uploads/<?= htmlspecialchars($g['image']) ?>" alt="<?= htmlspecialchars($g['title']) ?>"
            class="rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-1 transition duration-300 w-full h-64 object-cover"/>
        <?php endwhile; ?>
      </div>
    <?php else: ?>
      <p class="text-center text-gray-500">No gallery images yet.</p>
    <?php endif; ?>
    <div class="text-center mt-12">
      <a href="gallery.php" class="text-green-700 font-semibold hover:text-green-900 transition">View Full Gallery →</a>
    </div>
  </div>
</section>

<!-- STATISTICS -->
<section class="py-16 bg-gray-100 text-gray-800">
  <div class="max-w-6xl mx-auto px-6">
    <div class="text-center mb-12">
      <h2 class="text-3xl font-bold mb-4">Our Growth & Stability</h2>
      <p class="text-gray-600">Building a strong academic foundation since 2006.</p>
    </div>
    <div class="grid md:grid-cols-4 gap-10 text-center">
      <!-- Established -->
      <div>
        <div class="flex justify-center mb-4">
          <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <rect x="3" y="4" width="18" height="18" rx="2"/>
            <line x1="16" y1="2" x2="16" y2="6"/>
            <line x1="8" y1="2" x2="8" y2="6"/>
          </svg>
        </div>
        <h3 class="text-3xl font-bold counter" data-target="2006">0</h3>
        <p class="text-gray-600 mt-2">Year Established</p>
      </div>
      <!-- Years -->
      <div>
        <div class="flex justify-center mb-4">
          <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"/>
            <polyline points="12 6 12 12 16 14"/>
          </svg>
        </div>
        <h3 class="text-3xl font-bold counter" data-target="20">0</h3>
        <p class="text-gray-600 mt-2">Years of Service</p>
      </div>
      <!-- Staff -->
      <div>
        <div class="flex justify-center mb-4">
          <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M17 21v-2a4 4 0 0 0-3-3.87"/>
            <path d="M7 21v-2a4 4 0 0 1 3-3.87"/>
            <circle cx="12" cy="7" r="4"/>
          </svg>
        </div>
        <h3 class="text-3xl font-bold counter" data-target="50">0</h3>
        <p class="text-gray-600 mt-2">Qualified Staff</p>
      </div>
      <!-- Graduates -->
      <div>
        <div class="flex justify-center mb-4">
          <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="12" cy="8" r="7"/>
            <polyline points="8 21 12 17 16 21"/>
          </svg>
        </div>
        <h3 class="text-3xl font-bold counter" data-target="500 ">0</h3>
        <p class="text-gray-600 mt-2">Graduates</p>
      </div>
    </div>
  </div>
</section>

<!-- PRE FOOTER -->
<section class="bg-green-900 text-white py-6">
  <div class="max-w-7xl mx-auto px-6">
    <div class="text-center mb-20">
      <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Excellence. Discipline. Leadership.</h2>
      <p class="max-w-2xl mx-auto text-slate-400 mb-8">Join a community dedicated to shaping confident, disciplined, and globally competitive leaders.</p>
      <a href="admissions.php" class="inline-block bg-gradient-to-r from-green-600 to-green-800 text-white px-12 py-4 rounded-xl font-semibold text-lg shadow-lg hover:scale-105 transition-transform duration-300">
            Begin Admission Process
          </a></div>  
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
        <h4 class="text-white font-semibold mb-6 text-lg">Stay Connected</h4>
        <form class="flex flex-col space-y-4 mb-8">
          <input type="email" placeholder="Enter your email address" class="px-4 py-3 rounded-lg bg-slate-800 border border-slate-700 text-white focus:outline-none focus:ring-2 focus:ring-green-400"/>
          <button type="submit" class="bg-green-700 text-white py-3 rounded-lg font-semibold hover:bg-green-800 transition">Subscribe</button>
        </form>
        <div class="flex space-x-4 justify-center">
          <a href="#" class="w-11 h-11 flex items-center justify-center rounded-xl bg-black hover:opacity-90 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" viewBox="0 0 256 256">
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

<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40 transition-opacity duration-300"></div>
<div id="mobileMenu" class="fixed top-0 right-0 h-full w-80 bg-white shadow-xl transform translate-x-full transition-transform duration-300 ease-in-out z-50">
  <div class="flex items-center justify-between px-5 py-4 border-b bg-green-100">
    <span class="font-bold text-green-900">Menu</span>
    <button id="closeMenu" class="w-8 h-8 flex items-center justify-center bg-green-700 text-white rounded-full hover:bg-green-800 transition">✕</button>
  </div>
  <nav class="px-6 py-6 space-y-6 font-medium text-gray-700">
    <a href="home.php" class="block border-b pb-3">Home</a>
    <a href="news.php" class="block border-b pb-3">News</a>
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
    function openMenu(){ mobileMenu.classList.remove("translate-x-full"); overlay.classList.remove("hidden"); menuBtn.classList.add("open"); }
    function closeSidebar(){ mobileMenu.classList.add("translate-x-full"); overlay.classList.add("hidden"); menuBtn.classList.remove("open"); }
    menuBtn.addEventListener("click", openMenu);
    closeMenu.addEventListener("click", closeSidebar);
    overlay.addEventListener("click", closeSidebar);
    mobileMenu.querySelectorAll("a").forEach(l => l.addEventListener("click", closeSidebar));
  });

  // Counter animation
  const counters = document.querySelectorAll(".counter");
  const animateCounters = () => {
    counters.forEach(counter => {
      const update = () => {
        const target = +counter.getAttribute("data-target");
        const count = +counter.innerText;
        const inc = target / 200;
        if (count < target){ counter.innerText = Math.ceil(count + inc); setTimeout(update, 20); }
        else { counter.innerText = target; }
      };
      update();
    });
  };
  const cObserver = new IntersectionObserver(entries => {
    entries.forEach(e => { if(e.isIntersecting){ animateCounters(); cObserver.disconnect(); } });
  });
  cObserver.observe(document.querySelector(".counter").closest("section"));
</script>
</body>
</html>