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

    // Begin a transaction
    $conn->begin_transaction();

    try {
        // Delete exams associated with the course
        $stmt_exams = $conn->prepare("DELETE FROM exams WHERE course_id = ? AND user_id = ?");
        $stmt_exams->bind_param("ii", $course_id, $user_id);
        $stmt_exams->execute();
        $stmt_exams->close();

        // Delete assignments associated with the course
        $stmt_assignments = $conn->prepare("DELETE FROM assignments WHERE course_id = ? AND user_id = ?");
        $stmt_assignments->bind_param("ii", $course_id, $user_id);
        $stmt_assignments->execute();
        $stmt_assignments->close();

        // Delete study plans associated with the course
        $stmt_study_plans = $conn->prepare("DELETE FROM study_plans WHERE course_id = ? AND user_id = ?");
        $stmt_study_plans->bind_param("ii", $course_id, $user_id);
        $stmt_study_plans->execute();
        $stmt_study_plans->close();

        // Delete the course
        $stmt_course = $conn->prepare("DELETE FROM courses WHERE id = ? AND user_id = ?");
        $stmt_course->bind_param("ii", $course_id, $user_id);
        $stmt_course->execute();
        $stmt_course->close();

        // Commit the transaction
        $conn->commit();

        $_SESSION['message'] = "Kurs ve ilgili tüm varlıklar başarıyla silindi.";
        $_SESSION['message_type'] = "success";
    } catch (Exception $e) {
        // Rollback the transaction on error
        $conn->rollback();
        $_SESSION['message'] = "Kurs silinirken bir hata oluştu: " . $e->getMessage();
        $_SESSION['message_type'] = "danger";
    }

    $conn->close();
} else {
    $_SESSION['message'] = "Invalid request method.";
    $_SESSION['message_type'] = "danger";
}

header('Location: ../courses.php?deleted=true');
exit;
?>