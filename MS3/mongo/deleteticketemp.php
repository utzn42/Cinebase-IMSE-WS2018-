<?php

try {

    $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");

    if (isset($_GET["tid"])) {

        $bulk = new MongoDB\Driver\BulkWrite;

        $ticket_id = $_GET["tid"];
        $customer_id = $_GET["cid"];

        $filter = ['_id' => intval($customer_id)];
        $query = new MongoDB\Driver\Query($filter);
        $rows = $mng->executeQuery("cinebase.customers", $query);

        $ticketIndex = 0;


        foreach ($rows as $row) {

            $ticketsArray = $row->tickets;

            $count = 0;
            foreach ($row->tickets as $key => $value) {

                if ($ticketsArray[$count]->_id == $ticket_id){
                    $ticketIndex = $count;
                    break;
                }

                $count++;
            }

            \array_splice($ticketsArray, $ticketIndex, 1);

            $bulk->update(['_id' => intval($customer_id)], ['$set' => ["tickets" => $ticketsArray]]);

        }

        $mng->executeBulkWrite('cinebase.customers', $bulk);
        header("location: ticket.php");
    }

} catch (MongoDB\Driver\Exception\Exception $e) {

    $filename = basename(__FILE__);

    echo "The $filename script has experienced an error.\n";
    echo "It failed with the following exception:\n";

    echo "Exception:", $e->getMessage(), "\n";
    echo "In file:", $e->getFile(), "\n";
    echo "On line:", $e->getLine(), "\n";
}
?>