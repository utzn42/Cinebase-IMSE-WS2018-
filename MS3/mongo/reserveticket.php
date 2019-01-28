<?php
session_start();
error_reporting(0);

$screening_id = $_GET['screening_id'];
$film_id = $_GET['film_id'];
$customer_id = $_SESSION['customer_id'];
$username = $_SESSION['username'];

?>

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

<div class="wrapper">
  <div class="topLine" id="topLine">
    cinebase
    <button onclick="window.location='index.php';" style="margin-left: 20px" class="buttonBig">Home
    </button>
    <button onclick="window.location='movies.php';"
            class="buttonBig">Movies
    </button>
    <button onclick="window.location='screening.php';"
            style="border-bottom: 2px solid whitesmoke; font-weight: bold" class="buttonBig">
      Screenings
    </button>
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

?>


<div class="wrapperMainBody">
  <div class="mainBody" id="mainBody">
    <div>
      <form id='searchform' action='screening.php' method='get'>
        <a href='screening.php'>back to screenings</a>
      </form>
      <br>
    </div>

    <table style='border: 1px solid #DDDDDD'>
      <thead>
      <tr>
        <th>Screening-ID</th>
        <th>Film-Title</th>
        <th>Hall</th>
        <th>Starting Time</th>
        <th>Duration (minutes)</th>
        <th style="padding: 0px 10px 0px 10px;">Quantity</th>
        <th style="padding: 0px 10px 0px 10px;">Discount Type</th>
      </tr>

      </thead>
      <tbody>
      <?php

      try {

          $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");

          $filter = ['_id' => intval($film_id)];
          $query = new MongoDB\Driver\Query($filter);
          $rows = $mng->executeQuery("cinebase.films", $query);

          $screeningIndex = 0;

          foreach ($rows as $row) {

              $screeningsArray = $row->screenings;

              $count = 0;
              foreach ($row->screenings as $key => $value) {

                  if ($screeningsArray[$count]->_id == intval($screening_id)) {

                      echo "<tr>";

                      $temp_id = $row->screenings[$count]->_id;
                      echo "<td style=\"padding: 5px 10px 5px 10px;\">$temp_id</td>";

                      $title = $row->title;

                      echo "<td style=\"padding: 5px 10px 5px 10px;\">$title</td>";

                      $temp_hall_id = $row->screenings[$count]->hall_id;
                      echo "<td style=\"padding: 5px 10px 5px 10px;\">$temp_hall_id</td>";

                      $utctime = $row->screenings[$count]->starting_time;

                      $datetime = $utctime->toDateTime();

                      $time = $datetime->format(DATE_RSS);
                      $utc_string = strtotime($time . ' UTC');
                      $temp_starting_time = date("Y-m-d H:i", $utc_string);
                      echo "<td style=\"padding: 5px 10px 5px 10px;\">$temp_starting_time</td>";

                      $duration = $row->screenings[$count]->duration;
                      echo "<td style=\"padding: 5px 10px 5px 10px;\">$duration</td>";

                      break;
                  }

                  $count++;
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

      ?>
      <td>
        <form id="qty_select" name="qty_select" action="" method="post">
          <select name="quantity" id="quantity">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
          </select>
      </td>
      <td>
        <input type="checkbox" name="boxes[]" value="Student" vertical-align: middle;>Student<br>
        <input type="checkbox" name="boxes[]" value="Pensioner" vertical-align:
               middle;>Pensioner<br>
      </td>
      </tbody>
    </table>
    <input type="submit" name="reserve" id="reserve" value="Make Reservation"
           style="margin-top: 30px;"/><br/>

      <?php
      if (!empty($_POST['boxes'])) {
          $discounts = array();
          foreach ($_POST['boxes'] as $checked) {
              array_push($discounts, $checked);
          }
      }

      if (isset($_POST['reserve'])) {
          $qty = $_POST['quantity'];
      }

      function reservetickets($screening_id, $customer_id, $qty, $discounts, $highest)
      {
          try {

              $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
              $price = 10;

              $bulk = new MongoDB\Driver\BulkWrite;

              $filter = ['_id' => intval($customer_id)];
              $query = new MongoDB\Driver\Query($filter);
              $rows = $mng->executeQuery("cinebase.customers", $query);

              foreach ($rows as $row) {
                  if ($row->tickets != null) {
                      $ticketsArray = $row->tickets;
                  } else {
                      $ticketsArray = [];
                  }
              }


              if ($discounts == NULL) {
                  for ($x = 0; $x < $qty; $x++) {
                      $newTicket = ["_id" => intval($highest + $x + 1), "screening_id" => intval($screening_id), "customer_id" => intVal($customer_id), "price" => $price, "discount_type" => ""];
                      array_push($ticketsArray, $newTicket);
                  }
              }

              if (sizeof($discounts) == 1) {
                  for ($x = 0; $x < $qty; $x++) {
                      $newTicket = ["_id" => intval($highest + $x + 1), "screening_id" => intval($screening_id), "customer_id" => intVal($customer_id), "price" => $price, "discount_type" => $discounts[0]];
                      array_push($ticketsArray, $newTicket);
                  }
              }

              if (sizeof($discounts) == 2) {
                  for ($x = 0; $x < $qty; $x++) {
                      $newTicket = ["_id" => intval($highest + $x + 1), "screening_id" => intval($screening_id), "customer_id" => intVal($customer_id), "price" => $price, "discount_type" => $discounts[0] . "," . $discounts[1]];
                      array_push($ticketsArray, $newTicket);
                  }
              }

              $bulk->update(['_id' => intval($customer_id)], ['$set' => ["tickets" => $ticketsArray]]);

              $mng->executeBulkWrite('cinebase.customers', $bulk);


          } catch (MongoDB\Driver\Exception\Exception $e) {

              $filename = basename(__FILE__);

              echo "The $filename script has experienced an error.\n";
              echo "It failed with the following exception:\n";

              echo "Exception:", $e->getMessage(), "\n";
              echo "In file:", $e->getFile(), "\n";
              echo "On line:", $e->getLine(), "\n";
          }


          echo("<script type=\"text/javascript\">reserveTicketSuccess(" . $qty . ");</script>");
      }

      if (array_key_exists('reserve', $_POST)) {
          reservetickets($screening_id, $customer_id, $qty, $discounts, $highest);
      }
      ?>

    <div>
        <?php mysqli_close($conn); ?>
    </div>
  </div>
</div>
</body>
</html>

