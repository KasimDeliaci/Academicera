<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.html');
    exit;
}

include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $plan_id = $_POST['plan_id'];
    $course_id = $_POST['course_id'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("DELETE FROM study_plans WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $plan_id, $user_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Çalışma Planı başarıyla silindi.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Çalışma Planı silinirken bir hata oluştu.";
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