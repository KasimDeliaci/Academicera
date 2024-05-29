<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.html');
    exit;
}

include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_name = $_POST['course_name'];
    $instructor = $_POST['instructor'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'];
    $tag_id = $_POST['tag_id']; // Assume tag_id is part of the form submission

    // Check if tag_id is empty, indicating a new tag creation
    if (empty($tag_id)) {
        $tag_name = $_POST['tag_name'];
        $color = $_POST['color'];
        // Insert new tag
        $stmt_tag = $conn->prepare("INSERT INTO tags (user_id, tag_name, color) VALUES (?, ?, ?)");
        $stmt_tag->bind_param("iss", $user_id, $tag_name, $color);
        $stmt_tag->execute();
        $tag_id = $conn->insert_id; // Get the newly created tag ID
        $stmt_tag->close();
    }

    // Prepare and execute the insert statement including tag_id
    $stmt = $conn->prepare("INSERT INTO courses (course_name, instructor, start_date, end_date, description, user_id, tag_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssis", $course_name, $instructor, $start_date, $end_date, $description, $user_id, $tag_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Kurs başarıyla eklendi.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Kurs eklenirken bir hata oluştu.";
        $_SESSION['message_type'] = "danger";
    }

    $stmt->close();
    $conn->close();

    header('Location: ../dashboard.php');
    exit;
} else {
    echo "Invalid request method.";
}
?>
        