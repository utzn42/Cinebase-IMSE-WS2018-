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
error_reporting(0);

$user = 'root';
$pass = '';
$database = 'cinebase';

// establish database connection
$conn = new mysqli('localhost', $user, $pass, $database) or die("dead");

?>

<div class="wrapper">
    <div class="topLine" id="topLine">
        cinebase
        <button onclick="window.location='index.php';" style="margin-left: 20px" class="buttonBig">Home
        </button>
        <button onclick="window.location='movies.php';" class="buttonBig">Movies
        </button>
        <button onclick="window.location='screening.php';" class="buttonBig">Screenings</button>
        <?php if (isset($_SESSION['loggedinAdmin']) && $_SESSION['loggedinAdmin'] == true) {
            echo "<button onclick=\"window.location='employee_administration.php';\" class=\"buttonBig\">Employees</button>";
        } ?>
        <?php if (isset($_SESSION['loggedinAdmin']) && $_SESSION['loggedinAdmin'] == true) {
            echo "<button onclick=\"window.location='hall_administration.php';\" class=\"buttonBig\">Halls</button>";
        } ?>
        <?php if (isset($_SESSION['loggedinEmployee']) && $_SESSION['loggedinEmployee'] == true) {
            echo "<button onclick=\"window.location='ticket.php';\" style=\"border-bottom: 2px solid whitesmoke; font-weight: bold\" class=\"buttonBig\">Tickets</button>";
        } ?>
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

        <div>
            <form id='searchform' action='ticket.php' method='get'>
                Search for tickets under user email:
                <input class='searchEmail' id='searchEmail' name='searchEmail' type='text' size='20'
                       value='<?php echo $_GET['searchEmail']; ?>'/>
                <input id='search' type='submit' value='Search!'/>
            </form>
            <br>
        </div>
        <?php
        $sql = "SELECT * FROM ticket ORDER BY ticket_id ASC";

        $result = $conn->query($sql);
        $max_row = mysqli_fetch_array($result);


        if (isset($_GET['searchEmail'])) {
            $sql = "SELECT * FROM ticket INNER JOIN customer ON ticket.customer_id = customer.customer_id WHERE email like '%" . $_GET['searchEmail'] . "%'";
        } else {
            $sql = "SELECT * FROM ticket";
        }
        $result = $conn->query($sql);

        ?>

        <br>
        <div id="insertMovie">
            <form id='insertform' action='ticket.php' method='get'>
                Add new ticket:
                <table style='border: 1px solid #DDDDDD'>
                    <thead>
                    <tr>
                        <th>Screening-ID</th>
                        <th>Customer-ID</th>
                        <th>Price</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <input class="screeningID" id='screeningID' name='screeningID' type='text' size="30"
                                   value='<?php echo $GET['screeningID'] ?>'/>
                        </td>
                        <td>
                            <input id='customerID' name='customerID' type='text' size="30"
                                   value='<?php echo $_GET['customerID']; ?>'/>
                        </td>
                        <td>
                            <input id='price' name='price' type='text' size="30"
                                   value='<?php echo $_GET['price']; ?>'/>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <input id='insert' type='submit' value='Insert!'/>
            </form>
        </div>

        <?php
        //Handle insert
        if (isset($_GET['screeningID']) && !empty($_GET['screeningID']) && isset($_GET['customerID']) && !empty($_GET['customerID'])) {

            //Prepare insert statementd
            $sql = "INSERT INTO ticket(screening_id, customer_id, price, discount_type) VALUES(" . $_GET['screeningID'] . ", " . $_GET['customerID'] . ", " . $_GET['price'] . ", 'manually created')";


            //Parse and execute statement
            if ($conn->query($sql) === TRUE) {
                echo "New record created sucessfully";
                #header("location: movies.php");

            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

        }


        echo("<script type=\"text/javascript\">hideFormInsertMovie();</script>");


        ?>

        <br>
        <br>


        <table style="float:none; border: 1px solid #DDDDDD">
            <thead>
            <tr>
                <th style="padding: 0px 10px 0px 10px;">Ticket-ID</th>
                <th style="padding: 0px 10px 0px 10px;">Screening-ID</th>
                <th style="padding: 0px 10px 0px 10px;">Customer-ID</th>
                <th style="padding: 0px 10px 0px 10px;">Price</th>
                <th style="padding: 0px 10px 0px 10px;">Discount Type</th>
            </tr>
            </thead>
            <tbody>
            <?php

            // fetch rows of the executed sql query
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    echo "<tr>";

                    echo "<td style=\"padding: 5px 10px 5px 10px;\">" . $row['ticket_id'] . "</td>";
                    echo "<td style=\"padding: 5px 10px 5px 10px;\">" . $row['screening_id'] . "</td>";
                    echo "<td style=\"padding: 5px 10px 5px 10px;\">" . $row['customer_id'] . "</td>";
                    echo "<td style=\"padding: 5px 10px 5px 10px;\">" . $row['price'] . "</td>";
                    echo "<td style=\"padding: 5px 10px 5px 10px;\">" . $row['discount_type'] . "</td>";

                    if (isset($_SESSION['loggedinEmployee']) && $_SESSION['loggedinEmployee'] == true) {
                        echo "<td><a href=\"updateticket.php?ticket_id=" . $row['ticket_id'] . "&screening_id=" . $row['screening_id'] . "&customer_id=" . $row['customer_id'] . "&price=" . $row['price'] . "&discount_type=" . $row['discount_type'] . "\"> UPDATE </a></td>";
                        echo "<td><a href=\"deleteticketemp.php?id=" . $row['ticket_id'] . "\"> DELETE </a></td>";
                    }

                    echo "</tr>";
                }
            }
            $row_cnt = mysqli_num_rows($result);


            ?>
            </tbody>
        </table>

        <div><?php echo $row_cnt ?> Ticket/s found!</div>


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
        $conn->close();
        ?>

    </div>
</div>


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