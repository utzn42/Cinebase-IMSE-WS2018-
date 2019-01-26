
<html>
<head>
</head>
<body>

<?php
    $film_id = $_POST['film_id'];
    $title = urldecode($_POST['title']);
    $director = urldecode($_POST['director']);
    $country = $_POST['country'];
    $film_language = urldecode($_POST['film_language']);
    $age_rating = $_POST['age_rating'];
    $duration = $_POST['duration'];
?>

<a href="movies.php">Back to Movies</a><br><br>
<div>
    <form id='updateform' action="updatefilm.php" method="post">
        Update film:
        <table style='border: 1px solid #DDDDDD'>
            <thead>
            <tr>
                <th>Film ID</th>
                <th>Title</th>
                <th>Director</th>
                <th>Country</th>
                <th>Language</th>
                <th>Age rating</th>
                <th>Duration</th>

            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <input id='new_film_id' name='new_film_id' type='number' size='20' readonly
                           value='<?php echo $film_id; ?>'/>
                </td>
                <td>
                    <input id='new_title' name='new_title' type='text' size='20' value='<?php echo $title; ?>'/>
                </td>
                <td>
                    <input id='new_director' name='new_director' type='text' size='20'
                           value='<?php echo $director; ?>'/>
                </td>
                <td>
                    <input id='new_country' name='new_country' type='text' size='20' value='<?php echo $country; ?>'/>
                </td>
                <td>
                    <input id='new_film_language' name='new_film_language' type='text' size='20'
                           value='<?php echo $film_language; ?>'/>
                </td>
                <td>
                    <input id='new_age_rating' name='new_age_rating' type='number' size='20'
                           value='<?php echo $age_rating; ?>'/>
                </td>
                <td>
                    <input id='new_duration' name='new_duration' type='number' size='20'
                           value='<?php echo $duration; ?>'/>
                </td>
            </tr>
            </tbody>
        </table>
        <input id='submit' type='submit' name="submit" value='Update!'/>
    </form>
</div>

<?php


if (isset($_POST["submit"])) {
		//echo $_POST['new_director'];


        //Handle insert
		try {
     
			$mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
			

			echo intval($_POST['new_film_id']);

			$bulk = new MongoDB\Driver\BulkWrite;
			
			$bulk->update(['_id' => intval($_POST['new_film_id'])], ['$set' => ['director' => $_POST['new_director']]]);			
			$bulk->update(['_id' => intval($_POST['new_film_id'])], ['$set' => ['title' => $_POST['new_title']]]);
			$bulk->update(['_id' => intval($_POST['new_film_id'])], ['$set' => ['country' => $_POST['new_country']]]);
			$bulk->update(['_id' => intval($_POST['new_film_id'])], ['$set' => ['film_language' => $_POST['new_film_language']]]);
			$bulk->update(['_id' => intval($_POST['new_film_id'])], ['$set' => ['age_rating' => intval($_POST['new_age_rating'])]]);
			$bulk->update(['_id' => intval($_POST['new_film_id'])], ['$set' => ['duration' => intval($_POST['new_duration'])]]);
			
			
			$mng->executeBulkWrite('cinebase.films', $bulk);
			header("location: movies.php");
			
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