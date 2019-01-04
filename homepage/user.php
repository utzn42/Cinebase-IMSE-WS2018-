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
    <table style='border: 1px solid #DDDDDD'>
      <thead>
      <tr>
        <th>Ticket-ID</th>
        <th>Film</th>
        <th>Hall</th>
        <th>Date</th>
        <th>Discount Type</th>
      </tr>
      </thead>
      <tbody>

      <?php

      $customer_id = $_SESSION['customer_id'];

      $sql = "SELECT ticket.ticket_id, ticket.customer_id, screening.starting_time, film.title, hall.name, ticket.discount_type
FROM ticket
	LEFT JOIN screening ON ticket.screening_id = screening.screening_id
	LEFT JOIN film ON screening.film_id = film.film_id  
	LEFT JOIN hall ON screening.hall_id = hall.hall_id WHERE customer_id = \"$customer_id\"";
      $result = $conn->query($sql);

      // fetch rows of the executed sql query
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {

              $date = $row['starting_time'];
              $simpleDate = new DateTime($date);


              echo "<tr>";


              echo "<td style=\"padding: 5px 10px 5px 10px;\">" . $row['ticket_id'] . "</td>";
              echo "<td style=\"padding: 5px 10px 5px 10px;\">" . $row['title'] . "</td>";
              echo "<td style=\"padding: 5px 20px 5px 20px;\">" . $row['name'] . "</td>";
              echo "<td style=\"padding: 5px 30px 5px 30px;\">" . $simpleDate->format('d/m/Y h:m') . "</td>";
              echo "<td style=\"padding: 5px 10px 5px 10px;\">" . $row['discount_type'] . "</td>";
              echo "<td><a href=\"deleteTicket.php?id=" . $row['ticket_id'] . "\"> DELETE </a></td>";
              echo "</tr>";
          }
      }
      $row_cnt = mysqli_num_rows($result);


      ?>
      </tbody>
    </table>

    <div><?php echo $row_cnt ?> Ticket/s found!</div>


    <br><br><br><br>


    <button class="deleteMyAccount" onclick="deleteAccount(<?php echo $_SESSION['customer_id']; ?>)">Delete my Account</button>


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

<p style="text-align:center">Yasin Ergüven Utz Nisslmüller Alexander Ramharter Oliver
  Schweiger</p>


</body>
</html>