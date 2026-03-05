/* ===============================
   Admin Panel JS - Interactivity
   =============================== */

/* Sidebar Collapse Toggle */
const sidebar = document.querySelector(".sidebar");
const toggleBtn = document.querySelector(".sidebar-toggle");

toggleBtn?.addEventListener("click", () => {
  sidebar.classList.toggle("collapsed");
});

/* Mobile Sidebar Toggle */
const mobileToggle = document.querySelector(".mobile-toggle");
mobileToggle?.addEventListener("click", () => {
  sidebar.classList.toggle("active");
});

/* Profile Dropdown */
const profile = document.querySelector(".topbar .profile");
const dropdown = document.querySelector(".topbar .profile-dropdown");

profile?.addEventListener("click", () => {
  dropdown?.classList.toggle("show");
});

/* Close dropdown when clicking outside */
document.addEventListener("click", (e) => {
  if (!profile.contains(e.target)) {
    dropdown?.classList.remove("show");
  }
});

/* Optional: Animate dashboard cards on scroll */
const cards = document.querySelectorAll(".card");
const observer = new IntersectionObserver(
  (entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("fade-in");
      }
    });
  },
  { threshold: 0.1 },
);

cards.forEach((card) => observer.observe(card));
