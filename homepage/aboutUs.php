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
    $sqlSearchUser = "SELECT * FROM mitarbeiter";
    $result = $con->query($sqlSearchUser);
    $username = $_POST['username'];

    if ($result->num_rows > 0) {
        while ($i = $result->fetch_assoc()) {
            if ($i['email'] == $_POST['password']) {
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


?>

<div class="topLine" id="topLine">
  cinebase
  <button onclick="window.location='index.php';" style="margin-left: 20px" class="buttonBig">Home
  </button>
  <button onclick="window.location='movies.php';" class="buttonBig">Movies</button>
  <button onclick="window.location='news.php';" class="buttonBig">News</button>
  <button onclick="window.location='aboutUs.php';"
          style="border-bottom: 2px solid whitesmoke; font-weight: bold" class="buttonBig">About Us
  </button>
  <button id="signIn" onclick="document.getElementById('popUpLogin').style.display='block'" class="buttonLogin">
    Sign In
  </button>
  <button id="register" onclick="document.getElementById('popUpRegister').style.display='block'"
          class="buttonRegister">Register
  </button>
</div>

<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $username = $_SESSION['username'];
    echo("<script type=\"text/javascript\">setLoggedIn(\"username\");</script>");
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

<!-- Start of the part taken from: https://www.w3schools.com/howto/howto_css_signup_form.asp -->
<div id="popUpRegister" class="modal">
  <span onclick="document.getElementById('popUpRegister').style.display='none'" class="close"
        title="Close Modal">&times;</span>
  <form class="modal-content animate" action="index.php" method="post">
    <div class="container">
      <h1>Sign Up</h1>
      <p>Please fill in this form to create an account.</p>
      <hr>
      <label for="email"><b>Email</b></label>
      <input type="text" placeholder="Enter Email" name="email" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="psw" required>

      <label for="psw-repeat"><b>Repeat Password</b></label>
      <input type="password" placeholder="Repeat Password" name="psw-repeat" required>

      <label>
        <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px">
        Remember me
      </label>

      <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms &
          Privacy</a>.</p>

      <div class="clearfix">
        <button type="button"
                onclick="document.getElementById('popUpRegister').style.display='none'"
                class="cancelbtn">Cancel
        </button>
        <button type="submit" class="buttonLoginModal">Sign Up</button>
      </div>
    </div>
  </form>
</div>
<!-- End of the part taken from: https://www.w3schools.com/howto/howto_css_signup_form.asp -->


<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<p style="margin: auto; width: 900px">Yasin Ergüven Utz Nisslmüller Alexander Ramharter Oliver
  Schweiger</p>


<?php

//close serverconnection
$con->close();
?>
</body>
</html>