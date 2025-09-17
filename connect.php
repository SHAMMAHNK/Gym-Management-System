<?php
$servername = "localhost";
$username   = "root"; // Your MySQL username
$password   = "";     // Your MySQL password
$dbname     = "gym";  // Your database name
//$port       = 3307;   // Use 3306 if it's the default MySQL port, or your specific port

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname); // Add $port as the fifth parameter if needed

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else {
    echo "Connected successfully!";
    // Uncomment the line below for debugging purposes
    // echo "Connected successfully";
}
// Optional: You can remove the "Connected successfully!" echo for production
// echo "Connected successfully!";
?>
