
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
                    <input id='film_id' name='film_id' type='text' size='20' readonly
                           value='<?php echo $film_id; ?>'/>
                </td>
                <td>
                    <input id='title' name='title' type='text' size='20' value='<?php echo $title; ?>'/>
                </td>
                <td>
                    <input id='director' name='director' type='text' size='20'
                           value='<?php echo $director; ?>'/>
                </td>
                <td>
                    <input id='country' name='country' type='text' size='20' value='<?php echo $country; ?>'/>
                </td>
                <td>
                    <input id='film_language' name='film_language' type='text' size='20'
                           value='<?php echo $film_language; ?>'/>
                </td>
                <td>
                    <input id='age_rating' name='age_rating' type='text' size='20'
                           value='<?php echo $age_rating; ?>'/>
                </td>
                <td>
                    <input id='duration' name='duration' type='text' size='20'
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





        //Handle insert
		try {
     
			$mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
			

			$bulk = new MongoDB\Driver\BulkWrite;
			$bulk->update(['_id' => $film_id], ['$set' => ['director' => $director]]);
			
			$bulk->update(['_id' => $film_id], ['$set' => ['title' => $title]]);
			$bulk->update(['_id' => $film_id], ['$set' => ['country' => $country]]);
			$bulk->update(['_id' => $film_id], ['$set' => ['film_language' => $film_language]]);
			$bulk->update(['_id' => $film_id], ['$set' => ['age_rating' => $age_rating]]);
			$bulk->update(['_id' => $film_id], ['$set' => ['duration' => $duration]]);
			
			//$bulk->delete(['name' => 'Hummer']);
			
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
		


        //echo("<script type=\"text/javascript\">hideFormInsertMovie();</script>");


        
}


?>
</body>
</html>