<?php
header('Content-Type: application/json');
require_once 'db_connect.php';

// Get raw POST data (JSON)
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
    exit;
}

// Extract and sanitize input fields
$firstName = isset($input['firstName']) ? trim($input['firstName']) : '';
$lastName = isset($input['lastName']) ? trim($input['lastName']) : '';
$email = isset($input['email']) ? trim($input['email']) : '';
$phone = isset($input['phone']) ? trim($input['phone']) : '';
$dateOfBirth = isset($input['dateOfBirth']) ? trim($input['dateOfBirth']) : '';
$membershipType = isset($input['membershipType']) ? trim($input['membershipType']) : '';
$referralCode = isset($input['referralCode']) ? trim($input['referralCode']) : null;
$fitnessGoal = isset($input['fitnessGoal']) ? trim($input['fitnessGoal']) : null;
$workoutTimes = isset($input['workoutTimes']) ? $input['workoutTimes'] : []; // array expected
$experienceLevel = isset($input['experienceLevel']) ? trim($input['experienceLevel']) : null;
$medicalConditions = isset($input['medicalConditions']) ? trim($input['medicalConditions']) : null;
$emergencyContactName = isset($input['emergencyContact']) ? trim($input['emergencyContact']) : '';
$emergencyRelationship = isset($input['emergencyRelationship']) ? trim($input['emergencyRelationship']) : '';
$password = isset($input['password']) ? $input['password'] : '';
$newsletterSubscribed = isset($input['newsletter']) ? boolval($input['newsletter']) : false;

// Basic validation
$errors = [];

if (empty($firstName)) $errors[] = 'First name is required.';
if (empty($lastName)) $errors[] = 'Last name is required.';
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
if (empty($phone)) $errors[] = 'Phone number is required.';
if (empty($dateOfBirth)) $errors[] = 'Date of birth is required.';
if (empty($membershipType)) $errors[] = 'Membership type is required.';
if (empty($emergencyContactName)) $errors[] = 'Emergency contact name is required.';
if (empty($emergencyRelationship)) $errors[] = 'Emergency relationship is required.';
if (empty($password) || strlen($password) < 8) $errors[] = 'Password must be at least 8 characters.';

// Convert workoutTimes array to comma-separated string for storage
$workoutTimesStr = is_array($workoutTimes) ? implode(',', $workoutTimes) : null;

if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit;
}

// Check if email already exists
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    http_response_code(409);
    echo json_encode(['success' => false, 'message' => 'Email is already registered. Please use another email or login.']);
    $stmt->close();
    $conn->close();
    exit;
}
$stmt->close();

// Hash the password securely
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// Insert new user
$insert = $conn->prepare("INSERT INTO users (first_name, last_name, email, phone, date_of_birth, membership_type, referral_code, fitness_goal, workout_times, experience_level, medical_conditions, emergency_contact_name, emergency_relationship, password_hash, newsletter_subscribed) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$insert->bind_param(
    "ssssssssssssssi",
    $firstName,
    $lastName,
    $email,
    $phone,
    $dateOfBirth,
    $membershipType,
    $referralCode,
    $fitnessGoal,
    $workoutTimesStr,
    $experienceLevel,
    $medicalConditions,
    $emergencyContactName,
    $emergencyRelationship,
    $passwordHash,
    $newsletterSubscribed
);

if ($insert->execute()) {
    echo json_encode(['success' => true, 'message' => 'Account created successfully! You can now log in.']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to create account. Please try again later.']);
}

$insert->close();
$conn->close();
?>