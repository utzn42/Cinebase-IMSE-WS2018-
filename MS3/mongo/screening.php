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
        <div>

            <a href="screening.php?today=true">Show todays screenings</a><br>
            <a href="screening.php?tomorrow=true">Show tomorrows screenings</a><br>
            <a href="screening.php?nextweek=true">Show this weeks screenings</a><br>
	
        </div>
		
		<?php
			

		//MAX FINDER
			try {

				$mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
				$query = new MongoDB\Driver\Query([], ['sort' => [ '_id' => 1]]); 

				$rows = $mng->executeQuery("cinebase.films", $query);
				$idx=0;
				foreach ($rows as $row) {
					
					if($row->_id>$idx){
						$idx=$row->_id;
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
		
		
		
		
		
		
		
		
		
		
		
		    <table style='border: 1px solid #DDDDDD'>
            <thead>
            <tr id="tableRow">
                <th id="hallName" style="padding: 0px 10px 0px 10px;"><a href="screening.php?sortbyhall=true">Screening ID</a></th>
                <th id="filmTitle" style="padding: 0px 10px 0px 10px;"><a href="screening.php?sortbytitle=true">Film ID</a></th>
                <th style="padding: 0px 10px 0px 10px;"><a href="screening.php?sortbystarting=true">Hall ID</a></th>
                <th style="padding: 0px 10px 0px 10px;"><a href="screening.php?sortbydur=true">Starting Time</a></th>

            </tr>
            </thead>
            <tbody>
		
		<?php
			

		
			try {

				$mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");

	

				if (isset($_GET['searchFilmID'])) {

					$filter = [ 'title' => new MongoDB\BSON\Regex($_GET['searchTitle'], 'i') ]; 
					$query = new MongoDB\Driver\Query($filter); 

				} else if (isset($_GET['today'])) {
					$filter = [ '_id' => $_GET['searchFilmID'] ]; 
					$query = new MongoDB\Driver\Query($filter); 

				} else if (isset($_GET['tomorrow'])) {
					$query = new MongoDB\Driver\Query([], ['sort' => [ 'title' => 1]]); 

				} else if (isset($_GET['nextweek'])) {
					$query = new MongoDB\Driver\Query([], ['sort' => [ 'director' => 1]]); 
					
				} else if (isset($_GET['searchTitle'])) {
					$query = new MongoDB\Driver\Query([], ['sort' => [ 'country' => 1]]); 
				} 
				
				else if (isset($_GET['sortbyhall'])) {
					$query = new MongoDB\Driver\Query([], ['sort' => [ 'film_language' => 1]]); 
				} else if (isset($_GET['sortbystarting'])) {
					$query = new MongoDB\Driver\Query([], ['sort' => [ 'duration' => 1]]); 
				} else if (isset($_GET['sortbyfilm'])) {
					$query = new MongoDB\Driver\Query([], ['sort' => [ 'age_rating' => 1]]); 
				} else if (isset($_GET['sortbytitle'])) {
					$query = new MongoDB\Driver\Query([], ['sort' => [ '_id' => 1]]); 
				} else if (isset($_GET['sortbydur'])) {
					$query = new MongoDB\Driver\Query([], ['sort' => [ '_id' => 1]]); 
				} else if (isset($_GET['sortbyscreening'])) {
					$query = new MongoDB\Driver\Query([], ['sort' => [ '_id' => 1]]); 
				} else {
					$query = new MongoDB\Driver\Query([]);
				}
					
				
				 
				$rows = $mng->executeQuery("cinebase.films", $query);
				$idx=0;
				foreach ($rows as $row) {
					
					$idx++;

                    if (isset($_SESSION['loggedinEmployee']) && $_SESSION['loggedinEmployee'] == true) {
                      //  echo "<td style=\"padding: 5px 10px 5px 10px;\">$row->screenings->hall_id</td>";
                    }
					$count=0;
					

					foreach($row->screenings as $key => $value) {
						echo "<tr>";

						$temp_id = $row->screenings[$count]->_id;
						echo "<td style=\"padding: 5px 10px 5px 10px;\">$temp_id</td>";
						
						$temp_film_id = $row->screenings[$count]->film_id;
						echo "<td style=\"padding: 5px 10px 5px 10px;\">$temp_film_id</td>";

						$temp_hall_id = $row->screenings[$count]->hall_id;
						echo "<td style=\"padding: 5px 10px 5px 10px;\">$temp_hall_id</td>";
						
						$temp_starting_time = $row->screenings[$count]->starting_time;
						echo "<td style=\"padding: 5px 10px 5px 10px;\">$temp_starting_time</td>";
						
						
						echo "<td><a href=\"movies.php?searchFilmID=$temp_id\"> Show Film Details </a></td>";

						echo "</tr>";

						$count++;
					}

					
					
			

					//echo '<pre>'; print_r($row->screenings); echo '</pre>';

					
                    if (isset($_SESSION['loggedinEmployee']) && $_SESSION['loggedinEmployee'] == true) {
                        
						//UPDATE BUTTON
						//echo "<td><a href=\"updatefilm.php?film_id=$row->_id&title=$row->title&director=$row->director&country=$row->country&film_language=$row->film_language&age_rating=$row->age_rating&duration=$row->duration\"> UPDATE </a></td>";
                        echo "<td>";
						echo "<form method='post' action='updatescreening.php' class='inline'>";
						echo "<input type='hidden' name='screening_id' value=$row(screening)->_id>";
										
						$str_title = urlencode($row->title);  
						echo "<input type='hidden' name='film_id' value=$row(screening)->film_id>";

						echo "<input type='hidden' name='hall_id' value=$row(screening)->hall_id>";
						
						
						$str_starting = urlencode($row(screening)->starting_time);  
						echo "<input type='hidden' name='starting_time' value=$str_starting>";
						
						echo "<button type='submit' name='submit_param' value='submit_value' class='link-button'>";
						echo "UPDATE";
						echo "</button>";
						echo "</form>";
					    echo "</td>";


						
						//DELETE BUTTON
						//echo "<td><a href=\"movies.php?del=$row->_id\"> DELETE </a></td>";
						echo "<td>";
						echo "<form action='screening.php' method='post'>";
						echo "<input type='hidden' name='del' value=$row(screening)->_id>";
						echo "<button>DELETE</button>" ;
						echo "</form>";
					    echo "</td>";

				
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
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		



        <br>

        <div id="insertScreening">
            <form id='insertform' action='screening.php' method='post'>
                Add new screening:

                <table style='border: 1px solid #DDDDDD'>
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
                            <input id='screening_id' name='screening_id' type='text' size='10'
                                   value='<?php echo $idx + 1; ?>'/>
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
                                   value='yyyy-mm-dd hh:mm'/>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <input id='insert' type='submit' value='Insert!'/>
            </form>
        </div>

        <?php
        //Handle insert
		try{
			if (isset($_POST['screening_id']) && !empty($_POST['screening_id']) && isset($_POST['film_id']) && !empty($_POST['film_id']) && isset($_POST['hall_id']) && !empty($_POST['hall_id'])) {

				$bulk = new MongoDB\Driver\BulkWrite;
		
				$doc = ['_id' => intval($_POST['film_id']), 'title' => $_POST['title'], 'director' => $_POST['director'], 'country' => $_POST['country'], 'film_language' => $_POST['film_language'], 'age_rating' => intval($_POST['age_rating']), 'duration' => intval($_POST['duration'])];
				$bulk->insert($doc);
				//$bulk->update(['name' => 'Audi'], ['$set' => ['price' => 52000]]);
				//$bulk->delete(['name' => 'Hummer']);
				
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


        echo("<script type=\"text/javascript\">hideFormInsertScreening();</script>");

        ?>
        <br>



            <?php

            // fetch rows of the executed sql query
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    $date = $row['starting_time'];
                    $simpleDate = new DateTime($date);

                    echo "<tr>";
                    if (isset($_SESSION['loggedinEmployee']) && $_SESSION['loggedinEmployee'] == true) {
                        echo "<td>" . $row['screening_id'] . "</td>";
                        echo "<td>" . $row['hall_id'] . "</td>";
                    }


                    echo "<td>" . $row['name'] . "</td>";

                    if (isset($_SESSION['loggedinEmployee']) && $_SESSION['loggedinEmployee'] == true) {
                        echo "<td>" . $row['film_id'] . "</td>";
                    }

                    echo "<td style=\"padding: 0px 10px 0px 10px;\">" . $row['title'] . "</td>";
                    echo "<td style=\"padding: 0px 10px 0px 10px;\">" . $simpleDate->format('d/m/Y H:i') . "</td>";
                    echo "<td style=\"padding: 0px 10px 0px 10px;\">" . $row['duration'] . "</td>";

                    if (isset($_SESSION['loggedinEmployee']) && $_SESSION['loggedinEmployee'] == true) {
                        echo "<td><a href=\"updatescreening.php?screening_id=" . $row['screening_id'] . "&hall_id=" . $row['hall_id'] . "&film_id=" . $row['film_id'] . "&starting_time=" . $row['starting_time'] . "\"> UPDATE </a></td>";
                        echo "<td><a href=\"deletescreening.php?id=" . $row['screening_id'] . "\"> DELETE </a></td>";
                    }
                    echo "<td style=\"padding: 5px 10px 5px 10px;\"><a href=\"movies.php?searchFilmID=" . $row['film_id'] . "\"> Show Film Details </a></td>";
                    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                        echo "<td style=\"padding: 5px 10px 5px 10px;\"><a href=\"reserveticket.php?screening_id=" . $row['screening_id'] . "\"> RESERVE </a></td>";
                    }
                    echo "</tr>";
                }
            }
            $row_cnt = mysqli_num_rows($result);


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
            echo("<script type=\"text/javascript\">displayScreeningIDs();</script>");
        }
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