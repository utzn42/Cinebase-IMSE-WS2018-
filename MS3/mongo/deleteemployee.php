<?php

$id = $_GET['id'];

$user = 'root';
$pass = '';
$database = 'cinebase';

$conn = new mysqli('localhost', $user, $pass, $database) or die("dead");

// sql to delete a record
$sql = "DELETE FROM employee WHERE employee_nr = $id";

if (mysqli_query($conn, $sql)) {
    mysqli_close($conn);
    header('Location: employee_administration.php');
    exit;
} else {
    echo "Error deleting record";
}
?>