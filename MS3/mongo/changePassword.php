<?php

session_start();

$password = $_GET['pw'];
$_SESSION['password'] = $password;
$customerID = $_SESSION['customer_id'];

try {

    $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
    $bulk = new MongoDB\Driver\BulkWrite;

    $bulk->update(['_id' => intval($customerID)], ['$set' => ['password' => $password]]);
    $mng->executeBulkWrite('cinebase.customers', $bulk);

    header("location: user.php");

} catch (MongoDB\Driver\Exception\Exception $e) {

    $filename = basename(__FILE__);

    echo "The $filename script has experienced an error.\n";
    echo "It failed with the following exception:\n";

    echo "Exception:", $e->getMessage(), "\n";
    echo "In file:", $e->getFile(), "\n";
    echo "On line:", $e->getLine(), "\n";

}
?>