<?php
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; // Raw password from form

    // Check if email exists
    $stmt = $conn->prepare("SELECT id, first_name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Start session and set user data
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['email'] = $email;

            // Redirect to dashboard
            header("Location: dashboard.html");
            exit();
        } else {
            echo "<script>alert('Invalid password. Please try again.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('No user found with that email. Please check your email or sign up.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    // If someone tries to access login.php directly without a POST request
    echo "<script>alert('Access Denied: Form not submitted.'); window.location.href = 'login.html';</script>";
}



?>