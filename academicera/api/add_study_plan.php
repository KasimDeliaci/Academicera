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
    $plan_date = $_POST['plan_date'];
    $goals = $_POST['goals'];

    $stmt = $conn->prepare("INSERT INTO study_plans (course_id, user_id, plan_date, goals) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $course_id, $user_id, $plan_date, $goals);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Çalışma Planı başarıyla eklendi.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Çalışma Planı eklenirken bir hata oluştu.";
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