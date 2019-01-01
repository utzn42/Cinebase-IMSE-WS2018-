<?php
error_reporting(0);
session_start();
$user = 'root';
$pass = '';
$database = 'cinebase';

// establish database connection
$conn = new mysqli('localhost', $user, $pass, $database) or die("dead");

?>

<!DOCTYPE html>
<html lang="en">
<head>
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
  <button onclick="window.location='aboutUs.php';" class="buttonBig">About Us</button>
    <button onclick="window.location='employee_administration.php';"
            style="border-bottom: 2px solid whitesmoke; font-weight: bold" class="buttonBig">Employees</button>
    <button id="signIn" onclick="document.getElementById('popUpLogin').style.display='block'"
          class="buttonLogin">
    Sign In
  </button>
  <button id="register" onclick="window.location='register.php';"
          class="buttonRegister">Register
  </button>
</div>
<div class="mainBody" id="mainBody">
  <div>
    <form id='searchform' action='employees_of_manager.php' method='get'>
        <a href="employee_administration.php">Back to All-Employees-View</a><br><br>
      Employees of Manager:
      <input id='searchEmployee' name='searchEmployee' type='text' size='20'
             value='<?php echo $_GET['searchEmployee']; ?>'/>
      <input id='search' type='submit' value='Search!'/>
    </form>
    <br>
  </div>
    <?php
    // check if search view of list view
    if (isset($_GET['searchEmployee'])) {
        $sql = "SELECT * FROM employee WHERE manager_id like '%" . $_GET['searchEmployee'] . "%'";
    }
     else {
        $sql = "SELECT * FROM employee ";
    }
    $result = $conn->query($sql);

    ?>


  <table style='border: 1px solid #DDDDDD'>
    <thead>
    <tr>
      <th>Employee-Nr</th>
      <th>First Name</th>
      <th>Last Name</th>
        <th>E-Mail</th>
    </tr>
    </thead>
    <tbody>
    <?php

    // fetch rows of the executed sql query
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            echo "<tr>";
            echo "<td>" . $row['employee_nr'] . "</td>";
            echo "<td>" . $row['first_name'] . "</td>";
            echo "<td>" . $row['last_name'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            if (isset($_SESSION['loggedinEmployee']) && $_SESSION['loggedinEmployee'] == true) {
                echo "<td><a href=\"updateemployee.php?employee_nr=" . $row['employee_nr'] . "&manager_id=" . $row['manager_id'] . "&first_name=" . $row['first_name'] . "&last_name=" . $row['last_name'] . "&email=" . $row['email'] . "&password=" . $row['password'] . "\"> UPDATE </a></td>";
                echo "<td><a href=\"deleteemployee.php?id=" . $row['employee_nr'] . "\"> DELETE </a></td>";
            }

            echo "</tr>";
        }
    }
    $row_cnt = mysqli_num_rows($result);


    ?>
    </tbody>
  </table>

  <div><?php echo $row_cnt ?> Employee/s found!</div>


  <br>

<?php


echo("<script type=\"text/javascript\">hideFormInsertScreening();</script>");

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


<?php $conn->close(); ?>
</body>
</html>