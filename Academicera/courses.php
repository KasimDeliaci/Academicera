<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit;
}

include 'templates/header.php';
include 'config.php';

$user_id = $_SESSION['user_id'];

// Fetch the username
$stmt_user = $conn->prepare("SELECT username FROM users WHERE id = ?");
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$stmt_user->bind_result($username);
$stmt_user->fetch();
$stmt_user->close();

// Fetch existing tags
$stmt_tags = $conn->prepare("SELECT id, tag_name, color FROM tags WHERE user_id = ?");
$stmt_tags->bind_param("i", $user_id);
$stmt_tags->execute();
$stmt_tags->bind_result($tag_id, $tag_name, $tag_color);

$unique_tags = [];
while ($stmt_tags->fetch()) {
    $tag_key = $tag_name . '-' . $tag_color;
    if (!isset($unique_tags[$tag_key])) {
        $unique_tags[$tag_key] = ['id' => $tag_id, 'name' => $tag_name, 'color' => $tag_color];
    }
}
$stmt_tags->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style-courses.css?v=1.1">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="scripts/dashboard.js" defer></script>
    <script src="scripts/courses.js" defer></script>
    <script src="scripts/tag.js" defer></script>
    <style>
        .center-message {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 70vh; /* Adjust the height as needed */
            flex-direction: column;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <br>

        <!-- Welcome message -->
        <div class="alert alert-info" role="alert">
            Hoş Geldin, <?= htmlspecialchars($username) ?>
        </div>

        <!-- Display alert message -->
        <?php if(isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['message'] ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php unset($_SESSION['message']); unset($_SESSION['message_type']); ?>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-md-12">
                <div class="card-list">
                    <!-- PHP to fetch and display courses as cards -->
                    <?php
                    $stmt = $conn->prepare("SELECT c.id, c.course_name, c.instructor, c.start_date, c.end_date, c.description, t.tag_name, t.color 
                                            FROM courses c 
                                            LEFT JOIN tags t ON c.tag_id = t.id 
                                            WHERE c.user_id = ?");
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $stmt->bind_result($course_id, $course_name, $instructor, $start_date, $end_date, $description, $tag_name, $color);

                    $courses_exist = false;

                    while ($stmt->fetch()) {
                        $courses_exist = true;
                        echo "<div class='course-item'>
                                <div class='card fixed-height-card grow' data-course-id='$course_id'>
                                    <div class='card-body card-body-courses'>
                                        <h5 class='card-title'>$course_name</h5>
                                        <h6 class='card-subtitle mb-2 text-muted'>$instructor</h6>
                                        <p class='card-text'>Başlangıç: $start_date<br>Bitiş: $end_date</p>
                                        <p class='card-text description'>&#8226; $description</p>
                                        <span class='badge' style='background-color: $color;' data-color='$color'>$tag_name</span>
                                    </div>
                                </div>
                              </div>";
                    }

                    if (!$courses_exist) {
                        echo "<div class='center-message card-list'>
                                <div class='alert alert-info' role='alert'>
                                    Oopps hiç kurs bulamadık! Hemen kurs ekleyin.
                                </div>
                                <a href='dashboard.php' class='btn btn-primary'>Kurs Ekle</a>
                              </div>
                              <img src='empty.png' alt='empty'  style='max-width: 400px;'>";
                    }

                    $stmt->close();
                    $conn->close();
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $(".alert").not('.alert-info').fadeTo(1500, 500).slideUp(500, function() {
            $(this).remove(); 
        });
    });
    </script>
</body>
</html>