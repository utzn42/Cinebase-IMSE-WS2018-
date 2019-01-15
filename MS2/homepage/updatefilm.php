<?php


$user = 'root';
$pass = '';
$database = 'cinebase';

$conn = new mysqli('localhost', $user, $pass, $database) or die("dead");


?>
<html>
<head>
</head>
<body>

<a href="ticket.php">Back to Tickets</a><br><br>
<div>
    <form id='updateform' action="" method="get">
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
                           value='<?php echo $_GET['film_id']; ?>'/>
                </td>
                <td>
                    <input id='title' name='title' type='text' size='20' value='<?php echo $_GET['title']; ?>'/>
                </td>
                <td>
                    <input id='director' name='director' type='text' size='20'
                           value='<?php echo $_GET['director']; ?>'/>
                </td>
                <td>
                    <input id='country' name='country' type='text' size='20' value='<?php echo $_GET['country']; ?>'/>
                </td>
                <td>
                    <input id='film_language' name='film_language' type='text' size='20'
                           value='<?php echo $_GET['film_language']; ?>'/>
                </td>
                <td>
                    <input id='age_rating' name='age_rating' type='text' size='20'
                           value='<?php echo $_GET['age_rating']; ?>'/>
                </td>
                <td>
                    <input id='duration' name='duration' type='text' size='20'
                           value='<?php echo $_GET['duration']; ?>'/>
                </td>
            </tr>
            </tbody>
        </table>
        <input id='submit' type='submit' name="submit" value='Update!'/>
    </form>
</div>

<?php


if (isset($_GET["submit"])) {


    $film_id = $_GET['film_id'];
    $title = $_GET['title'];
    $director = $_GET['director'];
    $country = $_GET['country'];
    $film_language = $_GET['film_language'];
    $age_rating = $_GET['age_rating'];
    $duration = $_GET['duration'];


    // sql to update a record
    $sql = "UPDATE film 
		SET title = \"$title\",
		director=\"$director\",
		country=\"$country\",
		film_language=\"$film_language\",
		age_rating=$age_rating,
		duration=$duration
		WHERE film_id=$film_id";


    //Parse and execute statement
    if ($conn->query($sql) === TRUE) {
        echo "Record updated succesfully";
        header("location: movies.php");

    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


?>
</body>
</html>