<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.html');
    exit;
}

include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $assignment_id = $_POST['assignment_id'];
    $course_id = $_POST['course_id']; // Ensure course_id is sent in the form
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("DELETE FROM assignments WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $assignment_id, $user_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Ödev başarıyla silindi.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Ödev silinirken bir hata oluştu.";
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