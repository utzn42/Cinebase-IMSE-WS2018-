
<html>
<head>
</head>
<body>

<?php
$employee_nr= $_POST['employee_nr'];
$manager_id = urldecode($_POST['manager_id']);
$first_name = urldecode($_POST['first_name']);
$last_name = $_POST['last_name'];
$email = urldecode($_POST['email']);
$password = $_POST['password'];
?>

<a href="employee_administration.php">Back to Employees</a><br><br>
<div>
    <form id='updateform' action="" method="post">
        Update employee:
        <table style='border: 1px solid #DDDDDD'>
            <thead>
            <tr>
                <th>Employee Nr.</th>
                <th>Manager-ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>E-Mail</th>
                <th>Password</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <input id='employee_nr' name='employee_nr' type='text' size='20' readonly
                           value='<?php echo $employee_nr; ?>'/>
                </td>
                <td>
                    <input id='manager_id' name='manager_id' type='text' size='20'
                           value='<?php echo $manager_id; ?>'/>
                </td>
                <td>
                    <input id='first_name' name='first_name' type='text' size='20'
                           value='<?php echo $first_name; ?>'/>
                </td>
                <td>
                    <input id='last_name' name='last_name' type='text' size='20'
                           value='<?php echo $last_name; ?>'/>
                </td>
                <td>
                    <input id='new_email' name='new_email' type='text' size='20'
                           value='<?php echo $email; ?>'/>
                </td>
                <td>
                    <input id='password' name='password' type='text' size='20'
                           value='<?php echo $password; ?>'/>
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


        echo ($_POST['employee_nr']);

        $bulk = new MongoDB\Driver\BulkWrite;

        $bulk->update(['_id' => intval(($_POST['employee_nr']))], ['$set' => ['manager_id' => $_POST['manager_id']]]);
        $bulk->update(['_id' => intval(($_POST['employee_nr']))], ['$set' => ['first_name' => $_POST['first_name']]]);
        $bulk->update(['_id' => intval(($_POST['employee_nr']))], ['$set' => ['last_name' => $_POST['last_name']]]);
        $bulk->update(['_id' => intval(($_POST['employee_nr']))], ['$set' => ['email' => $_POST['new_email']]]);
        $bulk->update(['_id' => intval(($_POST['employee_nr']))], ['$set' => ['password' => ($_POST['password'])]]);


        $mng->executeBulkWrite('cinebase.employees', $bulk);
        header("location: employee_administration.php");

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