<?php
include '../config.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form fields are set
    if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $user_password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        // Prepare the SQL statement with the correct column order
        $stmt = $conn->prepare("INSERT INTO users (username, first_name, last_name, password, email, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }

        // Bind the parameters
        $stmt->bind_param("sssss", $username, $first_name, $last_name, $user_password, $email);

        // Execute the statement and check for errors
        if ($stmt->execute()) {
            // Redirect with success message
            header('Location: ../register.html?message=Başarıyla kayıt olundu! Giriş sayfasına yönlendiriliyorsunuz...&message_type=success');
            exit();
        } else {
            echo "Execute failed: " . htmlspecialchars($stmt->error);
            // Display more detailed error information
            echo '<pre>';
            print_r($stmt);
            echo '</pre>';
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "All fields are required.";
    }
} else {
    echo "Invalid request method.";
}
?>