<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit;
}

include 'templates/header-edit-course.php';
include 'config.php';

$course_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Fetch course details
$stmt_course = $conn->prepare("SELECT course_name, instructor, start_date, end_date, description, tag_id FROM courses WHERE id = ? AND user_id = ?");
$stmt_course->bind_param("ii", $course_id, $user_id);
$stmt_course->execute();
$stmt_course->bind_result($course_name, $instructor, $start_date, $end_date, $description, $tag_id);
$stmt_course->fetch();
$stmt_course->close();

// Fetch tag details
$stmt_tag = $conn->prepare("SELECT tag_name, color FROM tags WHERE id = ? AND user_id = ?");
$stmt_tag->bind_param("ii", $tag_id, $user_id);
$stmt_tag->execute();
$stmt_tag->bind_result($tag_name, $tag_color);
$stmt_tag->fetch();
$stmt_tag->close();

// Fetch existing tags
$stmt_tags = $conn->prepare("SELECT id, tag_name, color FROM tags WHERE user_id = ?");
$stmt_tags->bind_param("i", $user_id);
$stmt_tags->execute();
$stmt_tags->bind_result($existing_tag_id, $existing_tag_name, $existing_tag_color);

$unique_tags = [];
while ($stmt_tags->fetch()) {
    $tag_key = $existing_tag_name . '-' . $existing_tag_color;
    if (!isset($unique_tags[$tag_key])) {
        $unique_tags[$tag_key] = ['id' => $existing_tag_id, 'name' => $existing_tag_name, 'color' => $existing_tag_color];
    }
}
$stmt_tags->close();

