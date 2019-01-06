<?php

session_start();

$password = $_GET['pw'];
$_SESSION['password'] = $password;
$customerID = $_SESSION['customer_id'];

$user = 'root';
$pass = '';
$database = 'cinebase';

$conn = new mysqli('localhost', $user, $pass, $database) or die("dead");

// sql to delete a record
$sql = "UPDATE customer SET password = \"$password\" WHERE customer_id = \"$customerID\"";

if (mysqli_query($conn, $sql)) {
    mysqli_close($conn);
    header('Location: user.php');
    exit;
} else {
    echo "Error updating record";
}
?>