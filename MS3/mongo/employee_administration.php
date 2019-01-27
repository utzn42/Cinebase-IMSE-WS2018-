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
error_reporting(E_ALL ^ E_NOTICE);
?>

<div class="wrapper">
    <div class="topLine" id="topLine">
        cinebase
        <button onclick="window.location='index.php';" style="margin-left: 20px" class="buttonBig">Home
        </button>
        <button onclick="window.location='movies.php';" class="buttonBig">Movies
        </button>
        <button onclick="window.location='screening.php';" class="buttonBig">Screenings</button>
        <button onclick="window.location='employee_administration.php';"
                style="border-bottom: 2px solid whitesmoke; font-weight: bold" class="buttonBig">
            Employees
        </button>
        <button onclick="window.location='hall_administration.php';"
                class="buttonBig">Halls
        </button>
        <button id="signIn" onclick="document.getElementById('popUpLogin').style.display='block'"
                class="buttonLogin">
            Sign In
        </button>
        <button id="register" onclick="window.location='register.php';"
                class="buttonRegister">Register
        </button>
    </div>
</div>

<div class="wrapperMainBody">
    <div class="mainBody" id="mainBody">
        <br><br>
        <div>
            <form id='searchform' action='employee_administration.php' method='get'>
                <a href='employee_administration.php'>All Employees</a> ---
                Search for Employee:
                <input class='searchName' id='searchName' name='searchName' type='text' size='20'
                       value='<?php echo $_GET['searchName']; ?>'/>
                <input id='search' type='submit' value='Search!'/>
            </form>
            <br>
        </div>


        <?php




        try {

            $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
            $query = new MongoDB\Driver\Query([], ['sort' => [ '_id' => 1]]);

            $rows = $mng->executeQuery("cinebase.employees", $query);
            $idx=0;
            foreach ($rows as $row) {

                if($row->_id>$idx){
                    $idx=$row->_id;
                }


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

        <br>

        <div id="insertEmployee">
            <form id='insertform' action='employee_administration.php' method='get'>
                Add new Employee:
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
                            <input class="inputEmployeeNr" id='employee_nr' name='employee_nr' type='text'
                                   size='10'
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
                            <input class="last_name" id='last_name' name='last_name' type='text' size='20'
                                   value='<?php echo $_GET['last_name']; ?>'/>
                        </td>
                        <td>
                            <input class="email" id='email' name='email' type='text' size='20'
                                   value='<?php echo $_GET['email']; ?>'/>
                        </td>
                        <td>
                            <input class="password" id='password' name='password' type='text' size='20'
                                   value='<?php echo $_GET['password']; ?>'/>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <input id='insert' type='submit' value='Insert!'/>
            </form>
        </div>

        <?php
        //Handle delete
        try {

            $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");

            if (isset($_POST["del"])) {

                $bulk = new MongoDB\Driver\BulkWrite;

                $del_id = $_POST["del"];

                //$bulk->update(['name' => 'Audi'], ['$set' => ['price' => 52000]]);
                $bulk->delete(['_id' => $del_id]);

                $mng->executeBulkWrite('cinebase.employees', $bulk);
                //header("location: movies.php");
                //header("Refresh:0");


            }

        } catch (MongoDB\Driver\Exception\Exception $e) {

            $filename = basename(__FILE__);

            echo "The $filename script has experienced an error.\n";
            echo "It failed with the following exception:\n";

            echo "Exception:", $e->getMessage(), "\n";
            echo "In file:", $e->getFile(), "\n";
            echo "On line:", $e->getLine(), "\n";
        }


        //echo("<script type=\"text/javascript\">hideFormInsertMovie();</script>");


        ?>
        <?php
        //Handle insert
		try {

			$mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");

			if (isset($_GET['employee_nr']) && !empty($_GET['employee_nr'])) {

				$bulk = new MongoDB\Driver\BulkWrite;

				$doc = ['_id' => $_GET['employee_nr'], 'manager_id' => $_GET['manager_id'], 'first_name' => $_GET['first_name'], 'last_name' => $_GET['last_name'], 'email' => $_GET['email'], 'password' => $_GET['password']];
				$bulk->insert($doc);
				//$bulk->update(['name' => 'Audi'], ['$set' => ['price' => 52000]]);
				//$bulk->delete(['name' => 'Hummer']);

				$mng->executeBulkWrite('cinebase.employees', $bulk);

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
        <br>

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

            <?php

            if (isset($_GET['searchName'])) {
                $result = 'first_name' . 'last_name';
                $filter = [
                    '$or' =>[
                        ['first_name' => new MongoDB\BSON\Regex( $_GET['searchName'], 'i' )],
                        ['last_name' => new MongoDB\BSON\Regex( $_GET['searchName'], 'i' )],
                        ]
                ];
                $query = new MongoDB\Driver\Query($filter);
            }

            $rows = $mng->executeQuery("cinebase.employees", $query);
                $idx=0;
                foreach ($rows as $row) {

                    $idx++;
                    echo "<tr>";
                    echo "<td style=\"padding: 5px 100px 5px 10px;\">$row->_id</td>";
                    echo "<td style=\"padding: 5px 100px 5px 10px;\">$row->manager_id</td>";
                    echo "<td style=\"padding: 5px 100px 5px 10px;\">$row->first_name</td>";
                    echo "<td style=\"padding: 5px 100px 5px 10px;\">$row->last_name</td>";
                    echo "<td style=\"padding: 5px 100px 5px 10px;\">$row->email</td>";
                    echo "<td style=\"padding: 5px 100px 5px 10px;\">$row->password</td>";

                    echo "<td>";
                    echo "<form method='post' action='updateemployee.php' class='inline'>";
                    echo "<input type='hidden' name='employee_nr' value=$row->_id>";

                    $str_manager_id = urlencode($row->manager_id);
                    echo "<input type='hidden' name='manager_id' value=$str_manager_id>";

                    $str_first_name = urlencode($row->first_name);
                    echo "<input type='hidden' name='first_name' value=$str_first_name>";

                    echo "<input type='hidden' name='last_name' value=$row->last_name>";

                    $str_email = urlencode($row->email);
                    echo "<input type='hidden' name='email' value=$str_email>";

                    echo "<input type='hidden' name='password' value=$row->password>";
                    echo "<button type='submit' name='submit_param' value='submit_value' class='link-button'>";
                    echo "UPDATE";
                    echo "</button>";
                    echo "</form>";
                    echo "</td>";

                    echo "<td>";
                    echo "<form action='employee_administration.php' method='post'>";
                    echo "<input type='hidden' name='del' value=$row->_id>";
                    echo "<button>DELETE</button>" ;
                    echo "</form>";
                    echo "</td>";

                    "</tr>";

                }

            ?>
            </tbody>
        </table>

    </div>
</div>

<?php



if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $username = $_SESSION['username'];
    echo("<script type=\"text/javascript\">setLoggedIn(\"$username\");</script>");
}
if (isset($_SESSION['loggedinAdmin']) && $_SESSION['loggedinAdmin'] == true) {
    echo("<script type=\"text/javascript\">setAdminMode();</script>");
}
if (isset($_SESSION['loggedinEmployee']) && $_SESSION['loggedinEmployee'] == true) {
    $username = $_SESSION['username'];
    echo("<script type=\"text/javascript\">setEmployeeMode(\"$username\");</script>");
}
?>

<!-- Start of the part taken from: https://www.w3schools.com/howto/howto_css_login_form.asp -->
<div id="popUpLogin" class="modal">
    <span onclick="document.getElementById('popUpLogin').style.display='none'"
          class="close" title="Close Modal">&times;</span>

    <form class="modal-content animate" action="index.php" method="post">

        <div class="container">
            <label for="username"><b>Username</b></label>
            <input class="signInInputs" type="text" placeholder="Enter Username" name="username" required>

            <label for="password"><b>Password</b></label>
            <input class="signInInputs" type="password" placeholder="Enter Password" name="password"
                   required>

            <button class="buttonLoginModal" type="submit">Login</button>
            <label>
                <input type="checkbox" name="remember"> Employee
            </label>
        </div>

        <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="document.getElementById('popUpLogin').style.display='none'"
                    class="cancelbtn">Cancel
            </button>
            <span class="psw">Forgot <a href="#">password?</a></span>
        </div>
    </form>
</div>
<!-- End of the part taken from: https://www.w3schools.com/howto/howto_css_login_form.asp -->


<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<p style="text-align:center">Yasin Ergüven Utz Nisslmüller Alexander Ramharter Oliver
    Schweiger</p>


</body>
</html>