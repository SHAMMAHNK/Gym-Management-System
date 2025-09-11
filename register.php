<?php
// Include your database connection file
include "connect.php";

// Check if the form was submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Sanitize and Validate Inputs
    // Use mysqli_real_escape_string to prevent SQL injection
    // Use trim to remove whitespace
    // Filter_var for email validation

    $first_name = $conn->real_escape_string(trim($_POST['firstName']));
    $last_name = $conn->real_escape_string(trim($_POST['lastName']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $phone = $conn->real_escape_string(trim($_POST['phone']));
    $dob = $conn->real_escape_string(trim($_POST['dateOfBirth']));
    $membership_type = $conn->real_escape_string(trim($_POST['membershipType']));
    $referral_code = $conn->real_escape_string(trim($_POST['referralCode']));
    $fitness_goal = $conn->real_escape_string(trim($_POST['fitnessGoal']));

    // Handle workout_time checkboxes - store as comma-separated string
    $workout_times_array = isset($_POST['workoutTime']) ? $_POST['workoutTime'] : [];
    $workout_time = $conn->real_escape_string(implode(",", $workout_times_array));

    $experience_level = $conn->real_escape_string(trim($_POST['experienceLevel']));
    $medical_conditions = $conn->real_escape_string(trim($_POST['medicalConditions']));
    $emergency_contact = $conn->real_escape_string(trim($_POST['emergencyContact']));
    $emergency_relationship = $conn->real_escape_string(trim($_POST['emergencyRelationship']));
    $password = $_POST['password']; // Raw password from form
    $confirm_password = $_POST['confirmPassword']; // Raw confirm password from form

    // Basic server-side validation (more comprehensive validation should be done client-side too)
    $errors = [];

    if (empty($first_name)) { $errors[] = "First name is required."; }
    if (empty($last_name)) { $errors[] = "Last name is required."; }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors[] = "Valid email is required."; }
    if (empty($phone)) { $errors[] = "Phone number is required."; }
    if (empty($dob)) { $errors[] = "Date of birth is required."; }
    if (empty($membership_type)) { $errors[] = "Membership type is required."; }
    if (empty($emergency_contact)) { $errors[] = "Emergency contact is required."; }
    if (empty($emergency_relationship)) { $errors[] = "Emergency contact relationship is required."; }
    if (empty($password) || strlen($password) < 8) { $errors[] = "Password must be at least 8 characters."; }
    if ($password !== $confirm_password) { $errors[] = "Passwords do not match."; }

    // If there are validation errors, display them and stop
    if (!empty($errors)) {
        echo "<script>alert('" . implode("\\n", $errors) . "'); window.history.back();</script>";
        exit();
    }

    // 2. Check if email already exists
    $checkEmailSql = "SELECT id FROM users WHERE email = '$email'";
    $result = $conn->query($checkEmailSql);

    if ($result->num_rows > 0) {
        echo "<script>alert('Email already exists. Please use a different email or login.'); window.location.href = 'signup.html';</script>";
        exit(); // Stop execution
    }

    // 3. Hash the password
    // Use password_hash() for secure password storage
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // 4. Prepare and Execute SQL INSERT Statement
    $sql = "INSERT INTO users (
                first_name, last_name, email, phone, dob, membership_type,
                referral_code, fitness_goal, workout_time, experience_level,
                medical_conditions, emergency_contact, emergency_relationship, password
            ) VALUES (
                '$first_name', '$last_name', '$email', '$phone', '$dob', '$membership_type',
                '$referral_code', '$fitness_goal', '$workout_time', '$experience_level',
                '$medical_conditions', '$emergency_contact', '$emergency_relationship', '$hashed_password'
            )";

    if ($conn->query($sql) === TRUE) {
        // Registration successful
        echo "<script>alert('Account created successfully! Welcome to Gym Master!'); window.location.href = 'dashboard.html';</script>";
    } else {
        // Error during insertion
        echo "<script>alert('Error: " . $sql . "\\n" . $conn->error . "'); window.history.back();</script>";
    }

    // 5. Close the database connection
    $conn->close();

} else {
    // If someone tries to access register.php directly without a POST request
    echo "<script>alert('Access Denied: Form not submitted.'); window.location.href = 'signup.html';</script>";
}
?>