<?php
require_once 'connect.php';
$imageRows = $conn->query("SELECT image_name, image_path FROM images");
$images = [];
while ($row = $imageRows->fetch_assoc()) {
    $images[$row['image_name']] = $row['image_path'];
}
function img($images, $key, $fallback = '') {
    return htmlspecialchars($images[$key] ?? $fallback);
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admissions || Dabs Dynamic International Schools</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            keyframes: {
              slideIn: { "0%": { transform: "translateX(-100%)", opacity: 0 }, "100%": { transform: "translateX(0)", opacity: 1 } },
              slideUp: { "0%": { transform: "translateY(50px)", opacity: 0 }, "100%": { transform: "translateY(0)", opacity: 1 } },
              fadeIn: { "0%": { opacity: 0 }, "100%": { opacity: 1 } },
            },
            animation: {
              slideIn: "slideIn 1s forwards",
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
          <img src="dabs-logo.png" alt="Dabs Dynamic International Schools Logo" class="h-16 w-16 object-contain"/>
          <div class="leading-tight">
            <span class="block text-lg font-bold text-green-900">Dabs Dynamic Int'l Schools</span>
            <span class="block text-xs font-medium text-green-700">GOVT. APPROVED • RC NO: 2435402</span>
          </div>
        </div>
        <ul class="hidden md:flex space-x-6 font-medium">
          <li><a href="home.php" class="hover:text-green-700">Home</a></li>
          <li><a href="news.php" class="hover:text-green-700">News</a></li>
          <li><a href="about.php" class="hover:text-green-700">About</a></li>
          <li><a href="academics.php" class="hover:text-green-700">Academics</a></li>
          <li><a href="admissions.php" class="hover:text-green-700 font-bold text-green-900">Admissions</a></li>
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

    <!-- HERO SECTION (Dynamic) -->
    <section class="relative bg-cover bg-center text-white py-32"
      style="background-image: url('<?= img($images, 'admissions_hero', 'hero-bg.jpg') ?>')">
      <div class="absolute inset-0 bg-black/50"></div>
      <div class="relative max-w-5xl mx-auto px-6 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-6">Admissions 2026 Now Open</h1>
        <p class="text-lg md:text-xl max-w-3xl mx-auto text-green-100 mb-8">
          Join a school committed to academic excellence, strong moral values, leadership development, and global competitiveness.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
          <a href="contact.php" class="bg-white text-green-800 px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition shadow-lg">Apply Now</a>
          <a href="#process" class="border border-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-green-800 transition">View Admission Process</a>
        </div>
      </div>
    </section>

    <!-- WHY CHOOSE -->
    <section class="py-20 bg-white">
      <div class="max-w-5xl mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold text-green-800 mb-6">Why Choose Dabs Dynamic?</h2>
        <p class="text-lg text-gray-600 leading-relaxed">
          At Dabs Dynamic International Schools, we provide a well-rounded education built on discipline, integrity, innovation, and excellence. Since 2006, we have consistently prepared students for outstanding performance in both internal and external examinations.
        </p>
      </div>
    </section>

    <!-- CLASSES OFFERED -->
    <section class="bg-gray-50 py-20">
      <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-green-800 text-center mb-12">Classes Offered</h2>
        <div class="grid md:grid-cols-3 gap-8">
          <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition duration-300 border-t-4 border-green-700">
            <h3 class="font-semibold text-xl mb-3 text-green-700">Creche & Nursery</h3>
            <p class="text-gray-600">Early childhood development in a nurturing, safe and stimulating learning environment.</p>
          </div>
          <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition duration-300 border-t-4 border-green-700">
            <h3 class="font-semibold text-xl mb-3 text-green-700">Primary School</h3>
            <p class="text-gray-600">Strong academic foundation combined with moral training, creativity, and ICT integration.</p>
          </div>
          <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition duration-300 border-t-4 border-green-700">
            <h3 class="font-semibold text-xl mb-3 text-green-700">Secondary School</h3>
            <p class="text-gray-600">Preparation for WAEC, NECO and other external examinations, leadership training, and global readiness.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ADMISSION PROCESS -->
    <section id="process" class="py-20 bg-white">
      <div class="max-w-5xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-green-800 text-center mb-12">Admission Process</h2>
        <div class="space-y-8">
          <div class="flex gap-6 items-start">
            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-green-700 text-white font-bold shrink-0">1</div>
            <p class="text-gray-700 text-lg">Visit the school campus for inquiries and registration.</p>
          </div>
          <div class="flex gap-6 items-start">
            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-green-700 text-white font-bold shrink-0">2</div>
            <p class="text-gray-700 text-lg">Obtain and complete the official admission form.</p>
          </div>
          <div class="flex gap-6 items-start">
            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-green-700 text-white font-bold shrink-0">3</div>
            <p class="text-gray-700 text-lg">Submit required documents and attend entrance assessment.</p>
          </div>
          <div class="flex gap-6 items-start">
            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-green-700 text-white font-bold shrink-0">4</div>
            <p class="text-gray-700 text-lg">Receive admission offer and complete enrollment.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- REQUIREMENTS -->
    <section class="bg-gray-50 py-20">
      <div class="max-w-5xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-green-800 text-center mb-12">Admission Requirements</h2>
        <div class="grid md:grid-cols-2 gap-8 text-gray-700 text-lg">
          <div>✔ Completed Admission Form</div>
          <div>✔ Birth Certificate / Age Declaration</div>
          <div>✔ Previous School Report (if applicable)</div>
          <div>✔ Passport Photographs</div>
          <div>✔ Medical Report</div>
        </div>
      </div>
    </section>

    <!-- FAQ -->
    <section class="py-20 bg-gray-50">
      <div class="max-w-5xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-green-800 text-center mb-12">Frequently Asked Questions</h2>
        <div class="space-y-4">
          <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <button class="w-full flex justify-between items-center px-6 py-4 text-left faq-btn font-semibold text-green-800 hover:bg-green-50 transition duration-300">
              What is the age requirement for admission?
              <svg class="faq-icon w-5 h-5 text-green-700 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </button>
            <div class="faq-content px-6 py-4 text-gray-700 hidden">Creche & Nursery: 2–5 years, Primary: 6–11 years, Secondary: 12–17 years.</div>
          </div>
          <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <button class="w-full flex justify-between items-center px-6 py-4 text-left faq-btn font-semibold text-green-800 hover:bg-green-50 transition duration-300">
              Do you offer scholarships or financial aid?
              <svg class="faq-icon w-5 h-5 text-green-700 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </button>
            <div class="faq-content px-6 py-4 text-gray-700 hidden">Yes, scholarships are available for outstanding students. Contact the school for eligibility and application details.</div>
          </div>
          <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <button class="w-full flex justify-between items-center px-6 py-4 text-left faq-btn font-semibold text-green-800 hover:bg-green-50 transition duration-300">
              Can I submit documents online?
              <svg class="faq-icon w-5 h-5 text-green-700 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </button>
            <div class="faq-content px-6 py-4 text-gray-700 hidden">Currently, we accept documents in person. Online submission may be available in future updates.</div>
          </div>
          <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <button class="w-full flex justify-between items-center px-6 py-4 text-left faq-btn font-semibold text-green-800 hover:bg-green-50 transition duration-300">
              How can I schedule a school tour?
              <svg class="faq-icon w-5 h-5 text-green-700 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </button>
            <div class="faq-content px-6 py-4 text-gray-700 hidden">Contact our admissions office via phone or email to schedule a tour of our facilities.</div>
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
          <div><h4 class="text-white font-semibold mb-6 text-lg">About Dabs Dynamic</h4><p class="text-slate-400 leading-relaxed">Since 2006, Dabs Dynamic International Schools has upheld global academic standards while nurturing strong moral values and disciplined leadership.</p></div>
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
        <a href="admissions.php" class="block border-b pb-3 font-bold text-green-900">Admissions</a>
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
      document.querySelectorAll(".faq-btn").forEach(btn => {
        btn.addEventListener("click", () => {
          const content = btn.nextElementSibling;
          const icon = btn.querySelector(".faq-icon");
          content.classList.toggle("hidden");
          icon.style.transform = content.classList.contains("hidden") ? "rotate(0deg)" : "rotate(45deg)";
        });
      });
    </script>
  </body>
</html>