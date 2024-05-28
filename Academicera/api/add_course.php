<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.html');
    exit;
}
include '../config.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$user_id = $_SESSION['user_id'];

// Fetch existing tags
$stmt_tags = $conn->prepare("SELECT id, tag_name, color FROM tags WHERE user_id = ?");
$stmt_tags->bind_param("i", $user_id);
$stmt_tags->execute();
$stmt_tags->bind_result($tag_id, $tag_name, $tag_color);

$tags = [];
$unique_tags = [];
while ($stmt_tags->fetch()) {
    $tag_key = $tag_name . '-' . $tag_color;
    if (!isset($unique_tags[$tag_key])) {
        $unique_tags[$tag_key] = ['id' => $tag_id, 'name' => $tag_name, 'color' => $tag_color];
    }
}
$stmt_tags->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_name = $_POST['course_name'];
    $instructor = $_POST['instructor'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $description = $_POST['description'];
    $tag_id = $_POST['tag_id'] ?? null;
    $tag_name = $_POST['tag_name'] ?? null;
    $color = $_POST['color'] ?? null;

    // If a new tag is being created
    if (!$tag_id && $tag_name && $color) {
        $stmt_tag = $conn->prepare("INSERT INTO tags (tag_name, color, user_id) VALUES (?, ?, ?)");
        if ($stmt_tag === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }
        $stmt_tag->bind_param("ssi", $tag_name, $color, $user_id);

        if ($stmt_tag->execute()) {
            $tag_id = $stmt_tag->insert_id;
        } else {
            die("Tag insertion failed: " . htmlspecialchars($stmt_tag->error));
        }
        $stmt_tag->close();
    }

    // Prepare the SQL statement for inserting the course
    $stmt = $conn->prepare("INSERT INTO courses (user_id, course_name, instructor, start_date, end_date, description, tag_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("isssssi", $user_id, $course_name, $instructor, $start_date, $end_date, $description, $tag_id);

    if ($stmt->execute()) {
        echo "Course added successfully!";
        header('Location: ../courses.php');
        exit();
    } else {
        die("Execute failed: " . htmlspecialchars($stmt->error));
    }

    $stmt->close();
    $conn->close();
}
?>