
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
    <form id='searchform' action='sitz.php' method='get'>
      <a href='sitz.php'>Alle Sitze</a> ---
      Suche nach Sitz (Saal-ID): 
      <input id='search' name='search' type='text' size='20' value='<?php echo $_GET['search']; ?>' />
      <input id='submit' type='submit' value='Los!' />
    </form>
  </div>
<?php
  // check if search view of list view
  if (isset($_GET['search'])) {
    $sql = "SELECT * FROM sitz WHERE saal_id = '" . $_GET['search'] . "'";
  } else {
    $sql = "SELECT * FROM sitz";
  }

  // execute sql statement
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
?>
  <table style='border: 1px solid #DDDDDD'>
    <thead>
      <tr>
        <th>ID</th>
        <th>Saal-ID</th>
        <th>Reihe</th>
        <th>Sitznummer</th>
      </tr>
    </thead>
    <tbody>
<?php
  // fetch rows of the executed sql query
  while ($row = oci_fetch_assoc($stmt)) {
    echo "<tr>";
    echo "<td>" . $row['SITZ_ID'] . "</td>";
    echo "<td>" . $row['SAAL_ID'] . "</td>";
	echo "<td>" . $row['REIHENNUMMER'] . "</td>";
    echo "<td>" . $row['SITZNUMMER'] . "</td>";
    echo "</tr>";
  }
?>
    </tbody>
  </table>
<div>Insgesamt <?php echo oci_num_rows($stmt); ?> Sitz(e) gefunden!</div>
<?php  oci_free_statement($stmt); ?>








<br>
<a href="index.php">Zurueck zur Startseite</a><br>

</body>
</html>
