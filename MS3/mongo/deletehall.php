<?php

$id = $_GET['id'];

$user = 'root';
$pass = '';
$database = 'cinebase';

$conn = new mysqli('localhost', $user, $pass, $database) or die("dead");

// sql to delete a record
$sql = "DELETE FROM hall WHERE hall_id = $id";

if (mysqli_query($conn, $sql)) {
    mysqli_close($conn);
    header('Location: hall_administration.php');
    exit;
} else {
    echo "Error deleting record";
}
?>