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
    $course_name = $_POST['course_name'];
    $instructor = $_POST['instructor'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $description = $_POST['description'];
    $tag_id = $_POST['tag_id'];

    // Fetch existing course details for comparison
    $stmt = $conn->prepare("SELECT course_name, instructor, start_date, end_date, description, tag_id FROM courses WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $course_id, $user_id);
    $stmt->execute();
    $stmt->bind_result($existing_course_name, $existing_instructor, $existing_start_date, $existing_end_date, $existing_description, $existing_tag_id);
    $stmt->fetch();
    $stmt->close();

    // Check if any changes were made
    if (
        $course_name === $existing_course_name &&
        $instructor === $existing_instructor &&
        $start_date === $existing_start_date &&
        $end_date === $existing_end_date &&
        $description === $existing_description &&
        $tag_id === $existing_tag_id
    ) {
        // No changes detected, reload the page without updating
        $_SESSION['message'] = "Hiçbir değişiklik yapılmadı.";
        $_SESSION['message_type'] = "info";
        header('Location: ../edit-course.php?id=' . $course_id);
        exit;
    }

    // Check if tag_id is empty, indicating a new tag creation
    if (empty($tag_id)) {
        $tag_name = $_POST['tag_name'];
        $color = $_POST['color'];

        // Insert new tag
        $stmt_tag = $conn->prepare("INSERT INTO tags (user_id, tag_name, color) VALUES (?, ?, ?)");
        $stmt_tag->bind_param("iss", $user_id, $tag_name, $color);
        $stmt_tag->execute();
        $tag_id = $conn->insert_id;
        $stmt_tag->close();
    }

    // Prepare and execute the update statement including tag_id
    $stmt = $conn->prepare("UPDATE courses SET course_name = ?, instructor = ?, start_date = ?, end_date = ?, description = ?, tag_id = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("sssssiis", $course_name, $instructor, $start_date, $end_date, $description, $tag_id, $course_id, $user_id);
    if ($stmt->execute()) {
        // Check the number of affected rows
        if ($stmt->affected_rows > 0) {
            $_SESSION['message'] = "Ders başarıyla güncellendi.";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Hiçbir değişiklik yapılmadı.";
            $_SESSION['message_type'] = "info";
        }
        header('Location: ../edit-course.php?id=' . $course_id);
        exit; // Ensure no further execution after redirect
    } else {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>