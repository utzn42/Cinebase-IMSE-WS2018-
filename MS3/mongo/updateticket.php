<?php

$ticket_id = $_GET['ticket_id'];
$screening_id = $_GET['screening_id'];
$customer_id = $_GET['customer_id'];
$price = $_GET['price'];
$discount_type = $_GET['discount_type'];

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
  <form id='updateform' action="" method="post">
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
          <input id='new_ticket_id' name='new_ticket_id' type='text' size='20'
                 value='<?php echo $_GET['ticket_id']; ?>'/>
        </td>
        <td>
          <input id='new_screening_id' name='new_screening_id' type='text' size='20'
                 value='<?php echo $_GET['screening_id']; ?>'/>
        </td>
        <td>
          <input id='new_customer_id' name='new_customer_id' type='text' size='20'
                 value='<?php echo $_GET['customer_id']; ?>'/>
        </td>
        <td>
          <input id='new_price' name='new_price' type='text' size='20'
                 value='<?php echo $_GET['price']; ?>'/>
        </td>
        <td>
          <input id='new_discount_type' name='new_discount_type' type='text' size='20'
                 value='<?php echo $_GET['discount_type']; ?>'/>
        </td>
        <td>
          <input id='old_ticket_id' name='old_ticket_id' type='text' size='20' hidden
                 value='<?php echo $_GET['ticket_id']; ?>'/>
        </td>
      </tr>
      </tbody>
    </table>
    <input id='submit' type='submit' name="submit" value='Update!'/>
  </form>
</div>

<?php


if (isset($_POST["submit"])) {

    //Handle insert
    try {

        $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");


        $old_ticket_id = $_POST['old_ticket_id'];
        $new_ticket_id = $_POST['new_ticket_id'];
        $new_screening_id = $_POST['new_screening_id'];
        $new_customer_id = $_POST['new_customer_id'];
        $new_price = $_POST['new_price'];
        $new_discount_type = $_POST['new_discount_type'];

        echo $new_ticket_id;

        $filter = ['_id' => intval($new_customer_id)];
        $query = new MongoDB\Driver\Query($filter);
        $rows = $mng->executeQuery("cinebase.customers", $query);

        $ticketIndex = 0;

        foreach ($rows as $row) {

            $ticketsArray = $row->tickets;

            $count = 0;
            foreach ($row->tickets as $key => $value) {

                if ($ticketsArray[$count]->_id == intval($old_ticket_id)) {
                    $ticketIndex = $count;
                    break;
                }

                $count++;
            }

        }

        $bulk = new MongoDB\Driver\BulkWrite;


        $bulk->update(['_id' => intval($new_customer_id)], ['$set' => ["tickets." . $ticketIndex . "._id" => intval($new_ticket_id)]]);
        $bulk->update(['_id' => intval($new_customer_id)], ['$set' => ["tickets." . $ticketIndex . ".price" => $new_price]]);
        $bulk->update(['_id' => intval($new_customer_id)], ['$set' => ["tickets." . $ticketIndex . ".discount_type" => $new_discount_type]]);


        $mng->executeBulkWrite('cinebase.customers', $bulk);
        header("location: ticket.php");

    } catch (MongoDB\Driver\Exception\Exception $e) {

        $filename = basename(__FILE__);

        echo "The $filename script has experienced an error.\n";
        echo "It failed with the following exception:\n";

        echo "Exception:", $e->getMessage(), "\n";
        echo "In file:", $e->getFile(), "\n";
        echo "On line:", $e->getLine(), "\n";
    }

}


?>
</body>
</html>