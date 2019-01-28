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
$mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");

if (isset($_POST['password'])) {
    $password = $_POST['password'];


    //sign up new user
    if (isset($_POST['passwordRepeat'])) {

      //find max id value
        $query = new MongoDB\Driver\Query([]);
        $rows = $mng->executeQuery("cinebase.customers", $query);
        $highest = 0;

        foreach ($rows as $row) {
            if ($highest < $row->_id) {
                $highest = $row->_id;
            }
        }

        $username = $_POST['email'];
        $passwordRepeat = $_POST['passwordRepeat'];
        if (strcmp($password, $passwordRepeat) == 0) {
            $bulk = new MongoDB\Driver\BulkWrite;
            $doc = ['_id' => intval($highest+1), 'email' => $username, 'password' => $password];
            $bulk->insert($doc);
            $mng->executeBulkWrite('cinebase.customers', $bulk);
            echo("<script type=\"text/javascript\">registerSuccess(\"$username\");</script>");
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;

            $filter = ['email' => $_POST['email']];
            $query = new MongoDB\Driver\Query($filter);

            $rows = $mng->executeQuery("cinebase.customers", $query);


            foreach ($rows as $row) {
                if (strcmp($row->password, $password) == 0) {
                    $_SESSION['customer_id'] = $row->_id;
                    break;
                }
            }
        } else {
            echo("<script type=\"text/javascript\">signUpFailedErrorMessagePasswords();</script>");
        }

    } //employee login
    else if (isset($_POST['remember'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if ($username != "admin" && $password != "cinebase") {
            $filter = ['email' => $_POST['username']];
            $query = new MongoDB\Driver\Query($filter);
            $rows = $mng->executeQuery("cinebase.employees", $query);

            $count=0;
            foreach ($rows as $row) {
              $count++;
                if (strcmp($row->password, $password) == 0) {
                    echo("<script type=\"text/javascript\">loginSuccess(\"$username\");</script>");
                    $_SESSION['loggedinEmployee'] = true;
                    $_SESSION['username'] = $username;
                    break;
                }
            }
            if($count == 0){
                echo("<script type=\"text/javascript\">loginFailedErrorMessage();</script>");
            }

        } else{
            echo("<script type=\"text/javascript\">loginFailedErrorMessage();</script>");
        }
    } //sign in existing user
    else {
        $username = $_POST['username'];
        $password = $_POST['password'];

        //normal user
        if ($username != "admin" && $password != "cinebase") {
            $filter = ['email' => $_POST['username']];
            $query = new MongoDB\Driver\Query($filter);
            $rows = $mng->executeQuery("cinebase.customers", $query);

            $count=0;

            foreach ($rows as $row) {
                $count++;
                if (strcmp($row->password, $password) == 0) {
                    echo("<script type=\"text/javascript\">loginSuccess(\"$username\");</script>");
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $username;
                    $_SESSION['customer_id'] = $row->_id;
                    $_SESSION['password'] = $password;
                    break;
                }
            }
            if($count == 0){
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
      <?php if (isset($_SESSION['loggedinEmployee']) && $_SESSION['loggedinEmployee'] == true) {
          echo "<button onclick=\"window.location='ticket.php';\" class=\"buttonBig\">Tickets</button>";
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
    <br>
    <img src="img/filmReel.png" height="135" width="135">
    <br><br>
    Welcome to cinebase! Pick a movie and enjoy!
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

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<p style="text-align:center">Yasin Ergüven Utz Nisslmüller Alexander Ramharter Oliver
  Schweiger</p>


<?php

//close serverconnection
?>
</body>
</html>