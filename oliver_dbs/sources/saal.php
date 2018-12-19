
<?php
  error_reporting(0);
  $user = 'a01220194';
  $pass = 'car3grass';
  $database = 'lab';
 
  // establish database connection
  $conn = oci_connect($user, $pass, $database);
  if (!$conn) exit;
?>

<html>
<head>
</head>
<body>
  <div>
    <form id='searchform' action='saal.php' method='get'>
      <a href='saal.php'>Alle Saele</a> ---
      Suche nach Name: 
      <input id='search' name='search' type='text' size='20' value='<?php echo $_GET['search']; ?>' />
      <input id='submit' type='submit' value='Los!' />
    </form>
  </div>
<?php
  // check if search view of list view
  if (isset($_GET['search'])) {
    $sql = "SELECT * FROM saal WHERE name like '%" . $_GET['search'] . "%'";
  } else {
    $sql = "SELECT * FROM saal";
  }

  // execute sql statement
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
?>
SAELE:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Auf Saal klicken, um seine Vorfuehrungen zu sehen)
  <table style='border: 1px solid #DDDDDD'>
    <thead>
      <tr>
        <th>Saal-ID</th>
        <th>Name</th>
        <th>Ausstattung</th>
      </tr>
    </thead>
    <tbody>
<?php
  // fetch rows of the executed sql query
  while ($row = oci_fetch_assoc($stmt)) {
    echo "<tr>";
    echo "<td>" . $row['SAAL_ID'] . "</td>";
    echo "<td> <a href=\"vorfuehrung.php?search2=" . $row['SAAL_ID'] . "\">" . $row['NAME'] . " </a></td>";
	echo "<td>" . $row['AUSSTATTUNG'] . "</td>";
    echo "</tr>";
  }
?>
    </tbody>
  </table>
<div>Insgesamt <?php echo oci_num_rows($stmt); ?> Saele/Saal gefunden!</div>
<?php  oci_free_statement($stmt); ?>

<br>
<a href="index.php">Zurueck zur Startseite</a><br>



</body>
</html>
