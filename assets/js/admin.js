/**
 * assets/js/admin.js — DABS School Admin Panel v2
 */

document.addEventListener('DOMContentLoaded', () => {

    // ── Sidebar toggle (mobile) ──────────────────────────
    const toggleBtn = document.getElementById('sidebarToggle');
    const sidebar   = document.getElementById('sidebar');
    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', () => sidebar.classList.toggle('open'));
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 768 &&
                !sidebar.contains(e.target) &&
                !toggleBtn.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        });
    }

    // ── Auto-dismiss alerts after 4s ────────────────────
    document.querySelectorAll('.alert-auto-dismiss').forEach(el => {
        setTimeout(() => {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(el);
            bsAlert.close();
        }, 4000);
    });

    // ── Image upload preview ─────────────────────────────
    const fileInput    = document.getElementById('imageUpload');
    const imgPreview   = document.getElementById('imagePreview');
    if (fileInput && imgPreview) {
        fileInput.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                imgPreview.src = e.target.result;
                imgPreview.classList.add('show');
            };
            reader.readAsDataURL(file);
        });
    }

    // ── Populate Edit Content Modal ──────────────────────
    document.querySelectorAll('.btn-edit-content').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('editContentId').value      = btn.dataset.id;
            document.getElementById('editSectionName').value    = btn.dataset.section;
            document.getElementById('editSectionDisplay').textContent = btn.dataset.section;

            // TinyMCE or plain textarea
            if (typeof tinymce !== 'undefined') {
                tinymce.get('editContentText').setContent(btn.dataset.content);
            } else {
                document.getElementById('editContentText').value = btn.dataset.content;
            }
        });
    });

    // ── Populate Delete Image Modal ──────────────────────
    document.querySelectorAll('.btn-delete-image').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('deleteImageId').value   = btn.dataset.id;
            document.getElementById('deleteImageName').textContent = btn.dataset.name;
        });
    });

    // ── Confirm delete ────────────────────────────────────
    document.querySelectorAll('[data-confirm]').forEach(el => {
        el.addEventListener('click', (e) => {
            if (!confirm(el.dataset.confirm)) e.preventDefault();
        });
    });

});
