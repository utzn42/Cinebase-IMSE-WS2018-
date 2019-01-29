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

// establish database connection
$mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");

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

      try {

//MAX FINDER

          $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");

          $query = new MongoDB\Driver\Query([]);

          $rows = $mng->executeQuery("cinebase.customers", $query);
          $highest = 0;
          foreach ($rows as $row) {
              if (is_array($row->tickets) || is_object($row->tickets)) {
                  $_count = 0;
                  foreach ($row->tickets as $key => $value) {
                      $temp_id = $row->tickets[$_count]->_id;
                      if ($temp_id > $highest) {
                          $highest = $temp_id;
                      }
                      $_count++;
                  }
              }
          }

      } catch (MongoDB\Driver\Exception\Exception $e) {

          $filename = basename(__FILE__);

          echo "The $filename script has experienced an error.\n";
          echo "It failed with the following exception:\n";

          echo "Exception:", $e->getMessage(), "\n";
          echo "In file:", $e->getFile(), "\n";
          echo "On line:", $e->getLine(), "\n";
      }

      if (isset($_GET['searchEmail'])) {
          //$sql = "SELECT * FROM ticket INNER JOIN customer ON ticket.customer_id = customer.customer_id WHERE email like '%" . $_GET['searchEmail'] . "%'";
          //exact, no regex
          $filter = ['email' => $_GET['searchEmail']];
          $query = new MongoDB\Driver\Query($filter);
      } else {
          $query = new MongoDB\Driver\Query([], ['sort' => ['_id' => 1]]);
      }
      $rows = $mng->executeQuery("cinebase.customers", $query);


      ?>

    <br>
    <div id="insertMovie">
      <form id='insertform' action='ticket.php' method='post'>
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
              <input class="screeningID" id='screening_id' name='screening_id' type='text' size="30"
                     value='<?php echo $GET['screeningID'] ?>'/>
            </td>
            <td>
              <input id='customer_id' name='customer_id' type='text' size="30"
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
      try {
          if (isset($_POST['screening_id']) && !empty($_POST['screening_id']) && isset($_POST['customer_id']) && !empty($_POST['customer_id']) && isset($_POST['price']) && !empty($_POST['price'])) {

              $screening_id = $_POST['screening_id'];
              $customer_id = $_POST['customer_id'];
              $price = $_POST['price'];

              $bulk = new MongoDB\Driver\BulkWrite;

              $filter = ['_id' => intval($customer_id)];
              $query = new MongoDB\Driver\Query($filter);
              $rows = $mng->executeQuery("cinebase.customers", $query);

              $ticketIndex = 0;

              foreach ($rows as $row) {

                  if ($row->tickets != null) {
                      $ticketsArray = $row->tickets;
                  } else {
                      $ticketsArray = [];
                  }

                  $newTicket = ["_id" => intval($highest + 1), "screening_id" => intval($screening_id), "customer_id" => intVal($customer_id), "price" => $price, "discount_type" => "manually inserted"];

                  array_push($ticketsArray, $newTicket);

                  $bulk->update(['_id' => intval($customer_id)], ['$set' => ["tickets" => $ticketsArray]]);

              }

              $mng->executeBulkWrite('cinebase.customers', $bulk);
              header("location: ticket.php");


          }
      } catch (MongoDB\Driver\Exception\Exception $e) {

          $filename = basename(__FILE__);

          echo "The $filename script has experienced an error.\n";
          echo "It failed with the following exception:\n";

          echo "Exception:", $e->getMessage(), "\n";
          echo "In file:", $e->getFile(), "\n";
          echo "On line:", $e->getLine(), "\n";
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

      $countOverall = 0;
      foreach ($rows as $row) {


          $count = 0;
          foreach ($row->tickets as $key => $value) {
              echo "<tr>";

              $ticket_id = $row->tickets[$count]->_id;
              $screening_id = $row->tickets[$count]->screening_id;
              $customer_id = $row->tickets[$count]->customer_id;
              $price = $row->tickets[$count]->price;
              $discount_type = $row->tickets[$count]->discount_type;
              echo "<td style=\"padding: 5px 10px 5px 10px;\">$ticket_id</td>";
              echo "<td style=\"padding: 5px 10px 5px 10px;\">$screening_id</td>";
              echo "<td style=\"padding: 5px 10px 5px 10px;\">$customer_id</td>";
              echo "<td style=\"padding: 5px 10px 5px 10px;\">$price</td>";
              echo "<td style=\"padding: 5px 10px 5px 10px;\">$discount_type</td>";
              if (isset($_SESSION['loggedinEmployee']) && $_SESSION['loggedinEmployee'] == true) {
                  echo "<td><a href=\"updateticket.php?ticket_id=" . $ticket_id . "&screening_id=" . $screening_id . "&customer_id=" . $customer_id . "&price=" . $price . "&discount_type=" . $discount_type . "\"> UPDATE </a></td>";
                  echo "<td><a href=\"deleteticketemp.php?tid=" . $ticket_id . "&cid=" . $customer_id . "\"> DELETE </a></td>";
              }
              $count++;
              $countOverall++;
              echo "</tr>";
          }

      }

      ?>
      </tbody>
    </table>

    <div><?php echo $countOverall ?> Ticket/s found!</div>


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