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
            } else {
                echo("<script type=\"text/javascript\">signUpFailedErrorMessage();</script>");
            }
        } else {
            echo("<script type=\"text/javascript\">signUpFailedErrorMessagePasswords();</script>");
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
                        break;
                    }
                }
            } else {
                echo("<script type=\"text/javascript\">loginFailedErrorMessage();</script>");
            }
        }
        //ADMIN MODE
        else {
            $_SESSION['loggedinAdmin'] = true;
        }
    }
}


?>

<div class="topLine" id="topLine">
  cinebase
  <button onclick="window.location='index.php';"
          style="border-bottom: 2px solid whitesmoke; font-weight: bold; margin-left: 20px"
          class="buttonBig">Home
  </button>
  <button onclick="window.location='movies.php';" class="buttonBig">Movies</button>
  <button onclick="window.location='news.php';" class="buttonBig">News</button>
  <button onclick="window.location='aboutUs.php';" class="buttonBig">About Us</button>
  <button id="signIn" onclick="document.getElementById('popUpLogin').style.display='block'"
          class="buttonLogin">
    Sign In
  </button>
  <button id="register" onclick="window.location='register.php';"
          class="buttonRegister">Register
  </button>
</div>

<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        $username = $_SESSION['username'];
        echo("<script type=\"text/javascript\">setLoggedIn(\"$username\");</script>");
}
if (isset($_SESSION['loggedinAdmin']) && $_SESSION['loggedinAdmin'] == true) {
    echo("<script type=\"text/javascript\">setAdminMode();</script>");
}
?>

<!-- Start of the part taken from: https://www.w3schools.com/howto/howto_css_login_form.asp -->
<div id="popUpLogin" class="modal">
  <span onclick="document.getElementById('popUpLogin').style.display='none'"
        class="close" title="Close Modal">&times;</span>

  <form class="modal-content animate" action="index.php" method="post">

    <div class="container">
      <label for="username"><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="username" required>

      <label for="password"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="password" required>

      <button class="buttonLoginModal" type="submit">Login</button>
      <label>
        <input type="checkbox" checked="checked" name="remember"> Remember me
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

<p style="margin: auto; width: 900px">Yasin Ergüven Utz Nisslmüller Alexander Ramharter Oliver
  Schweiger</p>


<?php

//close serverconnection
$con->close();
?>
</body>
</html>