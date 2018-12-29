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
  <button id="register" onclick="window.location='register.php';"
          class="buttonRegister">Register
  </button>
</div>

<?php
session_start();
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
      <input  class="signInInputs" type="text" placeholder="Enter Username" name="username" required>

      <label for="password"><b>Password</b></label>
      <input  class="signInInputs" type="password" placeholder="Enter Password" name="password" required>

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

<p style="margin: auto; width: 900px">Yasin Ergüven Utz Nisslmüller Alexander Ramharter Oliver
  Schweiger</p>

</body>
</html>