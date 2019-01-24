<?php


$user = 'root';
$pass = '';
$database = 'cinebase';

$conn = new mysqli('localhost', $user, $pass, $database) or die("dead");


?>
<html>
<head>
</head>
<body>

<a href="employee_administration.php">Back to Employees</a><br><br>
<div>
    <form id='updateform' action="" method="get">
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
                           value='<?php echo $_GET['employee_nr']; ?>'/>
                </td>
                <td>
                    <input id='manager_id' name='manager_id' type='text' size='20'
                           value='<?php echo $_GET['manager_id']; ?>'/>
                </td>
                <td>
                    <input id='first_name' name='first_name' type='text' size='20'
                           value='<?php echo $_GET['first_name']; ?>'/>
                </td>
                <td>
                    <input id='last_name' name='last_name' type='text' size='20'
                           value='<?php echo $_GET['last_name']; ?>'/>
                </td>
                <td>
                    <input id='email' name='email' type='text' size='20' value='<?php echo $_GET['email']; ?>'/>
                </td>
                <td>
                    <input id='password' name='password' type='text' size='20'
                           value='<?php echo $_GET['password']; ?>'/>
                </td>
            </tr>
            </tbody>
        </table>
        <input id='submit' type='submit' name="submit" value='Update!'/>
    </form>
</div>

<?php


if (isset($_GET["submit"])) {


    $employee_nr = $_GET['employee_nr'];
    $manager_id = $_GET['manager_id'];
    $first_name = $_GET['first_name'];
    $last_name = $_GET['last_name'];
    $email = $_GET['email'];
    $password = $_GET['password'];


    // sql to update a record
    $sql = "UPDATE employee 
		SET manager_id = \"$manager_id\",
		first_name=\"$first_name\",
		last_name=\"$last_name\",
		email=\"$email\",
		password=\"$password\"
		WHERE employee_nr=$employee_nr";


    //Parse and execute statement
    if ($conn->query($sql) === TRUE) {
        echo "Record updated succesfully";
        header("location: employee_administration.php");

    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


?>
</body>
</html>