document.addEventListener('DOMContentLoaded', function() {
    const tagSelect = document.getElementById('tag_id');
    const newTagSection = document.getElementById('new-tag-section');
    const tagNameInput = document.getElementById('tag_name');
    const colorInput = document.getElementById('color');
    
    function toggleNewTagSection() {
        if (tagSelect.value === "") {
            newTagSection.classList.remove('d-none');
            tagNameInput.required = true;
            colorInput.required = true;
        } else {
            newTagSection.classList.add('d-none');
            tagNameInput.required = false;
            colorInput.required = false;
        }
    }

    // Add change event listener
    tagSelect.addEventListener('change', toggleNewTagSection);

    // Initial check on page load
    toggleNewTagSection();

    showCourseBtn = document.getElementById('show-course').addEventListener('click', function () {
        window.location.href = 'courses.php';
    });
});