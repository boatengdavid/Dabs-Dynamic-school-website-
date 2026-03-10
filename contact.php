<?php
require_once 'connect.php';

// Fetch contact content
$contentRows = $conn->query("SELECT section_name, content_text FROM content WHERE section_name IN ('contact_phone','contact_email','contact_address_1','contact_address_2')");
$content = [];
while ($row = $contentRows->fetch_assoc()) {
    $content[$row['section_name']] = $row['content_text'];
}
function c($content, $key, $fallback = '') {
    return htmlspecialchars($content[$key] ?? $fallback);
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact | Dabs Dynamic International Schools</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            keyframes: {
              slideIn: { "0%": { transform: "translateX(-100%)", opacity: 0 }, "100%": { transform: "translateX(0)", opacity: 1 } },
              fadeIn: { "0%": { opacity: 0 }, "100%": { opacity: 1 } },
            },
            animation: {
              slideIn: "slideIn 1s forwards",
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
          <li><a href="admissions.php" class="hover:text-green-700">Admissions</a></li>
          <li><a href="gallery.php" class="hover:text-green-700">Gallery</a></li>
          <li><a href="contact.php" class="hover:text-green-700 font-bold text-green-900">Contact</a></li>
        </ul>
        <button id="menuBtn" class="md:hidden relative w-7 h-7 flex items-center justify-center focus:outline-none">
          <span class="bar absolute w-6 h-0.5 bg-green-900 transition-all duration-300"></span>
          <span class="bar absolute w-6 h-0.5 bg-green-900 transition-all duration-300"></span>
          <span class="bar absolute w-6 h-0.5 bg-green-900 transition-all duration-300"></span>
        </button>
      </nav>
    </header>

    <!-- INTRO -->
    <section class="relative bg-gradient-to-r from-green-50 via-green-100 to-green-50 py-20 overflow-hidden">
      <div class="max-w-4xl mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold text-green-900 mb-4 bg-clip-text text-transparent bg-gradient-to-r from-green-800 to-green-600 animate-slideIn">Contact Us</h1>
        <p class="text-lg text-black animate-fadeIn">We are always happy to hear from parents, guardians, and visitors. Reach out for enquiries, admissions, or general information.</p>
      </div>
    </section>

    <!-- LOCATION / MAP -->
    <section class="w-full bg-green-900 text-white py-6 overflow-hidden">
      <div class="text-center py-20 px-6 max-w-4xl mx-auto opacity-0 translate-y-10 transition duration-1000 ease-out location-animate">
        <h2 class="text-4xl md:text-5xl font-bold mb-6 tracking-tight">Visit Our Campus</h2>
        <p class="text-slate-300 text-lg leading-relaxed">Discover an environment designed to nurture excellence, leadership, and global impact.</p>
      </div>
      <div class="relative w-full h-[550px]">
        <iframe src="https://www.google.com/maps/embed?pb=YOUR_GOOGLE_MAP_EMBED_LINK" class="absolute inset-0 w-full h-full" style="border:0" allowfullscreen="" loading="lazy"></iframe>
        <div class="absolute inset-0 bg-green-900 text-white py-6 opacity-80"></div>
        <div class="absolute bottom-12 left-1/2 transform -translate-x-1/2 w-[90%] max-w-5xl bg-white/95 backdrop-blur-md text-slate-900 rounded-3xl shadow-2xl p-10 opacity-0 translate-y-10 transition duration-1000 ease-out location-animate">
          <div class="grid md:grid-cols-4 gap-8 items-center">
            <div>
              <h4 class="font-semibold text-lg mb-2">Address</h4>
              <p class="text-sm text-slate-600 leading-relaxed"><?= c($content, 'contact_address_1', '32, Segun Falana Street, Behind MFM, Along Mowe, Ogun State') ?></p>
            </div>
            <div>
              <h4 class="font-semibold text-lg mb-2">Call Us</h4>
              <p class="text-sm text-slate-600"><?= c($content, 'contact_phone', '07030746293 / 08030449893') ?></p>
            </div>
            <div>
              <h4 class="font-semibold text-lg mb-2">Email</h4>
              <p class="text-sm text-slate-600"><?= c($content, 'contact_email', 'dabsintschool@gmail.com') ?></p>
            </div>
            <div class="text-center md:text-right">
              <a href="https://maps.google.com" target="_blank" class="inline-block bg-slate-900 text-white px-6 py-3 rounded-full text-sm font-semibold tracking-wide hover:bg-slate-700 transition duration-300 shadow-lg">Get Directions →</a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- GET IN TOUCH (Dynamic text) -->
    <section class="py-16">
      <div class="max-w-6xl mx-auto px-4 grid md:grid-cols-2 gap-10">
        <div>
          <h2 class="text-2xl font-bold text-green-700 mb-6">Get in Touch</h2>
          <div class="space-y-4">
            <p>
              <strong>Phone:</strong><br/>
              <?= c($content, 'contact_phone', '07030746293 / 08030449893') ?>
            </p>
            <p>
              <strong>Email:</strong><br/>
              <?= c($content, 'contact_email', 'dabsintschool@gmail.com') ?>
            </p>
            <p>
              <strong>School Locations:</strong><br/>
              <span class="block mt-2">
                <strong>School 1:</strong><br/>
                <?= c($content, 'contact_address_1', '32, Segun Falana Street, Behind MFM, Along Mowe, Ogun State') ?>
              </span>
              <span class="block mt-3">
                <strong>School 2:</strong><br/>
                <?= c($content, 'contact_address_2', 'Abule-Ori Road, Omu Aleku, Mowe, Ogun State') ?>
              </span>
            </p>
            <p><strong>Social Media:</strong><br/>Facebook & TikTok — <em>Dabs Dynamic Schools</em></p>
          </div>
        </div>

        <!-- CONTACT FORM -->
        <div class="bg-white/90 backdrop-blur-md p-10 rounded-3xl shadow-2xl">
          <h2 class="text-3xl font-bold text-green-900 mb-6">Send Us a Message</h2>
          <form id="whatsappForm" class="space-y-6">
            <input id="name" type="text" placeholder="Full Name" class="w-full px-5 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-green-400 focus:outline-none shadow-sm"/>
            <textarea id="message" placeholder="Your message..." rows="5" class="w-full px-5 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-green-400 focus:outline-none shadow-sm"></textarea>
            <button type="submit" class="w-full py-3 rounded-full bg-green-700 text-white font-bold hover:bg-green-800 shadow-lg transition-all duration-300 transform hover:scale-105">Send Message</button>
          </form>
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
            <h4 class="text-white font-semibold mb-6 text-lg">Join the DABS SCHOOL Community</h4>
            <p class="text-slate-400 leading-relaxed">Sign up for our newsletter to stay connected with our students, faculty, and latest happenings.</p>
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
        <a href="admissions.php" class="block border-b pb-3">Admissions</a>
        <a href="gallery.php" class="block border-b pb-3">Gallery</a>
        <a href="contact.php" class="block border-b pb-3 font-bold text-green-900">Contact</a>
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

      document.getElementById("whatsappForm").addEventListener("submit", function(e) {
        e.preventDefault();
        const name = document.getElementById("name").value.trim();
        const message = document.getElementById("message").value.trim();
        if (!name || !message) { alert("Please fill out both fields."); return; }
        const adminNumber = "2348030449893";
        window.open(`https://wa.me/${adminNumber}?text=${encodeURIComponent(`Hello, my name is ${name}. ${message}`)}`, "_blank");
      });

      document.addEventListener("DOMContentLoaded", function() {
        const elements = document.querySelectorAll(".location-animate");
        const observer = new IntersectionObserver(entries => {
          entries.forEach(entry => { if(entry.isIntersecting){ entry.target.classList.remove("opacity-0","translate-y-10"); } });
        }, { threshold: 0.2 });
        elements.forEach(el => observer.observe(el));
      });
    </script>

    <!-- WhatsApp Float -->
    <a href="https://wa.me/2348030449893" target="_blank" class="fixed bottom-6 right-6 bg-green-600 hover:bg-green-700 text-white p-4 rounded-full shadow-lg flex items-center justify-center" title="Message us on WhatsApp">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
        <path d="M20.52 3.48A11.902 11.902 0 0 0 12 0C5.373 0 0 5.373 0 12c0 2.106.544 4.078 1.488 5.785L0 24l6.425-1.472A11.924 11.924 0 0 0 12 24c6.627 0 12-5.373 12-12 0-3.192-1.236-6.189-3.48-8.52zM12 22c-1.976 0-3.83-.632-5.33-1.696l-.38-.228-3.814.874.805-3.727-.247-.39A9.956 9.956 0 0 1 2 12c0-5.523 4.477-10 10-10s10 4.477 10 10-4.477 10-10 10zm5.272-7.727c-.265-.133-1.566-.772-1.808-.861-.242-.089-.418-.133-.594.133s-.681.861-.833 1.038-.307.2-.572.067c-.265-.133-1.116-.411-2.123-1.309-.785-.699-1.314-1.562-1.468-1.827-.154-.265-.016-.408.116-.54.119-.118.265-.307.398-.459.133-.152.177-.265.265-.442.089-.177.044-.333-.022-.459-.067-.133-.593-1.429-.812-1.963-.213-.51-.43-.44-.594-.448l-.507-.009c-.177 0-.459.066-.7.333s-.918.897-.918 2.187.941 2.532 1.073 2.709c.133.177 1.854 2.832 4.5 3.965.63.272 1.12.434 1.503.555.631.201 1.207.172 1.66.104.506-.072 1.566-.64 1.788-1.258.221-.619.221-1.15.154-1.258-.067-.108-.242-.177-.507-.31z"/>
      </svg>
    </a>
  </body>
</html>