function getContrastYIQ($hexcolor)
{
    $r = hexdec(substr($hexcolor, 1, 2));
    $g = hexdec(substr($hexcolor, 3, 2));
    $b = hexdec(substr($hexcolor, 5, 2));
    $yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
    return ($yiq >= 128) ? 'black' : 'white';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/edit-course.css?v=1.1">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="scripts/tag.js" defer></script>
    <script src="scripts/courses.js" defer></script>
    <script src="scripts/edit-course.js" defer></script>
</head>

<body>
    <div class="container mt-6">
        <br>

        <!-- Display alert message -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['message'] ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php unset($_SESSION['message']);
            unset($_SESSION['message_type']); ?>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-4">
                <!-- Edit Course Form -->
                <div id="edit-course-form" class="form-card">
                    <div class="card mb-4 course-card">
                        <div class="card-body">
                            <h4 class="card-title text-center">Ders Düzenle</h4>
                            <form action="api/update_course.php" method="post">
                                <input type="hidden" name="course_id" value="<?= $course_id ?>">
                                <div class="form-group">
                                    <label for="course_name">Ders Kodu:</label>
                                    <input type="text" class="form-control" id="course_name" name="course_name"
                                        value="<?= htmlspecialchars($course_name) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="instructor">Eğitmen:</label>
                                    <input type="text" class="form-control" id="instructor" name="instructor"
                                        value="<?= htmlspecialchars($instructor) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="start_date">Başlangıç Tarihi:</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date"
                                        value="<?= $start_date ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="end_date">Bitiş Tarihi:</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date"
                                        value="<?= $end_date ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="tag_id">Etiket Seç:</label>
                                    <select class="form-control" id="tag_id" name="tag_id">
                                        <option value="">Yeni Etiket Oluştur</option>
                                        <?php foreach ($unique_tags as $tag): ?>
                                            <option value="<?= $tag['id'] ?>" style="color: <?= $tag['color'] ?>"
                                                <?= ($tag['id'] == $tag_id) ? 'selected' : '' ?>>
                                                <?= $tag['name'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div id="new-tag-section" class="form-group d-none">
                                    <label for="tag_name">Yeni Etiket:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="tag_name" name="tag_name">
                                        <input type="color" class="form-control" id="color" name="color"
                                            style="max-width: 60px;">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="description">Ders Açıklaması:</label>
                                    <textarea class="form-control" id="description" name="description" rows="3"
                                        required><?= htmlspecialchars($description) ?></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Ders Güncelle</button>
                            </form>
                            <form action="api/delete_course.php" method="post" class="mt-2">
                                <input type="hidden" name="course_id" value="<?= $course_id ?>">
                                <button type="submit" class="btn btn-danger btn-block">Ders Sil</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Add Study Plan Form -->
                <div id="add-study-plan-form" class="form-card d-none">
                    <div class="card mb-4 course-card">
                        <div class="card-body">
                            <h4 class="card-title text-center">Çalışma Planı Ekle</h4>
                            <form action="api/add_study_plan.php" method="post">
                                <input type="hidden" name="course_id" value="<?= $course_id ?>">
                                <div class="form-group">
                                    <label for="plan_date">Plan Tarihi:</label>
                                    <input type="date" class="form-control" id="plan_date" name="plan_date" required>
                                </div>
                                <div class="form-group">
                                    <label for="goals">Hedefler:</label>
                                    <textarea class="form-control" id="goals" name="goals" rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Çalışma Planı Ekle</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Add Assignment Form -->
                <div id="add-assignment-form" class="form-card d-none">
                    <div class="card mb-4 course-card">
                        <div class="card-body">
                            <h4 class="card-title text-center">Ödev/Proje Ekle</h4>
                            <form action="api/add_assignment.php" method="post">
                                <input type="hidden" name="course_id" value="<?= $course_id ?>">
                                <div class="form-group">
                                    <label for="title">Başlık:</label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                                <div class="form-group">
                                    <label for="due_date">Teslim Tarihi:</label>
                                    <input type="date" class="form-control" id="due_date" name="due_date" required>
                                </div>
                                <div class="form-group">
                                    <label for="description">Açıklama:</label>
                                    <textarea class="form-control" id="description" name="description" rows="3"
                                        required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Ödev/Proje Ekle</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Add Exam Form -->
                <div id="add-exam-form" class="form-card d-none">
                    <div class="card mb-4 course-card">
                        <div class="card-body">
                            <h4 class="card-title text-center">Sınav/Quiz Ekle</h4>
                            <form action="api/add_exam.php" method="post">
                                <input type="hidden" name="course_id" value="<?= $course_id ?>">
                                <div class="form-group">
                                    <label for="title">Başlık:</label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                                <div class="form-group">
                                    <label for="exam_date">Sınav Tarihi:</label>
                                    <input type="date" class="form-control" id="exam_date" name="exam_date" required>
                                </div>
                                <div class="form-group">
                                    <label for="description">Açıklama:</label>
                                    <textarea class="form-control" id="description" name="description" rows="3"
                                        required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Sınav/Quiz Ekle</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card-list">
                    <!-- Detailed course information can be shown here -->
                    <div class="card fixed-height-card grow">
                        <div class="card-body">
                            <h5 class="card-title">Ders Detayları</h5>
                            <p class="card-text">Ders Kodu: <?= htmlspecialchars($course_name) ?></p>
                            <p class="card-text">Eğitmen: <?= htmlspecialchars($instructor) ?></p>
                            <p class="card-text">Başlangıç Tarihi: <?= htmlspecialchars($start_date) ?></p>
                            <p class="card-text">Bitiş Tarihi: <?= htmlspecialchars($end_date) ?></p>
                            <p class="card-text">&#8226; <?= htmlspecialchars($description) ?></p>
                            <p class="card-text"><span class="badge"
                                    style="background-color: <?= $tag_color ?>; color: <?= getContrastYIQ($tag_color) ?>"><?= htmlspecialchars($tag_name) ?></span>
                            </p>
                        </div>
                    </div>

                    <!-- List of Study Plans -->
                    <div class="card fixed-height-card grow">
                        <div class="card-body">
                            <h5 class="card-title">Çalışma Planları</h5>
                            <div class="row">
                                <?php
                                $stmt_plans = $conn->prepare("SELECT id, plan_date, goals FROM study_plans WHERE course_id = ? AND user_id = ?");
                                $stmt_plans->bind_param("ii", $course_id, $user_id);
                                $stmt_plans->execute();
                                $stmt_plans->bind_result($plan_id, $plan_date, $goals);

                                while ($stmt_plans->fetch()) {
                                    echo "<div class='col-md-6'>
                                        <div class='card mb-2 grow'>
                                            <div class='card-body'>
                                                <h6 class='card-subtitle mb-2 text-muted'>Plan Tarihi: $plan_date</h6>
                                                <p class='card-text'>$goals</p>
                                                <form action='api/delete_study_plan.php' method='post' class='d-inline'>
                                                    <input type='hidden' name='plan_id' value='$plan_id'>
                                                    <input type='hidden' name='course_id' value='$course_id'>
                                                    <button type='submit' class='btn btn-danger btn-sm'>Sil</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>";
                                }
                                $stmt_plans->close();
                                ?>
                            </div>
                        </div>
                    </div>

                    <!-- List of Assignments -->
                    <div class="card fixed-height-card grow">
                        <div class="card-body">
                            <h5 class="card-title">Ödevler/Projeler</h5>
                            <?php
                            $stmt_assignments = $conn->prepare("SELECT id, title, due_date, description FROM assignments WHERE course_id = ? AND user_id = ?");
                            $stmt_assignments->bind_param("ii", $course_id, $user_id);
                            $stmt_assignments->execute();
                            $stmt_assignments->bind_result($assignment_id, $title, $due_date, $description);

                            while ($stmt_assignments->fetch()) {
                                echo "<div class='col-md-6'>
                                    <div class='card mb-2 grow'>
                                        <div class='card-body'>
                                            <h6 class='card-subtitle mb-2 text-muted'>Teslim Tarihi: $due_date</h6>
                                            <p class='card-text'>$title</p>
                                            <p class='card-text'>$description</p>
                                            <form action='api/delete_assignment.php' method='post' class='d-inline'>
                                                <input type='hidden' name='assignment_id' value='$assignment_id'>
                                                <input type='hidden' name='course_id' value='$course_id'>
                                                <button type='submit' class='btn btn-danger btn-sm'>Sil</button>
                                            </form>
                                        </div>
                                    </div>
                                  </div>";
                            }
                            $stmt_assignments->close();
                            ?>
                        </div>
                    </div>

                    <!-- List of Exams -->
                    <div class="card fixed-height-card grow">
                        <div class="card-body">
                            <h5 class="card-title">Sınavlar/Quizler</h5>
                            <?php
                            $stmt_exams = $conn->prepare("SELECT id, title, exam_date, description FROM exams WHERE course_id = ? AND user_id = ?");
                            $stmt_exams->bind_param("ii", $course_id, $user_id);
                            $stmt_exams->execute();
                            $stmt_exams->bind_result($exam_id, $title, $exam_date, $description);

                            while ($stmt_exams->fetch()) {
                                echo "<div class='col-md-6'>
                                    <div class='card mb-2 grow'>
                                        <div class='card-body'>
                                            <h6 class='card-subtitle mb-2 text-muted'>Sınav Tarihi: $exam_date</h6>
                                            <p class='card-text'>$title</p>
                                            <p class='card-text'>$description</p>
                                            <form action='api/delete_exam.php' method='post' class='d-inline'>
                                                <input type='hidden' name='exam_id' value='$exam_id'>
                                                <input type='hidden' name='course_id' value='$course_id'>
                                                <button type='submit' class='btn btn-danger btn-sm'>Sil</button>
                                            </form>
                                        </div>
                                    </div>
                                  </div>";
                            }
                            $stmt_exams->close();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tagSelect = document.getElementById('tag_id');
            const newTagSection = document.getElementById('new-tag-section');
            const tagNameInput = document.getElementById('tag_name');
            const colorInput = document.getElementById('color');

            tagSelect.addEventListener('change', function () {
                if (tagSelect.value === '') {
                    newTagSection.classList.remove('d-none');
                    tagNameInput.required = true;
                    colorInput.required = true;
                } else {
                    newTagSection.classList.add('d-none');
                    tagNameInput.required = false;
                    colorInput.required = false;
                }
            });

            if (tagSelect.value === '') {
                newTagSection.classList.remove('d-none');
                tagNameInput.required = true;
                colorInput.required = true;
            }
        });
    </script>
    <script>
        $(document).ready(function () {
            $(".alert").fadeTo(1500, 500).slideUp(500, function () {
                $(this).remove();
            });
        });
    </script>
</body>

</html>