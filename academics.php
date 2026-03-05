<?php require_once 'connect.php'; ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Academics | Dabs Dynamic International Schools</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            keyframes: {
              slideIn: {
                "0%": { transform: "translateX(-100%)", opacity: 0 },
                "100%": { transform: "translateX(0)", opacity: 1 },
              },
              slideInDelay: {
                "0%": { transform: "translateX(100%)", opacity: 0 },
                "100%": { transform: "translateX(0)", opacity: 1 },
              },
              slideUp: {
                "0%": { transform: "translateY(50px)", opacity: 0 },
                "100%": { transform: "translateY(0)", opacity: 1 },
              },
              fadeIn: {
                "0%": { opacity: 0 },
                "100%": { opacity: 1 },
              },
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
        <!-- Logo -->
        <div class="flex items-center gap-3">
          <img
            src="dabs-logo.png"
            alt="Dabs Dynamic International Schools Logo"
            class="h-16 w-16 object-contain"
          />
          <div class="leading-tight">
            <span class="block text-lg font-bold text-green-900">
              Dabs Dynamic Int'l Schools
            </span>
            <span class="block text-xs font-medium text-green-700">
              GOVT. APPROVED • RC NO: 2435402
            </span>
          </div>
        </div>

        <!-- Desktop Menu -->
        <ul class="hidden md:flex space-x-6 font-medium">
          <li><a href="home.php" class="hover:text-green-700">Home</a></li>
          <li><a href="news.php" class="hover:text-green-700">News</a></li>
          <li><a href="about.php" class="hover:text-green-700">About</a></li>
          <li><a href="academics.php" class="hover:text-green-700 font-bold text-green-900">Academics</a></li>
          <li><a href="admissions.php" class="hover:text-green-700">Admissions</a></li>
          <li><a href="gallery.php" class="hover:text-green-700">Gallery</a></li>
          <li><a href="contact.php" class="hover:text-green-700">Contact</a></li>
        </ul>

        <!-- Mobile Menu Button -->
        <button
          id="menuBtn"
          class="md:hidden relative w-7 h-7 flex items-center justify-center focus:outline-none"
        >
          <span class="bar absolute w-6 h-0.5 bg-green-900 transition-all duration-300"></span>
          <span class="bar absolute w-6 h-0.5 bg-green-900 transition-all duration-300"></span>
          <span class="bar absolute w-6 h-0.5 bg-green-900 transition-all duration-300"></span>
        </button>
      </nav>
    </header>

    <!-- ================= INTRO SECTION ================= -->
    <section class="relative h-[70vh] flex items-center justify-center text-center text-white overflow-hidden">
      <img src="hero-academics.jpg" class="absolute inset-0 w-full h-full object-cover" alt="Students in classroom" />
      <div class="absolute inset-0 bg-gradient-to-r from-green-900/80 to-green-800/70"></div>
      <div class="relative z-10 px-6 max-w-4xl">
        <h1 class="text-4xl md:text-6xl font-bold leading-tight mb-6 animate-fadeIn">
          Academic Excellence from Foundation to Leadership
        </h1>
        <p class="text-lg md:text-xl text-green-100 max-w-2xl mx-auto mb-8 animate-slideUp">
          At Dabs Dynamic International Schools, we nurture disciplined,
          confident, and globally competitive students through structured
          academics and moral guidance.
        </p>
        <a
          href="admissions.php"
          class="inline-block bg-white text-green-900 px-10 py-4 rounded-xl font-semibold shadow-lg hover:scale-105 transition duration-300"
        >
          Explore Admissions
        </a>
      </div>
    </section>

    <!-- ================= ACADEMIC LEVELS ================= -->
    <section class="py-24 bg-gray-50">
      <div class="max-w-4xl mx-auto px-6 text-center mb-16">
        <h2 class="text-3xl md:text-4xl font-bold text-green-900 mb-6">Our Academic Structure</h2>
        <p class="text-gray-600 text-lg">
          Structured programs designed to build intellectual capacity,
          discipline, leadership, and innovation.
        </p>
      </div>

      <div class="max-w-6xl mx-auto px-6 grid gap-10 sm:grid-cols-2 lg:grid-cols-3">
        <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition duration-500 border-t-4 border-green-700">
          <div class="text-3xl mb-6">📘</div>
          <h3 class="text-xl font-semibold mb-4 text-green-900">Creche & Nursery</h3>
          <p class="text-gray-600 leading-relaxed">
            Foundational literacy, numeracy, creativity, and social development
            in a safe and stimulating environment.
          </p>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition duration-500 border-t-4 border-green-700">
          <div class="text-3xl mb-6">📚</div>
          <h3 class="text-xl font-semibold mb-4 text-green-900">Primary School</h3>
          <p class="text-gray-600 leading-relaxed">
            Comprehensive curriculum including English, Mathematics, Science,
            ICT, and Moral Training.
          </p>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition duration-500 border-t-4 border-green-700">
          <div class="text-3xl mb-6">🎓</div>
          <h3 class="text-xl font-semibold mb-4 text-green-900">Secondary School</h3>
          <p class="text-gray-600 leading-relaxed">
            Advanced academics, leadership development, and preparation for
            internal and external examinations.
          </p>
        </div>
      </div>
    </section>

    <!-- ================= CURRICULUM HIGHLIGHTS ================= -->
    <section class="py-20 bg-white">
      <div class="max-w-6xl mx-auto px-6 text-center mb-14">
        <h2 class="text-4xl font-bold text-green-900 mb-4">Curriculum Highlights</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">
          A balanced blend of academic excellence, innovation, moral training,
          and leadership development.
        </p>
      </div>

      <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-3 gap-10">
        <div class="flex items-start space-x-4">
          <div class="text-3xl text-green-700">💻</div>
          <div>
            <h4 class="font-semibold text-green-900">ICT Integration</h4>
            <p class="text-gray-600 text-sm">Technology-driven learning at all academic levels.</p>
          </div>
        </div>
        <div class="flex items-start space-x-4">
          <div class="text-3xl text-green-700">🧠</div>
          <div>
            <h4 class="font-semibold text-green-900">Critical Thinking</h4>
            <p class="text-gray-600 text-sm">Problem-solving and analytical skills development.</p>
          </div>
        </div>
        <div class="flex items-start space-x-4">
          <div class="text-3xl text-green-700">⚖</div>
          <div>
            <h4 class="font-semibold text-green-900">Moral Education</h4>
            <p class="text-gray-600 text-sm">Character formation and ethical development.</p>
          </div>
        </div>
        <div class="flex items-start space-x-4">
          <div class="text-3xl text-green-700">🏆</div>
          <div>
            <h4 class="font-semibold text-green-900">Sports Excellence</h4>
            <p class="text-gray-600 text-sm">Physical development and competitive spirit.</p>
          </div>
        </div>
        <div class="flex items-start space-x-4">
          <div class="text-3xl text-green-700">🧭</div>
          <div>
            <h4 class="font-semibold text-green-900">Leadership Skills</h4>
            <p class="text-gray-600 text-sm">Preparing students for future responsibility.</p>
          </div>
        </div>
        <div class="flex items-start space-x-4">
          <div class="text-3xl text-green-700">🎯</div>
          <div>
            <h4 class="font-semibold text-green-900">Career Guidance</h4>
            <p class="text-gray-600 text-sm">Helping students chart successful career paths.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ================= EXTRA CURRICULAR ================= -->
    <section class="py-20 bg-gray-50">
      <div class="max-w-6xl mx-auto px-6 text-center mb-12">
        <h2 class="text-4xl font-bold text-green-900 mb-4">Beyond the Classroom</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">
          Developing well-rounded students through sports, arts, culture, and leadership activities.
        </p>
      </div>

      <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-3 gap-8">
        <div class="relative rounded-2xl overflow-hidden shadow-lg group">
          <img src="sports.jpg" class="w-full h-64 object-cover group-hover:scale-110 transition duration-500" />
          <div class="absolute inset-0 bg-green-900/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-500">
            <h3 class="text-white text-xl font-semibold">Sports</h3>
          </div>
        </div>
        <div class="relative rounded-2xl overflow-hidden shadow-lg group">
          <img src="cultural.jpg" class="w-full h-64 object-cover group-hover:scale-110 transition duration-500" />
          <div class="absolute inset-0 bg-green-900/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-500">
            <h3 class="text-white text-xl font-semibold">Cultural Activities</h3>
          </div>
        </div>
        <div class="relative rounded-2xl overflow-hidden shadow-lg group">
          <img src="club.jpg" class="w-full h-64 object-cover group-hover:scale-110 transition duration-500" />
          <div class="absolute inset-0 bg-green-900/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-500">
            <h3 class="text-white text-xl font-semibold">Clubs & Leadership</h3>
          </div>
        </div>
      </div>
    </section>

    <!-- ================= TESTIMONIALS ================= -->
    <section class="py-24 bg-gradient-to-b from-white to-green-50">
      <div class="max-w-7xl mx-auto px-6 text-center mb-16">
        <h2 class="text-4xl md:text-5xl font-bold text-green-900 mb-4">What Parents & Students Say</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">
          Hear from members of our community about their experience at Dabs Dynamic International Schools.
        </p>
      </div>

      <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 lg:grid-cols-3 gap-10">
        <div class="bg-gray-50 p-8 rounded-2xl shadow-lg hover:shadow-2xl transition duration-500 hover:-translate-y-2">
          <div class="flex mb-4 text-yellow-400 text-lg">★★★★★</div>
          <p class="text-gray-700 leading-relaxed mb-6">
            "Dabs Dynamic has transformed my child academically and morally. The
            discipline and quality teaching here are exceptional."
          </p>
          <div class="flex items-center gap-4">
            <img src="parent1.jpg" class="w-12 h-12 rounded-full object-cover" alt="Parent" />
            <div>
              <h4 class="font-semibold text-green-900">Mrs. Adeyemi</h4>
              <p class="text-sm text-gray-500">Parent</p>
            </div>
          </div>
        </div>

        <div class="bg-gray-50 p-8 rounded-2xl shadow-lg hover:shadow-2xl transition duration-500 hover:-translate-y-2">
          <div class="flex mb-4 text-yellow-400 text-lg">★★★★★</div>
          <p class="text-gray-700 leading-relaxed mb-6">
            "The academic structure and ICT exposure prepared me excellently for my external examinations."
          </p>
          <div class="flex items-center gap-4">
            <img src="student1.jpg" class="w-12 h-12 rounded-full object-cover" alt="Student" />
            <div>
              <h4 class="font-semibold text-green-900">Daniel O.</h4>
              <p class="text-sm text-gray-500">SS3 Graduate</p>
            </div>
          </div>
        </div>

        <div class="bg-gray-50 p-8 rounded-2xl shadow-lg hover:shadow-2xl transition duration-500 hover:-translate-y-2">
          <div class="flex mb-4 text-yellow-400 text-lg">★★★★★</div>
          <p class="text-gray-700 leading-relaxed mb-6">
            "Beyond academics, the school builds confidence, leadership, and strong moral values in students."
          </p>
          <div class="flex items-center gap-4">
            <img src="parent2.jpg" class="w-12 h-12 rounded-full object-cover" alt="Parent" />
            <div>
              <h4 class="font-semibold text-green-900">Mr. Ibrahim</h4>
              <p class="text-sm text-gray-500">Parent</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ================= EXAM RESULTS SHOWCASE ================= -->
    <section class="py-24 bg-green-900 text-white">
      <div class="max-w-7xl mx-auto px-6 text-center mb-16">
        <h2 class="text-4xl md:text-5xl font-bold mb-4">WAEC & NECO Examination Performance</h2>
        <p class="text-green-200 max-w-2xl mx-auto">
          Our consistent academic excellence is reflected in outstanding internal and external examination results.
        </p>
      </div>

      <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-3 gap-10 text-center">
        <div class="bg-green-800/50 p-10 rounded-2xl shadow-xl hover:scale-105 transition duration-500">
          <h3 class="text-5xl font-bold mb-3">95%</h3>
          <p class="text-green-200 font-medium">WAEC Pass Rate (5 Credits & Above)</p>
        </div>
        <div class="bg-green-800/50 p-10 rounded-2xl shadow-xl hover:scale-105 transition duration-500">
          <h3 class="text-5xl font-bold mb-3">93%</h3>
          <p class="text-green-200 font-medium">NECO Pass Rate (5 Credits & Above)</p>
        </div>
        <div class="bg-green-800/50 p-10 rounded-2xl shadow-xl hover:scale-105 transition duration-500">
          <h3 class="text-5xl font-bold mb-3">90%</h3>
          <p class="text-green-200 font-medium">University & Tertiary Admissions</p>
        </div>
      </div>

      <div class="text-center mt-16 max-w-3xl mx-auto px-6">
        <p class="text-green-200 text-lg">
          Our students consistently excel in both WAEC and NECO examinations,
          demonstrating our commitment to academic rigor, discipline, and quality instruction.
        </p>
      </div>
    </section>

    <!-- ================= TOP STUDENT SPOTLIGHT ================= -->
    <section class="py-24 bg-gray-50">
      <div class="max-w-7xl mx-auto px-6 text-center mb-16">
        <h2 class="text-4xl md:text-5xl font-bold text-green-900 mb-4">Top Student Spotlight</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">
          Celebrating academic excellence and outstanding achievement in WAEC and NECO examinations.
        </p>
      </div>

      <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
        <div class="relative group">
          <img src="top-student.jpg" alt="Top Student" class="rounded-2xl shadow-xl w-full object-cover group-hover:scale-105 transition duration-500" />
          <div class="absolute top-6 left-6 bg-green-700 text-white px-5 py-2 rounded-full shadow-lg text-sm font-semibold">
            WAEC DISTINCTION
          </div>
        </div>

        <div>
          <h3 class="text-3xl font-bold text-green-900 mb-4">Miss Deborah A.</h3>
          <p class="text-gray-600 mb-6 leading-relaxed">
            Achieved 9 A's in WAEC including Mathematics, English Language,
            Physics, Chemistry, and Biology. Now pursuing Medicine at a leading Nigerian university.
          </p>
          <div class="grid grid-cols-3 gap-6 mb-8 text-center">
            <div class="bg-white p-6 rounded-xl shadow-md">
              <h4 class="text-3xl font-bold text-green-700">9</h4>
              <p class="text-sm text-gray-500">Distinctions</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md">
              <h4 class="text-3xl font-bold text-green-700">A1</h4>
              <p class="text-sm text-gray-500">Mathematics</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md">
              <h4 class="text-3xl font-bold text-green-700">A1</h4>
              <p class="text-sm text-gray-500">English</p>
            </div>
          </div>
          <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-green-700">
            <p class="text-gray-700 italic">
              "Dabs Dynamic gave me the discipline, academic support, and
              confidence I needed to excel. The teachers are exceptional."
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- ================= TOP STUDENTS SLIDER ================= -->
    <section class="py-24 bg-gray-50 relative overflow-hidden">
      <div class="max-w-7xl mx-auto px-6 text-center mb-16">
        <h2 class="text-4xl md:text-5xl font-bold text-green-900 mb-4">Academic Excellence Spotlight</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">
          Celebrating our outstanding students and their exceptional performance in national examinations.
        </p>
      </div>

      <div class="relative max-w-5xl mx-auto">
        <div id="studentSlider" class="relative">
          <div class="slide opacity-100 transition-opacity duration-700">
            <div class="grid md:grid-cols-2 gap-10 items-center bg-white p-10 rounded-2xl shadow-xl">
              <img src="student1.jpg" class="rounded-xl shadow-lg w-full object-cover" />
              <div>
                <h3 class="text-3xl font-bold text-green-900 mb-3">Miss Deborah A.</h3>
                <p class="text-gray-600 mb-6">9 A's in WAEC including Mathematics & English. Currently studying Medicine.</p>
                <div class="flex gap-4 text-green-700 font-bold text-lg">
                  <span>9 Distinctions</span><span>|</span><span>WAEC 2025</span>
                </div>
              </div>
            </div>
          </div>

          <div class="slide absolute inset-0 opacity-0 transition-opacity duration-700">
            <div class="grid md:grid-cols-2 gap-10 items-center bg-white p-10 rounded-2xl shadow-xl">
              <img src="student2.jpg" class="rounded-xl shadow-lg w-full object-cover" />
              <div>
                <h3 class="text-3xl font-bold text-green-900 mb-3">Master Ibrahim K.</h3>
                <p class="text-gray-600 mb-6">8 A's in NECO with excellence in Sciences. Admitted to study Engineering.</p>
                <div class="flex gap-4 text-green-700 font-bold text-lg">
                  <span>8 Distinctions</span><span>|</span><span>NECO 2025</span>
                </div>
              </div>
            </div>
          </div>

          <div class="slide absolute inset-0 opacity-0 transition-opacity duration-700">
            <div class="grid md:grid-cols-2 gap-10 items-center bg-white p-10 rounded-2xl shadow-xl">
              <img src="student3.jpg" class="rounded-xl shadow-lg w-full object-cover" />
              <div>
                <h3 class="text-3xl font-bold text-green-900 mb-3">Miss Chioma E.</h3>
                <p class="text-gray-600 mb-6">Best Graduating Student with 7 A1's. Awarded Academic Excellence Medal.</p>
                <div class="flex gap-4 text-green-700 font-bold text-lg">
                  <span>7 Distinctions</span><span>|</span><span>Best Graduate</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <button id="prevSlide" class="absolute left-0 top-1/2 -translate-y-1/2 bg-green-700 text-white px-4 py-3 rounded-full shadow-lg hover:bg-green-800">‹</button>
        <button id="nextSlide" class="absolute right-0 top-1/2 -translate-y-1/2 bg-green-700 text-white px-4 py-3 rounded-full shadow-lg hover:bg-green-800">›</button>
      </div>
    </section>

    <!-- ================= SCHOOL AWARDS ================= -->
    <section class="py-24 bg-green-900 text-white">
      <div class="max-w-7xl mx-auto px-6 text-center mb-16">
        <h2 class="text-4xl md:text-5xl font-bold mb-4">Awards & Recognition</h2>
        <p class="text-green-200 max-w-2xl mx-auto">Recognized for academic excellence, discipline, and leadership.</p>
      </div>

      <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-3 gap-10">
        <div class="bg-green-800/50 p-8 rounded-2xl shadow-xl hover:scale-105 transition duration-500">
          <div class="text-5xl mb-4">🏆</div>
          <h3 class="text-xl font-semibold mb-3">Best Private School Award</h3>
          <p class="text-green-200 text-sm">Recognized for outstanding academic performance and discipline.</p>
          <p class="mt-3 text-green-100 font-medium">2024</p>
        </div>
        <div class="bg-green-800/50 p-8 rounded-2xl shadow-xl hover:scale-105 transition duration-500">
          <div class="text-5xl mb-4">🥇</div>
          <h3 class="text-xl font-semibold mb-3">Academic Excellence Recognition</h3>
          <p class="text-green-200 text-sm">Awarded for exceptional WAEC & NECO results.</p>
          <p class="mt-3 text-green-100 font-medium">2023</p>
        </div>
        <div class="bg-green-800/50 p-8 rounded-2xl shadow-xl hover:scale-105 transition duration-500">
          <div class="text-5xl mb-4">🎖</div>
          <h3 class="text-xl font-semibold mb-3">Leadership & Discipline Award</h3>
          <p class="text-green-200 text-sm">Honored for promoting moral and ethical standards.</p>
          <p class="mt-3 text-green-100 font-medium">2022</p>
        </div>
      </div>
    </section>

    <!-- ================= ACCREDITATION SECTION ================= -->
    <section class="py-20 bg-white">
      <div class="max-w-6xl mx-auto px-6 text-center">
        <h2 class="text-4xl font-bold text-green-900 mb-6">Accreditation & Government Approval</h2>
        <p class="text-gray-600 max-w-2xl mx-auto mb-12">
          Dabs Dynamic International Schools is fully approved and recognized by relevant government educational authorities.
        </p>

        <div class="bg-gray-50 p-10 rounded-2xl shadow-lg max-w-4xl mx-auto">
          <div class="flex flex-col md:flex-row items-center justify-center gap-10">
            <div class="text-green-700 text-6xl">🏛</div>
            <div class="text-left max-w-xl">
              <h3 class="text-2xl font-semibold text-green-900 mb-3">Government Approved Institution</h3>
              <p class="text-gray-600 leading-relaxed">
                Our institution operates under full government authorization,
                ensuring compliance with national academic standards, curriculum
                guidelines, and examination regulations.
              </p>
              <p class="mt-4 text-gray-700 font-medium">RC No: 2435402</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ================= SCHOOL HOURS ================= -->
    <section class="py-24 bg-green-900 text-white">
      <div class="max-w-6xl mx-auto px-6 text-center mb-16">
        <h2 class="text-4xl md:text-5xl font-bold mb-4">Our Learning Schedule</h2>
        <p class="text-green-200 max-w-2xl mx-auto">
          We maintain structured academic hours that promote discipline and excellence.
        </p>
      </div>

      <div class="max-w-5xl mx-auto bg-white text-gray-800 rounded-2xl shadow-2xl p-12">
        <div class="space-y-8">
          <div class="flex justify-between items-center border-b pb-6">
            <h3 class="text-2xl font-semibold text-green-800">Monday – Thursday</h3>
            <span class="text-xl font-bold">8:00 AM – 3:00 PM</span>
          </div>
          <div class="flex justify-between items-center">
            <h3 class="text-2xl font-semibold text-green-800">Friday</h3>
            <span class="text-xl font-bold">8:00 AM – 1:00 PM</span>
          </div>
        </div>
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
          <a
            href="admissions.php"
            class="inline-block bg-gradient-to-r from-green-600 to-green-800 text-white px-12 py-4 rounded-xl font-semibold text-lg shadow-lg hover:scale-105 transition-transform duration-300"
          >
            Begin Admission Process
          </a>
        </div>

        <div class="border-t border-slate-700 mb-16"></div>

        <div class="grid md:grid-cols-3 gap-12">
          <div>
            <h4 class="text-white font-semibold mb-6 text-lg">About Dabs Dynamic</h4>
            <p class="text-slate-400 leading-relaxed">
              Since 2006, Dabs Dynamic International Schools has upheld global
              academic standards while nurturing strong moral values and disciplined leadership.
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
              <input
                type="email"
                placeholder="Enter your email address"
                class="px-4 py-3 rounded-lg bg-slate-800 border border-slate-700 text-white focus:outline-none focus:ring-2 focus:ring-green-400"
              />
              <button type="submit" class="bg-green-700 text-white py-3 rounded-lg font-semibold hover:bg-green-800 transition">
                Subscribe
              </button>
            </form>

            <div class="flex space-x-4 justify-center">
              <!-- TikTok -->
              <a href="#" class="w-11 h-11 flex items-center justify-center rounded-xl bg-black hover:opacity-90 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 relative" viewBox="0 0 256 256">
                  <path d="M204.72 48.35a92.45 92.45 0 01-54.3-17.61v97.12a40.08 40.08 0 11-40-40V50.12a92.45 92.45 0 1154.3 17.61V128a92.44 92.44 0 0055.6-79.65z" fill="#69C9D0"/>
                  <path d="M204.72 48.35a92.45 92.45 0 01-54.3-17.61v97.12a40.08 40.08 0 11-40-40V50.12a92.45 92.45 0 1154.3 17.61V128a92.44 92.44 0 0055.6-79.65z" fill="#EE1D52" transform="translate(-2,0)"/>
                  <path d="M204.72 48.35a92.45 92.45 0 01-54.3-17.61v97.12a40.08 40.08 0 11-40-40V50.12a92.45 92.45 0 1154.3 17.61V128a92.44 92.44 0 0055.6-79.65z" fill="white" transform="translate(-1,0)"/>
                </svg>
              </a>
              <!-- Instagram -->
              <a href="#" class="w-11 h-11 flex items-center justify-center rounded-xl bg-gradient-to-tr from-[#feda75] via-[#d62976] to-[#4f5bd5] hover:opacity-90 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 fill-white" viewBox="0 0 24 24">
                  <path d="M7 2C4.24 2 2 4.24 2 7v10c0 2.76 2.24 5 5 5h10c2.76 0 5-2.24 5-5V7c0-2.76-2.24-5-5-5H7zm5 4a5 5 0 110 10 5 5 0 010-10zm6.5-.75a1.25 1.25 0 110 2.5 1.25 1.25 0 010-2.5z"/>
                </svg>
              </a>
              <!-- Facebook -->
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

    <!-- Divider -->
    <div class="h-[1px] bg-white"></div>

    <!-- FOOTER -->
    <footer class="bg-green-900 text-white py-6">
      <div class="max-w-7xl mx-auto px-4 text-center">
        <p class="text-sm text-green-200">
          Knowledge Cum Discipline © 2006 – 2026 | All Rights Reserved
        </p>
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

    <!-- Overlay -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40 transition-opacity duration-300"></div>

    <!-- Sidebar Menu -->
    <div id="mobileMenu" class="fixed top-0 right-0 h-full w-80 bg-white shadow-xl transform translate-x-full transition-transform duration-300 ease-in-out z-50">
      <div class="flex items-center justify-between px-5 py-4 border-b bg-green-100">
        <span class="font-bold text-green-900">Menu</span>
        <button id="closeMenu" class="w-8 h-8 flex items-center justify-center bg-green-700 text-white rounded-full hover:bg-green-800 transition">✕</button>
      </div>
      <nav class="px-6 py-6 space-y-6 font-medium text-gray-700">
        <a href="home.php" class="block border-b pb-3">Home</a>
        <a href="news.php" class="block border-b pb-3">News</a>
        <a href="about.php" class="block border-b pb-3">About</a>
        <a href="academics.php" class="block border-b pb-3 font-bold text-green-900">Academics</a>
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

    <script>
      const slides = document.querySelectorAll(".slide");
      let currentSlide = 0;

      function showSlide(index) {
        slides.forEach((slide, i) => {
          slide.style.opacity = i === index ? "1" : "0";
          slide.style.position = i === index ? "relative" : "absolute";
        });
      }

      function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
      }

      function prevSlide() {
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        showSlide(currentSlide);
      }

      document.getElementById("nextSlide").addEventListener("click", nextSlide);
      document.getElementById("prevSlide").addEventListener("click", prevSlide);

      setInterval(nextSlide, 5000);
    </script>
  </body>
</html>