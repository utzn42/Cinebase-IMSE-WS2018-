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

//establish serverconnection
$servername = "localhost";
$user = "root";
$pw = "";
$db = "cinebase";
$con = new mysqli($servername, $user, $pw, $db);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $password = $_POST['password'];


    //sign up new user
    if (isset($_POST['passwordRepeat'])) {
        $username = $_POST['email'];
        $passwordRepeat = $_POST['passwordRepeat'];
        if (strcmp($password, $passwordRepeat) == 0) {
            $sqlInsertUser = "INSERT INTO customer (email, password) VALUES (\"$username\", \"$password\")";
            if ($con->query($sqlInsertUser) == true) {
                echo("<script type=\"text/javascript\">loginSuccess(\"$username\");</script>");
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;

                $sqlSearchUser = "SELECT * FROM customer WHERE password = \"$password\" AND email = \"$username\";";
                $result = $con->query($sqlSearchUser);

                if ($result->num_rows > 0) {
                    while ($i = $result->fetch_assoc()) {
                        if ($i['password'] == $_POST['password']) {
                            $_SESSION['customer_id'] = $i['customer_id'];
                            break;
                        }
                    }
                }
            } else {
                echo("<script type=\"text/javascript\">signUpFailedErrorMessage();</script>");
            }
        } else {
            echo("<script type=\"text/javascript\">signUpFailedErrorMessagePasswords();</script>");
        }

    } //employee login
    else if (isset($_POST['remember'])) {
        $username = $_POST['username'];

        if ($username != "admin" && $password != "cinebase") {
            $sqlSearchEmployee = "SELECT * FROM employee WHERE password = \"$password\" AND email = \"$username\";";
            $result = $con->query($sqlSearchEmployee);


            if ($result->num_rows > 0) {
                while ($i = $result->fetch_assoc()) {
                    if ($i['password'] == $_POST['password']) {
                        echo("<script type=\"text/javascript\">loginSuccess(\"$username\");</script>");
                        $_SESSION['loggedinEmployee'] = true;
                        $_SESSION['username'] = $username;
                        break;
                    }
                }
            } else {
                echo("<script type=\"text/javascript\">loginFailedErrorMessage();</script>");
            }
        }
    } //sign in existing user
    else {
        $username = $_POST['username'];

        //normal user
        if ($username != "admin" && $password != "cinebase") {
            $sqlSearchUser = "SELECT * FROM customer WHERE password = \"$password\" AND email = \"$username\";";
            $result = $con->query($sqlSearchUser);


            if ($result->num_rows > 0) {
                while ($i = $result->fetch_assoc()) {
                    if ($i['password'] == $_POST['password']) {
                        echo("<script type=\"text/javascript\">loginSuccess(\"$username\");</script>");
                        $_SESSION['loggedin'] = true;
                        $_SESSION['username'] = $username;
                        $_SESSION['customer_id'] = $i['customer_id'];
                        break;
                    }
                }
            } else {
                echo("<script type=\"text/javascript\">loginFailedErrorMessage();</script>");
            }
        } //ADMIN MODE
        else {
            $_SESSION['loggedinAdmin'] = true;
        }
    }
}


?>
<div class="wrapper">
    <div class="topLine" id="topLine">
        cinebase
        <button onclick="window.location='index.php';"
                style="border-bottom: 2px solid whitesmoke; font-weight: bold; margin-left: 20px"
                class="buttonBig">Home
        </button>
        <button onclick="window.location='movies.php';" class="buttonBig">Movies</button>
        <button onclick="window.location='screening.php';" class="buttonBig">Screenings</button>
         <?php if (isset($_SESSION['loggedinAdmin']) && $_SESSION['loggedinAdmin'] == true) {
            echo "<button onclick=\"window.location='employee_administration.php';\" class=\"buttonBig\">Employees</button>";
        } ?>
        <?php if (isset($_SESSION['loggedinAdmin']) && $_SESSION['loggedinAdmin'] == true) {
            echo "<button onclick=\"window.location='hall_administration.php';\" class=\"buttonBig\">Halls</button>";
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
        Welcome to cinebase.com! Pick a movie and enjoy!
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


<?php

//close serverconnection
$con->close();
?>
</body>
</html>