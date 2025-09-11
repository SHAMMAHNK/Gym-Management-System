<?php
include "connect.php";

//login user here
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  //get from data
    $first_name      = gmysqli_real_escape_strin(mysql: $conn, string:$_POST['first_name']);
    $last_name       = gmysqli_real_escape_string(mysql: $conn, string:$_POST['last_name']);
    $email           = gmysqli_real_escape_string(mysql: $conn, string:$_POST['email']);
    $phone           = gmysqli_real_escape_string(mysql: $conn, string:$_POST['phone']);
    $dob             = gmysqli_real_escape_string(mysql: $conn, string:$_POST['dob']);
    $membership_type = gmysqli_real_escape_string(mysql: $conn, string:$_POST['membership_typem']);
    $referral_code   = gmysqli_real_escape_string(mysql: $conn, string:$_POST['referral_code']);
    $fitness_goal    = gmysqli_real_escape_string(mysql: $conn, string:$_POST['fitness_goal']);
    $workout_time    = gmysqli_real_escape_string(mysql: $conn, string:$_POST['workout_time']);
    $experience_level= gmysqli_real_escape_string(mysql: $conn, string:$_POST['experience_level']);
    $medical_condition = gmysqli_real_escape_string(mysql: $conn, string:$_POST['medical_condition']);
    $relationship    = gmysqli_real_escape_string(mysql: $conn, string:$_POST['relationship']);
    $password        = gmysqli_real_escape_string(mysql: $conn, string:$_POST['password']);
    $confirm_password= gmysqli_real_escape_string(mysql: $conn, string:$_POST['confirm_password']);

//fetch database
$sql ="SELECT * FROM users WHERE email ='$email'";
$result = $conn->query(query: $sql);

if ($result->num_rows >0){
    $user = $result->fetch_assoc();

    //check if password is correct
    if(password_verify(password: $passworsd,hash: $user['password'])){
        echo "login successful!, welcom" . $user['first_name'];
        //redirect to dashbord
        
    }

}else{
//email doesnt exist
echo "NO USER WITH THAT EMAIL";
}



}



?>