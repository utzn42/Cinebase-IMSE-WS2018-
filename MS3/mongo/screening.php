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
error_reporting(E_ALL ^ E_NOTICE);

?>

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
    <div>
      <form id='searchform' action='screening.php' method='get'>
        <a href='screening.php'>All Screenings</a> ---
        Search for Film Title:
        <input id='searchTitle' name='searchTitle' type='text' size='20'
               value='<?php echo $_GET['searchTitle']; ?>'/>
        <input id='search' type='submit' value='Search!'/>
      </form>
      <br>
    </div>
   

    <?php


    //MAX FINDER
    try {

 
		$mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");

		$query = new MongoDB\Driver\Query([]);
		  
        $rows = $mng->executeQuery("cinebase.films", $query);
        $highest = 0;
        foreach ($rows as $row) {
            if (is_array($row->screenings) || is_object($row->screenings)) {
				$_count=0;
                foreach ($row->screenings as $key => $value) {
                    $temp_id = $row->screenings[$_count]->_id;
					if ($temp_id>$highest){
						$highest=$temp_id;
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

    <div id="insertScreening">
      <form id='insertform' action='screening.php' method='post'>
        Add new screening:

        <table style='border: 1px solid #DDDDDD'  align='center'>
          <thead>
          <tr>
            <th>Screening-ID</th>
            <th style="padding: 0px 10px 0px 10px;">Hall-ID</th>
            <th style="padding: 0px 10px 0px 10px;">Film-ID</th>
            <th style="padding: 0px 10px 0px 10px;">Starting Time</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td>
                <input id='screening_id' name='screening_id' type='text' size='10' readonly
                       value='<?php echo $highest + 1; ?>'/>
            </td>
            <td>
              <input id='hall_id' name='hall_id' type='text' size='20'
                     value='<?php echo $_GET['hall_id']; ?>'/>
            </td>
            <td>
              <input id='film_id' name='film_id' type='text' size='20'
                     value='<?php echo $_GET['film_id']; ?>'/>
            </td>
            <td>
              <input id='starting_time' name='starting_time' type='text' size='20'
                     value='yyyy-mm-dd hh:mm:ss'/>
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
          if (isset($_POST['screening_id']) && !empty($_POST['screening_id']) && isset($_POST['film_id']) && !empty($_POST['film_id']) && isset($_POST['hall_id']) && !empty($_POST['hall_id'])) {

              $screening_id = $_POST['screening_id'];
              $film_id = $_POST['film_id'];
              $hall_id = $_POST['hall_id'];
              $starting_time = $_POST['starting_time'];
              if ($hall_id > 0 && $hall_id <= 8) {
                  $bulk = new MongoDB\Driver\BulkWrite;

                  $filter = ['_id' => intval($film_id)];
                  $query = new MongoDB\Driver\Query($filter);
                  $rows = $mng->executeQuery("cinebase.films", $query);

                  $screeningIndex = 0;

                  foreach ($rows as $row) {

                      if ($row->screenings != null) {
                          $screeningsArray = $row->screenings;
                      } else {
                          $screeningsArray = [];
                      }


                      //DATE TO UTC
                      $orig_date = new DateTime($starting_time);
                      $orig_date = $orig_date->getTimestamp();
                      $utcdatetime = new MongoDB\BSON\UTCDateTime($orig_date * 1000);


                      $newScreening = ["_id" => intval($screening_id), "hall_id" => intval($hall_id), "starting_time" => $utcdatetime];

                      array_push($screeningsArray, $newScreening);

                      $bulk->update(['_id' => intval($film_id)], ['$set' => ["screenings" => $screeningsArray]]);

                  }

                  $mng->executeBulkWrite('cinebase.films', $bulk);





              } else {
                  echo "Invalid Hall ID";
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


      echo("<script type=\"text/javascript\">hideFormInsertScreening();</script>");


      //Handle delete

      try {

          $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");

          if (isset($_POST["delScreening"])) {

              $bulk = new MongoDB\Driver\BulkWrite;

              $del_screening = $_POST["delScreening"];
              $del_film = $_POST["delFilm"];

              $filter = ['_id' => intval($del_film)];
              $query = new MongoDB\Driver\Query($filter);
              $rows = $mng->executeQuery("cinebase.films", $query);

              $screeningIndex = 0;


              foreach ($rows as $row) {

                  $screeningsArray = $row->screenings;

                  $count = 0;
                  foreach ($row->screenings as $key => $value) {

                      if ($screeningsArray[$count]->_id == $del_screening){
                          $screeningIndex = $count;
                          break;
                      }

                      $count++;
                  }

                  \array_splice($screeningsArray, $screeningIndex, 1);

                  $bulk->update(['_id' => intval($del_film)], ['$set' => ["screenings" => $screeningsArray]]);

              }

              $mng->executeBulkWrite('cinebase.films', $bulk);
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


    <table style='border: 1px solid #DDDDDD'>
      <thead>
      <tr id="tableRow">
        <th id="hallName" style="padding: 0px 10px 0px 10px;">Screening ID</th>
        <th id="filmTitle" style="padding: 0px 10px 0px 10px;">Film ID</th>
        <th style="padding: 0px 10px 0px 10px;">Title</th>
        <th style="padding: 0px 10px 0px 10px;">Hall ID</th>

        <th style="padding: 0px 10px 0px 10px;">Starting Time</a></th>

      </tr>
      </thead>
      <tbody>

      <?php


      try {

          $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");


          if (isset($_GET['searchFilmID'])) {

            $filter = [ '_id' => intval($_GET['searchFilmID']) ]; 
			$query = new MongoDB\Driver\Query($filter); 

          } else if (isset($_GET['today'])) {
                $filter = ['_id' => $_GET['searchFilmID']];
                $query = new MongoDB\Driver\Query($filter);

          } else if (isset($_GET['tomorrow'])) {
                $query = new MongoDB\Driver\Query([], ['sort' => ['title' => 1]]);

          } else if (isset($_GET['nextweek'])) {
                $query = new MongoDB\Driver\Query([], ['sort' => ['director' => 1]]);

          } else if (isset($_GET['searchTitle'])) {
			  
				$filter = [ 'title' => new MongoDB\BSON\Regex($_GET['searchTitle'], 'i') ]; 
				$query = new MongoDB\Driver\Query($filter); 	     
          } else {
                $query = new MongoDB\Driver\Query([]);
          }


          $rows = $mng->executeQuery("cinebase.films", $query);
          $idx = 0;
          foreach ($rows as $row) {

              $idx++;

      
              $count = 0;

              if (is_array($row->screenings) || is_object($row->screenings)) {
                  foreach ($row->screenings as $key => $value) {


                      echo "<tr>";

                      $temp_id = $row->screenings[$count]->_id;
                      echo "<td style=\"padding: 5px 10px 5px 10px;\">$temp_id</td>";

                      $title = $row->title;
                      $temp_film_id = $row->_id;
                      echo "<td style=\"padding: 5px 10px 5px 10px;\">$temp_film_id</td>";

                      echo "<td style=\"padding: 5px 10px 5px 10px;\">$title</td>";

                      $temp_hall_id = $row->screenings[$count]->hall_id;
                      echo "<td style=\"padding: 5px 10px 5px 10px;\">$temp_hall_id</td>";

                      $utctime = $row->screenings[$count]->starting_time;

                      $datetime = $utctime->toDateTime();

                      $time=$datetime->format(DATE_RSS);
					  $utc_string = strtotime($time.' UTC');
					  $temp_starting_time = date("Y-m-d H:i", $utc_string);
                      echo "<td style=\"padding: 5px 10px 5px 10px;\">$temp_starting_time</td>";


                      if (isset($_SESSION['loggedinEmployee']) && $_SESSION['loggedinEmployee'] == true) {

                          //UPDATE BUTTON
                          echo "<td>";
                          echo "<form method='post' action='updatescreening.php' class='inline'>";
                          echo "<input type='hidden' name='screening_id' value=$temp_id>";

                          $str_title = urlencode($row->title);
                          echo "<input type='hidden' name='film_id' value=$temp_film_id>";

                          echo "<input type='hidden' name='hall_id' value=$temp_hall_id>";


						  $orig_date = new DateTime($temp_starting_time);
						  $orig_date=$orig_date->getTimestamp();
					      $utcdatetime = new MongoDB\BSON\UTCDateTime($orig_date*1000);
						  
                     
                          echo "<input type='hidden' name='starting_time' value=$utcdatetime>";

                          echo "<button type='submit' name='submit_param' value='submit_value' class='link-button'>";
                          echo "UPDATE";
                          echo "</button>";
                          echo "</form>";
                          echo "</td>";


                          //DELETE BUTTON
                          echo "<td>";
                          echo "<form action='screening.php' method='post'>";
                          echo "<input type='hidden' name='delScreening' id='delScreening' value=$temp_id>";
                          echo "<input type='hidden' name='delFilm' id='delFilm' value=$temp_film_id>";
                          echo "<button>DELETE</button>";
                          echo "</form>";
                          echo "</td>";


                      }
                      echo "<td><a href=\"movies.php?searchFilmID=$temp_film_id\"> Show Film Details </a></td>";
                      if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                          echo "<td style=\"padding: 5px 10px 5px 10px;\"><a href=\"reserveticket.php?screening_id=" . $temp_id . "&film_id=" . $temp_film_id . "\"> RESERVE </a></td>";
                      }


                      echo "</tr>";

                      $count++;
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

      </tbody>
    </table>

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
          //echo("<script type=\"text/javascript\">displayFilmIDs();</script>");
      }
      ?>

    <br>


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