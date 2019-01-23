<?php

$id = $_GET['id'];

$user = 'root';
$pass = '';
$database = 'cinebase';

echo $id;

$conn = new mysqli('localhost', $user, $pass, $database) or die("dead");

// sql to delete a record
$sql = "DELETE FROM customer WHERE customer_id = $id";

if (mysqli_query($conn, $sql)) {
    mysqli_close($conn);
    header('Location: logout.php');
    exit;
} else {
    echo "Error deleting record";
}
?>