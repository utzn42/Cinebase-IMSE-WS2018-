<?php
error_reporting(0);

$screening_id = $_POST['screening_id'];
$film_id = $_POST['film_id'];
$hall_id = $_POST['hall_id'];
$old_id = $_POST['old_id'];


$utc_string = $_POST['starting_time'];

//DATE TO UTC
$utctime = new MongoDB\BSON\UTCDateTime($utc_string);

$datetime = $utctime->toDateTime();

$time=$datetime->format(DATE_RSS);
$utc_string = strtotime($time.' UTC');

$temp_starting_time_encoded = urlencode(date("Y-m-d H:i:s", $utc_string));
$temp_starting_time = date("Y-m-d H:i:s", $utc_string);

	


?>
<html>
<head>
</head>
<body>

<a href="screening.php">Back to Screenings</a><br><br>
<div>
  <form id='updateform' action="updatescreening.php" method="post">
    Update screening:
    <table style='border: 1px solid #DDDDDD'>
      <thead>
      <tr>
        <th>Screening-ID</th>
        <th>Hall-ID</th>
        <th>Film-ID</th>
        <th>Starting Time</th>
      </tr>
      </thead>
      <tbody>
      <tr>
        <td>
          <input id='new_screening_id' name='new_screening_id' type='number' size='20'
                 value='<?php echo $screening_id; ?>'/>
        </td>
        <td>
          <input id='new_hall_id' name='new_hall_id' type='number' size='20'
                 value='<?php echo $hall_id; ?>'/>
        </td>
        <td>
          <input id='new_film_id' name='new_film_id' type='number' size='20' readonly
                 value='<?php echo $film_id; ?>'/>
        </td>
        <td>
          <input id='new_starting_time' name='new_starting_time' type='text' size='20'
                 value='<?php echo $temp_starting_time; ?>'/>
        </td>
		<input type='hidden' name='old_id' value='<?php echo $screening_id; ?>'/>

      </tr>
      </tbody>
    </table>
    <input id='submit' type='submit' name="submit" value='Update!'/>
  </form>
</div>

<?php


if (isset($_POST["submit"])) {

    //Handle insert
    try {

        $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");


        $new_screening_id = $_POST['new_screening_id'];
        $new_film_id = $_POST['new_film_id'];
        $new_hall_id = $_POST['new_hall_id'];
        $new_starting_time = $_POST['new_starting_time'];

//        echo intval($_POST['new_film_id']);



		//UTC TO DATE
		$orig_date = new DateTime($new_starting_time);
		$orig_date=$orig_date->getTimestamp();
		$utcdatetime = new MongoDB\BSON\UTCDateTime($orig_date*1000);



        $filter = ['_id' => intval($new_film_id)];
        $query = new MongoDB\Driver\Query($filter);
        $rows = $mng->executeQuery("cinebase.films", $query);

        $screeningIndex = 0;

        foreach ($rows as $row) {

            $screeningsArray = $row->screenings;

            $count = 0;
            foreach ($row->screenings as $key => $value) {

                if ($screeningsArray[$count]->_id == intval($old_id)){
                  $screeningIndex = $count;
                  break;
                }

                $count++;
            }

        }

        $bulk = new MongoDB\Driver\BulkWrite;


        $bulk->update(['_id' => intval($new_film_id)], ['$set' => ["screenings.".$screeningIndex."._id" => intval($new_screening_id)]]);
        $bulk->update(['_id' => intval($new_film_id)], ['$set' => ["screenings.".$screeningIndex.".hall_id" => intval($new_hall_id)]]);
        $bulk->update(['_id' => intval($new_film_id)], ['$set' => ["screenings.".$screeningIndex.".starting_time" => $utcdatetime]]);



        $mng->executeBulkWrite('cinebase.films', $bulk);
        header("location: screening.php");

    } catch (MongoDB\Driver\Exception\Exception $e) {

        $filename = basename(__FILE__);

        echo "The $filename script has experienced an error.\n";
        echo "It failed with the following exception:\n";

        echo "Exception:", $e->getMessage(), "\n";
        echo "In file:", $e->getFile(), "\n";
        echo "On line:", $e->getLine(), "\n";
    }

}


?>
</body>
</html>