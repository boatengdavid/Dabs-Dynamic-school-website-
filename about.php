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
    <title>About Us | Dabs Dynamic International Schools</title>
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
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
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
          <li><a href="home.php" class="hover:text-green-700">Home</a></li>
          <li><a href="news.php" class="hover:text-green-700">News</a></li>
          <li><a href="about.php" class="hover:text-green-700 font-bold text-green-900">About</a></li>
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

    <!-- HERO SECTION (Dynamic) -->
    <section class="relative bg-cover bg-center text-white py-32"
      style="background-image: url('<?= img($images, 'about_hero', '') ?>')">
      <div class="absolute inset-0 bg-green-900 <?= isset($images['about_hero']) ? 'opacity-70' : 'opacity-100' ?>"></div>
      <div class="relative max-w-4xl mx-auto px-6 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-6">About Dabs Dynamic International Schools</h1>
        <p class="text-lg text-green-200">
          Established in 2006, we are committed to raising disciplined, confident, and academically excellent leaders for a global future.
        </p>
      </div>
    </section>

    <!-- OUR STORY -->
    <section class="py-20 bg-white">
      <div class="max-w-5xl mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold text-green-900 mb-6">Our Foundation</h2>
        <p class="text-gray-700 leading-relaxed">
          Dabs Dynamic International Schools was founded on the principle of <strong>"Knowledge cum Discipline."</strong> Since 2006, we have remained dedicated to restoring the high educational standards of excellence while integrating modern teaching methodologies that prepare students for global relevance.
        </p>
      </div>
    </section>

    <!-- VISION & MISSION -->
    <section class="py-20 bg-green-50">
      <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-16">
        <div>
          <h2 class="text-3xl font-bold text-green-900 mb-6">Our Vision</h2>
          <ul class="space-y-4 text-gray-700">
            <li>• Deliver excellent academic results in all examinations.</li>
            <li>• Raise disciplined and God-fearing students.</li>
            <li>• Develop confident problem-solvers and agents of change.</li>
            <li>• Guide students toward purposeful and successful careers.</li>
            <li>• Blend traditional excellence with modern innovation.</li>
          </ul>
        </div>
        <div>
          <h2 class="text-3xl font-bold text-green-900 mb-6">Our Mission</h2>
          <p class="text-gray-700 leading-relaxed">
            Our mission is to recapture the high educational standards of the past by assembling competent, disciplined, and dedicated educators who deliver engaging, activity-based lessons that prioritize the individual needs of every student.
          </p>
        </div>
      </div>
    </section>

    <!-- CORE VALUES -->
    <section class="py-20 bg-white">
      <div class="max-w-6xl mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold text-green-900 mb-12">Our Core Values (I.T.A.C.E)</h2>
        <div class="grid md:grid-cols-5 gap-8">
          <div class="bg-green-50 p-6 rounded-xl shadow-md hover:shadow-lg transition"><h3 class="font-bold text-green-900 mb-2">Integrity</h3><p class="text-sm text-gray-600">Upholding honesty and strong moral principles.</p></div>
          <div class="bg-green-50 p-6 rounded-xl shadow-md hover:shadow-lg transition"><h3 class="font-bold text-green-900 mb-2">Teamwork</h3><p class="text-sm text-gray-600">Collaborating to achieve shared success.</p></div>
          <div class="bg-green-50 p-6 rounded-xl shadow-md hover:shadow-lg transition"><h3 class="font-bold text-green-900 mb-2">Accountability</h3><p class="text-sm text-gray-600">Taking responsibility for actions and outcomes.</p></div>
          <div class="bg-green-50 p-6 rounded-xl shadow-md hover:shadow-lg transition"><h3 class="font-bold text-green-900 mb-2">Commitment</h3><p class="text-sm text-gray-600">Dedicated to excellence in every task.</p></div>
          <div class="bg-green-50 p-6 rounded-xl shadow-md hover:shadow-lg transition"><h3 class="font-bold text-green-900 mb-2">Effectiveness</h3><p class="text-sm text-gray-600">Delivering measurable and impactful results.</p></div>
        </div>
      </div>
    </section>

    <!-- DISCIPLINE & CHARACTER -->
    <section class="py-20 bg-white">
      <div class="max-w-5xl mx-auto px-6">
        <div class="text-center mb-12" data-aos="fade-up">
          <h2 class="text-3xl font-bold text-green-900 mb-4">Discipline & Character Development</h2>
          <p class="text-gray-600">Knowledge cum Discipline remains our guiding principle.</p>
        </div>
        <div class="space-y-8 text-gray-700 leading-relaxed">
          <div class="flex items-start gap-4" data-aos="fade-right">
            <div class="text-green-700 mt-1"><svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2l7 4v6c0 5-3.5 9-7 10-3.5-1-7-5-7-10V6z" /></svg></div>
            <p>Structured routines and supervised learning create an orderly environment where students develop responsibility and self-control.</p>
          </div>
          <div class="flex items-start gap-4" data-aos="fade-right" data-aos-delay="150">
            <div class="text-green-700 mt-1"><svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12" /></svg></div>
            <p>Respect, punctuality, accountability, and proper conduct are emphasized daily through guided mentorship.</p>
          </div>
          <div class="flex items-start gap-4" data-aos="fade-right" data-aos-delay="300">
            <div class="text-green-700 mt-1"><svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="12 2 15 9 22 9 17 14 19 21 12 17 5 21 7 14 2 9 9 9" /></svg></div>
            <p>We aim to produce morally grounded, confident, and socially responsible individuals.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- STATISTICS -->
    <section class="py-16 bg-green-900 text-white">
      <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-12" data-aos="fade-up">
          <h2 class="text-3xl font-bold mb-4">Our Growth & Stability</h2>
          <p class="text-green-200">Building a strong academic foundation since 2006.</p>
        </div>
        <div class="grid md:grid-cols-4 gap-10 text-center">
          <div data-aos="fade-up">
            <div class="flex justify-center mb-4"><svg class="w-10 h-10 text-green-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/></svg></div>
            <h3 class="text-3xl font-bold counter" data-target="2006">0</h3>
            <p class="text-green-200 mt-2">Year Established</p>
          </div>
          <div data-aos="fade-up" data-aos-delay="150">
            <div class="flex justify-center mb-4"><svg class="w-10 h-10 text-green-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
            <h3 class="text-3xl font-bold counter" data-target="15">0</h3>
            <p class="text-green-200 mt-2">Years of Service</p>
          </div>
          <div data-aos="fade-up" data-aos-delay="300">
            <div class="flex justify-center mb-4"><svg class="w-10 h-10 text-green-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-3-3.87"/><path d="M7 21v-2a4 4 0 0 1 3-3.87"/><circle cx="12" cy="7" r="4"/></svg></div>
            <h3 class="text-3xl font-bold counter" data-target="50">0</h3>
            <p class="text-green-200 mt-2">Qualified Staff</p>
          </div>
          <div data-aos="fade-up" data-aos-delay="450">
            <div class="flex justify-center mb-4"><svg class="w-10 h-10 text-green-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="7"/><polyline points="8 21 12 17 16 21"/></svg></div>
            <h3 class="text-3xl font-bold counter" data-target="500">0</h3>
            <p class="text-green-200 mt-2">Graduates</p>
          </div>
        </div>
      </div>
    </section>

    <!-- LEADERSHIP (Dynamic images) -->
    <section class="py-24 bg-green-50">
      <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-20" data-aos="fade-up">
          <h2 class="text-4xl font-bold text-green-900 mb-4">Leadership & Administration</h2>
          <p class="text-gray-600 max-w-2xl mx-auto">Our leadership team is dedicated to academic excellence, moral discipline, and the holistic development of every student.</p>
        </div>
        <div class="grid md:grid-cols-2 gap-16">
          <div class="group bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-500 hover:-translate-y-3 hover:shadow-[0_20px_60px_rgba(0,0,0,0.15)]" data-aos="fade-up">
            <div class="overflow-hidden">
              <img src="<?= img($images, 'proprietor_photo', 'images/proprietor.jpg') ?>" class="w-full h-[400px] object-cover transition-transform duration-700 group-hover:scale-105" alt="Proprietor"/>
            </div>
            <div class="p-8">
              <h3 class="text-2xl font-bold text-green-900">Mr. Francis Lordson Boateng</h3>
              <p class="text-green-700 font-semibold mb-4">Proprietor / Director</p>
              <p class="text-gray-700 leading-relaxed">As Founder and Director, he provides strategic leadership focused on academic mastery, discipline, and institutional growth. His commitment ensures students graduate confident and globally competitive.</p>
            </div>
          </div>

          <div class="group bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-500 hover:-translate-y-3 hover:shadow-[0_20px_60px_rgba(0,0,0,0.15)]" data-aos="fade-up" data-aos-delay="200">
            <div class="overflow-hidden">
              <img src="<?= img($images, 'proprietress_photo', 'images/proprietress.jpg') ?>" class="w-full h-[400px] object-cover transition-transform duration-700 group-hover:scale-105" alt="Proprietress"/>
            </div>
            <div class="p-8">
              <h3 class="text-2xl font-bold text-green-900">Mrs. Kofoworola Boateng</h3>
              <p class="text-green-700 font-semibold mb-4">Proprietress</p>
              <p class="text-gray-700 leading-relaxed">She oversees student welfare and moral development, ensuring a disciplined yet nurturing environment that supports holistic growth and academic excellence.</p>
            </div>
          </div>

          <div class="group bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-500 hover:-translate-y-3 hover:shadow-[0_20px_60px_rgba(0,0,0,0.15)]" data-aos="fade-up" data-aos-delay="400">
            <div class="overflow-hidden">
              <img src="<?= img($images, 'headteacher_photo', 'images/headteacher.jpg') ?>" class="w-full h-[400px] object-cover transition-transform duration-700 group-hover:scale-105" alt="Headteacher"/>
            </div>
            <div class="p-8">
              <h3 class="text-2xl font-bold text-green-900">Mrs. Edema Sandra</h3>
              <p class="text-green-700 font-semibold mb-4">School 1 Administrator (MOWE)</p>
              <p class="text-gray-700 leading-relaxed">Driving the academic heartbeat of the school, she ensures that our curriculum is delivered with precision and care. Her leadership focuses on structured academic operations that empower every child to reach measurable milestones in their learning journey.</p>
            </div>
          </div>

          <div class="group bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-500 hover:-translate-y-3 hover:shadow-[0_20px_60px_rgba(0,0,0,0.15)]" data-aos="fade-up" data-aos-delay="600">
            <div class="overflow-hidden">
              <img src="<?= img($images, 'administrator_photo', 'images/administrator.jpg') ?>" class="w-full h-[400px] object-cover transition-transform duration-700 group-hover:scale-105" alt="Administrator"/>
            </div>
            <div class="p-8">
              <h3 class="text-2xl font-bold text-green-900">Mrs. Okoro Florence</h3>
              <p class="text-green-700 font-semibold mb-4">School 2 Administrator (Aleku)</p>
              <p class="text-gray-700 leading-relaxed">Responsible for the strategic oversight of academic operations and curriculum delivery at School 2. Her leadership ensures a disciplined, structured approach to learning that produces verifiable and excellent student results.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ACADEMIC EXCELLENCE -->
    <section class="py-20 bg-green-50">
      <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-12" data-aos="fade-up">
          <h2 class="text-3xl font-bold text-green-900 mb-4">Academic Excellence</h2>
          <p class="text-gray-600">Structured teaching. Measurable results.</p>
        </div>
        <div class="grid md:grid-cols-2 gap-12 text-gray-700">
          <div data-aos="fade-up"><h3 class="font-semibold text-green-800 mb-2 flex items-center gap-2">📘 Structured Curriculum</h3><p>Lessons follow approved standards supported by continuous assessment.</p></div>
          <div data-aos="fade-up" data-aos-delay="150"><h3 class="font-semibold text-green-800 mb-2 flex items-center gap-2">📝 Exam Preparation</h3><p>Revision programs and targeted support ensure strong performance.</p></div>
          <div data-aos="fade-up" data-aos-delay="300"><h3 class="font-semibold text-green-800 mb-2 flex items-center gap-2">👩🏾‍🏫 Qualified Educators</h3><p>Dedicated teachers committed to measurable academic growth.</p></div>
          <div data-aos="fade-up" data-aos-delay="450"><h3 class="font-semibold text-green-800 mb-2 flex items-center gap-2">📊 Individual Monitoring</h3><p>Performance tracking ensures every student receives proper guidance.</p></div>
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
        <a href="about.php" class="block border-b pb-3 font-bold text-green-900">About</a>
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
    </script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>AOS.init({ duration: 1000, once: true });</script>
    <script>
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
      const cObs = new IntersectionObserver(entries => { entries.forEach(e => { if(e.isIntersecting){ animateCounters(); cObs.disconnect(); } }); });
      cObs.observe(document.querySelector(".counter").closest("section"));
    </script>
  </body>
</html>