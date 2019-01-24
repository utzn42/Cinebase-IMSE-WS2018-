<?php


$user = 'root';
$pass = '';
$database = 'cinebase';

$conn = new mysqli('localhost', $user, $pass, $database) or die("dead");


?>
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

<a href="ticket.php">Back to Tickets</a><br><br>
<div>
    <form id='updateform' action="" method="get">
        Update ticket:
        <table style='border: 1px solid #DDDDDD'>
            <thead>
            <tr>
                <th>Ticket ID</th>
                <th>Screening ID</th>
                <th>Customer ID</th>
                <th>Price</th>
                <th>Discount Type</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <input id='ticket_id' name='ticket_id' type='text' size='20' readonly
                           value='<?php echo $_GET['ticket_id']; ?>'/>
                </td>
                <td>
                    <input id='screening_id' name='screening_id' type='text' size='20'
                           value='<?php echo $_GET['screening_id']; ?>'/>
                </td>
                <td>
                    <input id='customer_id' name='customer_id' type='text' size='20'
                           value='<?php echo $_GET['customer_id']; ?>'/>
                </td>
                <td>
                    <input id='price' name='price' type='text' size='20'
                           value='<?php echo $_GET['price']; ?>'/>
                </td>
                <td>
                    <input id='discount_type' name='discount_type' type='text' size='20'
                           value='<?php echo $_GET['discount_type']; ?>'/>
                </td>
            </tr>
            </tbody>
        </table>
        <input id='submit' type='submit' name="submit" value='Update!'/>
    </form>
</div>

<?php


if (isset($_GET["submit"])) {

    $ticket_id = $_GET['ticket_id'];
    $screening_id = $_GET['screening_id'];
    $customer_id = $_GET['customer_id'];
    $price = $_GET['price'];
    $discount_type = $_GET['discount_type'];

    // sql to update a record
    $sql = "UPDATE ticket 
		SET screening_id = \"$screening_id\",
		customer_id=\"$customer_id\",
		price=\"$price\",
		discount_type=\"$discount_type\" 
		WHERE ticket_id = $ticket_id";


    //Parse and execute statement
    if ($conn->query($sql) === TRUE) {
        echo "Record updated succesfully";
        header("location: ticket.php");

    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


?>
</body>
</html>