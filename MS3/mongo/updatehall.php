
<html>
<head>
</head>
<body>

<?php
$hall_id= $_POST['hall_id'];
$name = ($_POST['name']);
$equipment = ($_POST['equipment']);
?>

<a href="hall_administration.php">Back to Halls</a><br><br>
<div>
    <form id='updateform' action="" method="post">
        Update Hall:
        <table style='border: 1px solid #DDDDDD'>
            <thead>
            <tr>
                <th>Hall-ID</th>
                <th>Name</th>
                <th>Equipment</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <input id='hall_id' name='hall_id' type='text' size='20' readonly
                           value='<?php echo $hall_id; ?>'/>
                </td>
                <td>
                    <input id='name' name='name' type='text' size='20'
                           value='<?php echo $name; ?>'/>
                </td>
                <td>
                    <input id='equipment' name='equipment' type='text' size='20'
                           value='<?php echo $equipment; ?>'/>
                </td>
            </tr>
            </tbody>
        </table>
        <input id='submit' type='submit' name="submit" value='Update!'/>
    </form>
</div>

<?php


if (isset($_POST["submit"])) {
    //echo $_POST['new_director'];


    //Handle insert
    try {

        $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");


        echo intval(($_POST['hall_id']));

        $bulk = new MongoDB\Driver\BulkWrite;

        $bulk->update(['_id' => intval(($_POST['hall_id']))], ['$set' => ['name' => $_POST['name']]]);
        $bulk->update(['_id' => intval(($_POST['hall_id']))], ['$set' => ['equipment' => $_POST['equipment']]]);


        $mng->executeBulkWrite('cinebase.halls', $bulk);
        header("location: hall_administration.php");

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