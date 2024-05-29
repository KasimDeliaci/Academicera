<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit;
}

include 'templates/header.php';
include 'config.php';

$user_id = $_SESSION['user_id'];

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

// Handle deletion of tag from unique_tags array
if (isset($_SESSION['deleted_tag_id'])) {
    $deleted_tag_id = $_SESSION['deleted_tag_id'];
    foreach ($unique_tags as $key => $tag) {
        if ($tag['id'] == $deleted_tag_id) {
            unset($unique_tags[$key]);
            break;
        }
    }
    unset($_SESSION['deleted_tag_id']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css?v=1.1">
    <script src="scripts/dashboard.js" defer></script>
    <script src="scripts/courses.js" defer></script>
    <script src="scripts/tag.js" defer></script>
</head>
<body>
    <div class="container mt-6">
        <br>
        
        <div class="row">
            <div class="col-md-4">
                <!-- Course Card with Form -->
                <div class="card mb-4 course-card">
                    <div class="card-body">
                        <h4 class="card-title text-center"> + Yeni Ders Ekle</h4>
                        <p class="card-text text-center" style="font-size: 13px;">Dersinizi ekleyerek hemen odaklanmaya başlayın!</p>
                        <form action="api/add_course.php" method="post" id="courseForm">
                            <div class="form-group">
                                <label for="course_name">Ders Kodu:</label>
                                <input type="text" class="form-control" id="course_name" name="course_name" required>
                            </div>
                            <div class="form-group">
                                <label for="instructor">Eğitmen:</label>
                                <input type="text" class="form-control" id="instructor" name="instructor" required>
                            </div>
                            <div class="form-group">
                                <label for="start_date">Başlangıç Tarihi:</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                            <div class="form-group">
                                <label for="end_date">Bitiş Tarihi:</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>
                            <div class="form-group">
                                <label for="tag_id">Etiket Seç:</label>
                                <select class="form-control" id="tag_id" name="tag_id">
                                    <option value="">Yeni Etiket Oluştur</option>
                                    <?php foreach ($unique_tags as $tag): ?>
                                        <option value="<?= $tag['id'] ?>" style="color: <?= $tag['color'] ?>;">
                                            <?= $tag['name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div id="new-tag-section" class="form-group">
                                <label for="tag_name">Yeni Etiket:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="tag_name" name="tag_name" required>
                                    <input type="color" class="form-control" id="color" name="color" style="max-width: 60px;" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description">Ders Açıklaması:</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Kurs Ekle</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
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
                                <img src='empty.png' alt='empty' height='400px;' ma>
                              </div>";
                    }

                    $stmt->close();
                    $conn->close();
                    ?>
                </div>
                <div class="text-center mt-4">
                    <button class="btn btn-secondary" id='show-course'>Tüm Dersleri Gör</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>