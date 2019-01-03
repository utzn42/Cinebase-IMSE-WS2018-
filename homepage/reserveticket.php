<?php
session_start();

$screening_id = $_GET['screening_id'];
$customer_id = $_SESSION['customer_id'];
$username = $_SESSION['username'];

$user = 'root';
$pass = '';
$database = 'cinebase';

$conn = new mysqli('localhost', $user, $pass, $database) or die("dead");
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
        <button onclick="window.location='news.php';" class="buttonBig">News</button>
        <button onclick="window.location='aboutUs.php';" class="buttonBig">About Us</button>
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
?>

<?php
$sql = "SELECT screening_id, title, name, starting_time, duration FROM screening INNER JOIN film ON screening.film_id=film.film_id INNER JOIN hall ON screening.hall_id = hall.hall_id WHERE screening_id = $screening_id ";
$result = $conn->query($sql);
$row_cnt = mysqli_num_rows($result);
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
                <th>Quantity</th>
                <th>Discount Type</th>
            </tr>

            </thead>
            <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    echo "<tr>";
                    echo "<td>" . $row['screening_id'] . "</td>";
                    echo "<td>" . $row['title'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['starting_time'] . "</td>";
                    echo "<td>" . $row['duration'] . "</td>";
                }
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
                <input type="checkbox" name="student" value="student" vertical-align: middle;>Student<br>
                <input type="checkbox" name="pensioner" value="pensioner" vertical-align: middle;>Pensioner<br>
            </td>
            </tbody>
        </table>
			<input type="submit" name="reserve" id="reserve" value="Make Reservation" style="margin-top: 30px;"/><br/>
        </form>

        <?php
		
        if (isset($_POST['buy'])) {
            $qty = $_POST['quantity'];  // Storing Selected Value In Variable
        }

        function buytickets($conn, $screening_id, $customer_id, $qty)
        {
			echo("<script type=\"text/javascript\">buyTicketSuccess(".$qty.");</script>");
            $sql = "INSERT INTO ticket(screening_id, customer_id, price, discount_type) VALUES (\"$screening_id\", \"$customer_id\", 10.00, 0)";
            for ($x = 0; $x < $qty; $x++) {
                mysqli_query($conn, $sql);
            }
        }

        if (array_key_exists('buy', $_POST)) {
            buytickets($conn, $screening_id, $customer_id, $qty);
        }
        ?>

        <div>
            <?php mysqli_close($conn); ?>
        </div>
    </div>
</div>
</body>
</html>

