document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('tag_id').addEventListener('change', function () {
        let newTagSection = document.getElementById('new-tag-section');
        if (this.value === '') {
            newTagSection.style.display = 'block';
        } else {
            newTagSection.style.display = 'none';
        }
    });

    showCourseBtn = document.getElementById('show-course').addEventListener('click', function () {
        window.location.href = 'courses.php';

    })
   
});