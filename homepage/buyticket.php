<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cinebase</title>
    <link rel="stylesheet"
          type="text/css"
          href="css/main.css"/>
    <script src="js/main.js"></script>
</head>
<body>


<?php
session_start();

$screening_id = $_GET['screening_id'];
$customer_id = $_SESSION['customer_id'];

$user = 'root';
$pass = '';
$database = 'cinebase';

$conn = new mysqli('localhost', $user, $pass, $database) or die("dead");

$sql = "INSERT INTO ticket(screening_id, customer_id, price, discount_type) VALUES (\"$screening_id\", \"$customer_id\", 10.00, 0)";

$ticket_id = $conn->query("SELECT ticket_id FROM ticket WHERE customer_id = \"$customer_id\" AND ticket_id = MAX(ticket_id)");

$start_time = $conn->query("SELECT starting_time FROM screening WHERE customer_id = \"$customer_id\"");

if (mysqli_query($conn, $sql)) {
    mysqli_close($conn);
    echo ("<script type=\"text/javascript\">buyTicketSuccess(\"$ticket_id\", $start_time);</script>");
    header('Location: screening.php');
    exit;
} else {
    echo "Error while buying ticket";
}
?>

</body>
</html>

