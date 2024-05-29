<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.html');
    exit;
}

include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = $_POST['course_id'];
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $due_date = $_POST['due_date'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO assignments (course_id, user_id, title, due_date, description) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $course_id, $user_id, $title, $due_date, $description);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Ödev başarıyla eklendi.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Ödev eklenirken bir hata oluştu.";
        $_SESSION['message_type'] = "danger";
    }

    $stmt->close();
    $conn->close();

    header('Location: ../edit-course.php?id=' . $course_id);
    exit;
} else {
    echo "Invalid request method.";
}
?>