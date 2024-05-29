document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.nav-link.toggle-form');
    const forms = document.querySelectorAll('.form-card');

    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            navLinks.forEach(nav => nav.classList.remove('active'));
            forms.forEach(form => form.classList.add('d-none'));
            
            this.classList.add('active');
            const targetForm = document.getElementById(this.getAttribute('data-target'));
            if (targetForm) {
                targetForm.classList.remove('d-none');
            }
        });
    });

    // Automatically trigger click on "Ders Düzenle" link
    const editCourseLink = document.querySelector('[data-target="edit-course-form"]');
    if (editCourseLink) {
        editCourseLink.click();
    }

    // Show new tag section if "Yeni Etiket Oluştur" is selected
    const tagSelect = document.getElementById('tag_id');
    const newTagSection = document.getElementById('new-tag-section');
    tagSelect.addEventListener('change', function() {
        if (this.value === "") {
            newTagSection.classList.remove('d-none');
        } else {
            newTagSection.classList.add('d-none');
        }
    });

    // Trigger change event on page load to handle pre-selected "Yeni Etiket Oluştur"
    tagSelect.dispatchEvent(new Event('change'));
});