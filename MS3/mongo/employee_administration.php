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
        //Handle insert
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

			if (isset($_POST['employee_nr']) && !empty($_POST['employee_nr'])) {

				$bulk = new MongoDB\Driver\BulkWrite;

				$doc = ['_id' => $_POST['employee_nr'], 'manager_id' => $_POST['manager_id'], 'first_name' => $_POST['first_name'], 'last_name' => $_POST['last_name'], 'email' => $_POST['email'], 'password' => $_POST['password']];
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


        <table style="float:none; border: 1px solid #DDDDDD">
            <thead>
            <tr id="tableRow">

                <th style="padding: 0px 10px 0px 10px;"><a href="movies.php?sortbytitle=true">Title</a></th>
                <th style="padding: 0px 10px 0px 10px;"><a href="movies.php?sortbydirector=true">Director</a></th>
                <th style="padding: 0px 10px 0px 10px;"><a href="movies.php?sortbycountry=true">Country</a></th>
                <th style="padding: 0px 10px 0px 10px;"><a href="movies.php?sortbylanguage=true">Language</a></th>
                <th style="padding: 0px 10px 0px 10px;"><a href="movies.php?sortbyage=true">Age rating</a></th>
                <th style="padding: 0px 10px 0px 10px;"><a href="movies.php?sortbydur=true">Duration (minutes)</a></th>

            </tr>
            </thead>
            <tbody>
            <?php



            try {

                $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");



                if (isset($_GET['searchTitle'])) {

                    $filter = [ 'title' => new MongoDB\BSON\Regex($_GET['searchTitle'], 'i') ];
                    $query = new MongoDB\Driver\Query($filter);

                } else if (isset($_GET['searchFilmID'])) {
                    $filter = [ '_id' => $_GET['searchFilmID'] ];
                    $query = new MongoDB\Driver\Query($filter);

                } else if (isset($_GET['sortbytitle'])) {
                    $query = new MongoDB\Driver\Query([], ['sort' => [ 'title' => 1]]);

                } else if (isset($_GET['sortbydirector'])) {
                    $query = new MongoDB\Driver\Query([], ['sort' => [ 'director' => 1]]);

                } else if (isset($_GET['sortbycountry'])) {
                    $query = new MongoDB\Driver\Query([], ['sort' => [ 'country' => 1]]);
                } else if (isset($_GET['sortbylanguage'])) {
                    $query = new MongoDB\Driver\Query([], ['sort' => [ 'film_language' => 1]]);
                } else if (isset($_GET['sortbydur'])) {
                    $query = new MongoDB\Driver\Query([], ['sort' => [ 'duration' => 1]]);
                } else if (isset($_GET['sortbyage'])) {
                    $query = new MongoDB\Driver\Query([], ['sort' => [ 'age_rating' => 1]]);
                } else if (isset($_GET['sortbyid'])) {
                    $query = new MongoDB\Driver\Query([], ['sort' => [ '_id' => 1]]);
                } else {
                    $query = new MongoDB\Driver\Query([]);
                }



                $rows = $mng->executeQuery("cinebase.films", $query);
                $idx=0;
                foreach ($rows as $row) {

                    $idx++;
                    echo "<tr>";

                    if (isset($_SESSION['loggedinEmployee']) && $_SESSION['loggedinEmployee'] == true) {
                        echo "<td style=\"padding: 5px 10px 5px 10px;\">$row->_id</td>";
                    }
                    echo "<td style=\"padding: 5px 10px 5px 10px;\">$row->title</td>";
                    echo "<td style=\"padding: 5px 10px 5px 10px;\">$row->director</td>";
                    echo "<td style=\"padding: 5px 10px 5px 10px;\">$row->country</td>";
                    echo "<td style=\"padding: 5px 10px 5px 10px;\">$row->film_language</td>";
                    echo "<td style=\"padding: 5px 10px 5px 10px;\">$row->age_rating</td>";
                    echo "<td style=\"padding: 5px 10px 5px 10px;\">$row->duration</td>";

                    if (isset($_SESSION['loggedinEmployee']) && $_SESSION['loggedinEmployee'] == true) {

                        //UPDATE BUTTON
                        //echo "<td><a href=\"updatefilm.php?film_id=$row->_id&title=$row->title&director=$row->director&country=$row->country&film_language=$row->film_language&age_rating=$row->age_rating&duration=$row->duration\"> UPDATE </a></td>";
                        echo "<td>";
                        echo "<form method='post' action='updatefilm.php' class='inline'>";
                        echo "<input type='hidden' name='film_id' value=$row->_id>";

                        $str_title = urlencode($row->title);
                        echo "<input type='hidden' name='title' value=$str_title>";

                        $str_director = urlencode($row->director);
                        echo "<input type='hidden' name='director' value=$str_director>";

                        echo "<input type='hidden' name='country' value=$row->country>";

                        $str_language = urlencode($row->film_language);
                        echo "<input type='hidden' name='film_language' value=$str_language>";

                        echo "<input type='hidden' name='age_rating' value=$row->age_rating>";
                        echo "<input type='hidden' name='duration' value=$row->duration>";
                        echo "<button type='submit' name='submit_param' value='submit_value' class='link-button'>";
                        echo "UPDATE";
                        echo "</button>";
                        echo "</form>";
                        echo "</td>";



                        //DELETE BUTTON
                        //echo "<td><a href=\"movies.php?del=$row->_id\"> DELETE </a></td>";
                        echo "<td>";
                        echo "<form action='movies.php' method='post'>";
                        echo "<input type='hidden' name='del' value=$row->_id>";
                        echo "<button>DELETE</button>" ;
                        echo "</form>";
                        echo "</td>";


                    }
                    echo "<td><a href=\"screening.php?searchFilmID=$row->_id\"> Show Screenings </a></td>";


                    echo "</tr>";

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

    </div>
</div>

<?php

echo("<script type=\"text/javascript\">hideFormInsertMovie();</script>");

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