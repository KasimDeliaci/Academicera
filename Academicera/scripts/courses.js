
document.addEventListener('DOMContentLoaded', function() {
    let courseCards = document.querySelectorAll('.course-item .card');
    courseCards.forEach(function(card) {
        card.addEventListener('click', function() {
            let courseId = card.getAttribute('data-course-id');
            window.location.href = 'edit-course.php?id=' + courseId;
        });
    });

    
});