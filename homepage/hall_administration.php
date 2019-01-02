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
    <button onclick="window.location='news.php';" class="buttonBig">News</button>
    <button onclick="window.location='aboutUs.php';" class="buttonBig">About Us</button>
    <button onclick="window.location='employee_administration.php';" class="buttonBig">Employees
    </button>
    <button onclick="window.location='hall_administration.php';"
            style="border-bottom: 2px solid whitesmoke; font-weight: bold" class="buttonBig">Halls
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
      <form id='searchform' action='hall_administration.php' method='get'>
        <a href='hall_administration.php'>All Halls</a> ---
        Search for Hall:
        <input class='searchName' id='searchName' name='searchName' type='text' size='20'
               value='<?php echo $_GET['searchName']; ?>'/>
        <input id='search' type='submit' value='Search!'/>
      </form>
      <br>
    </div>
      <?php
      // check if search view of list view
      if (isset($_GET['searchName'])) {
          $sql = "SELECT * FROM hall WHERE name like '%" . $_GET['searchName'] . "%'";
      } else {
          $sql = "SELECT * FROM hall";
      }
      $result = $conn->query($sql);

      ?>


    <table style='border: 1px solid #DDDDDD'>
      <thead>
      <tr>
        <th>Hall-ID</th>
        <th>Name</th>
        <th>Equipment</th>
      </tr>
      </thead>
      <tbody>
      <?php

      // fetch rows of the executed sql query
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {

              echo "<tr>";


              echo "<td>" . $row['hall_id'] . "</td>";
              echo "<td>" . $row['name'] . "</td>";
              echo "<td>" . $row['equipment'] . "</td>";
              if (isset($_SESSION['loggedinEmployee']) && $_SESSION['loggedinEmployee'] == true) {
                  echo "<td><a href=\"updatehall.php?hall_id=" . $row['hall_id'] . "&name=" . $row['name'] . "&equipment=" . $row['equipment'] . "\"> UPDATE </a></td>";
                  echo "<td><a href=\"deletehall.php?id=" . $row['hall_id'] . "\"> DELETE </a></td>";
              }
              echo "</tr>";
          }
      }
      $row_cnt = mysqli_num_rows($result);


      ?>
      </tbody>
    </table>

    <div><?php echo $row_cnt ?> Hall/s found!</div>


    <br>

    <div id="insertHall">
      <form id='insertform' action='hall_administration.php' method='get'>
        Add new Hall:
        <table style='border: 1px solid #DDDDDD'>
          <thead>
          <tr>
            <th>Hall-ID</th>
            <th>Name</th>
            <th>Equipment</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td>
              <input class="inputHall_ID" id='inputHall_ID' name='inputHall_ID' type='text'
                     size='10'
                     value='<?php echo $_GET['hall_id']; ?>'/>
            </td>
            <td>
              <input id='nameHall' name='nameHall' type='text' size='20'
                     value='<?php echo $_GET['name']; ?>'/>
            </td>
            <td>
              <input id='equipmentHall' name='equipmentHall' type='text' size='20'
                     value='<?php echo $_GET['equipment']; ?>'/>
            </td>
          </tr>
          </tbody>
        </table>
        <input id='insert' type='submit' value='Insert!'/>
      </form>
    </div>

      <?php
      //Handle insert
      if (isset($_GET['inputHall_ID']) && !empty($_GET['inputHall_ID'])) {

          //Prepare insert statementd
          $sql = "INSERT INTO hall VALUES(" . $_GET['inputHall_ID'] . ",'" . $_GET['nameHall'] . "','" . $_GET['equipmentHall'] . "')";


          //Parse and execute statement
          if ($conn->query($sql) === TRUE) {
              echo "New record created succesfully";
              header("location: hall_administration.php");

          } else {
              echo "Error: " . $sql . "<br>" . $conn->error;
          }

      }


      ?>


      <?php $conn->close(); ?>

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

<p style="margin: auto; width: 900px">Yasin Ergüven Utz Nisslmüller Alexander Ramharter Oliver
  Schweiger</p>


</body>
</html>