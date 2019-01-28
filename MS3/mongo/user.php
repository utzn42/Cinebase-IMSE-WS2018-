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

      $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");

      $filter = ['_id' => intval($customer_id)];
      $query = new MongoDB\Driver\Query($filter);
      $rows = $mng->executeQuery("cinebase.customers", $query);

      $ticketIndex = 0;

      foreach ($rows as $row) {

          $ticketsArray = $row->tickets;

          $count = 0;
          foreach ($row->tickets as $key => $value) {
              $ticket_id = $row->tickets[$count]->_id;
              $screening_id = $row->tickets[$count]->screening_id;
              $discount_type = $row->tickets[$count]->discount_type;
              $date = $row->tickets[$count]->starting_time;
              $simpleDate = new DateTime($date);


              $query = new MongoDB\Driver\Query([]);
              $rows2 = $mng->executeQuery("cinebase.films", $query);

              foreach ($rows2 as $row2) {

                  $count2 = 0;
                  foreach ($row2->screenings as $key => $value) {
                      if ($row2->screenings[$count2]->_id == intval($screening_id)) {
                          $film_title = $row2->title;
                          $hall_id = $row2->screenings[$count2]->hall_id;
                          echo "<tr>";
                          echo "<td style=\"padding: 5px 10px 5px 10px;\">" . $ticket_id . "</td>";
                          echo "<td style=\"padding: 5px 10px 5px 10px;\">" . $film_title . "</td>";
                          echo "<td style=\"padding: 5px 20px 5px 20px;\">" . $hall_id . "</td>";
                          echo "<td style=\"padding: 5px 30px 5px 30px;\">" . $simpleDate->format('d/m/Y h:m') . "</td>";
                          echo "<td style=\"padding: 5px 10px 5px 10px;\">" . $discount_type . "</td>";
                          echo "<td><a href=\"deleteticket.php?tid=" . $ticket_id . "\"> DELETE </a></td>";
                          echo "</tr>";
                      }
                      $count2++;
                  }

              }
              $count++;
          }

      }


      ?>
      </tbody>
    </table>

    <div><?php echo $count ?> Ticket/s found!</div>


    <br><br><br><br>

    <button class="changePassword" onclick="checkPassword('<?php echo $_SESSION['password']; ?>')">
      Change Password
    </button>
    <button class="deleteMyAccount"
            onclick="deleteAccount(<?php echo $_SESSION['customer_id']; ?>)">Delete my
      Account
    </button>



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