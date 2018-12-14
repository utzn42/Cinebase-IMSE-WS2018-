
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
    <form id='searchform' action='aufsicht.php' method='get'>
      <a href='aufsicht.php'>Alle Aufsichten</a> ---
      Suche nach Aufsicht (Saal-ID): 
      <input id='search' name='search' type='text' size='20' value='<?php echo $_GET['search']; ?>' />
      <input id='submit' type='submit' value='Los!' />
    </form>
  </div>
<?php
  // check if search view of list view
  if (isset($_GET['search'])) {
    $sql = "select aufsicht.saal_id, aufseher_id, name, nachname FROM (aufsicht LEFT JOIN saal ON aufsicht.saal_id=saal.saal_id) Left JOIN mitarbeiter ON aufseher_id=personal_id WHERE aufsicht.saal_id = '" . $_GET['search'] . "'";
  } else {
    $sql = "select aufsicht.saal_id, aufseher_id, name, nachname FROM (aufsicht LEFT JOIN saal ON aufsicht.saal_id=saal.saal_id) Left JOIN mitarbeiter ON aufseher_id=personal_id";
  }

  // execute sql statement
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
?>
  <table style='border: 1px solid #DDDDDD'>
    <thead>
      <tr>
        <th>Saal-ID</th>
        <th>Aufseher-ID</th>
		<th>Saal-Name</th>
        <th>Aufseher-Name</th>

		
      </tr>
    </thead>
    <tbody>
<?php
  // fetch rows of the executed sql query
  while ($row = oci_fetch_assoc($stmt)) {
    echo "<tr>";
    echo "<td>" . $row['SAAL_ID'] . "</td>";
    echo "<td>" . $row['AUFSEHER_ID'] . "</td>";
    echo "<td>" . $row['NAME'] . "</td>";
    echo "<td>" . $row['NACHNAME'] . "</td>";
    echo "</tr>";
  }
?>
    </tbody>
  </table>
<div>Insgesamt <?php echo oci_num_rows($stmt); ?> Aufsicht(en) gefunden!</div>
<?php  oci_free_statement($stmt); ?>

<br>
<br>
<br>


<div>
  <form id='insertform' action='aufsicht.php' method='get'>
    Neue Aufsicht einfuegen:
	<table style='border: 1px solid #DDDDDD'>
	  <thead>
	    <tr>
	      <th>Saal-ID</th>
	      <th>Aufseher-ID</th>
	    </tr>
	  </thead>
	  <tbody>
	     <tr>
	        <td>
	           <input id='saal_id' name='saal_id' type='text' size='10' value='<?php echo $_GET['saal_id']; ?>' />
                </td>
                <td>
                   <input id='aufseher_id' name='aufseher_id' type='text' size='20' value='<?php echo $_GET['aufseher_id']; ?>' />
                </td>

	      </tr>
           </tbody>
        </table>
        <input id='submit' type='submit' value='Insert!' />
  </form>
</div>


<?php
  //Handle insert
  if (isset($_GET['saal_id'])) 
  {
    //Prepare insert statementd
    $sql = "INSERT INTO aufsicht VALUES(" . $_GET['saal_id'] . ",'"  . $_GET['aufseher_id'] . "')";
    //Parse and execute statement
    $insert = oci_parse($conn, $sql); 
    oci_execute($insert);
    $conn_err=oci_error($conn);
    $insert_err=oci_error($insert);
    if(!$conn_err & !$insert_err){
	print("Successfully inserted");
 	print("<br>");
    }
    //Print potential errors and warnings
    else{
       print($conn_err);
       print_r($insert_err);
       print("<br>");
    }
    oci_free_statement($insert);
  } 
?>

<div>
  <form id='insertform' action='aufsicht.php' method='get'>
    Bestehende Aufsicht loeschen:
	<table style='border: 1px solid #DDDDDD'>
	  <thead>
	    <tr>
	      <th>Saal-ID</th>
	      <th>Aufseher-ID</th>
	    </tr>
	  </thead>
	  <tbody>
	     <tr>
	        <td>
	           <input id='lsaal_id' name='lsaal_id' type='text' size='10' value='<?php echo $_GET['lsaal_id']; ?>' />
                </td>
                <td>
                   <input id='laufseher_id' name='laufseher_id' type='text' size='20' value='<?php echo $_GET['laufseher_id']; ?>' />
                </td>

	      </tr>
           </tbody>
        </table>
        <input id='submit' type='submit' value='Delete!' />
  </form>
</div>

<?php
  //Handle delete
  if (isset($_GET['lsaal_id'])) 
  {
    //Prepare insert statementd
    $sql = "DELETE FROM aufsicht WHERE saal_id=". $_GET['lsaal_id'] . "AND aufseher_id=" . $_GET['laufseher_id'] ; 
    $insert = oci_parse($conn, $sql); 
    oci_execute($insert);
    $conn_err=oci_error($conn);
    $insert_err=oci_error($insert);
    if(!$conn_err & !$insert_err){
	print("Successfully deleted");
 	print("<br>");
    }
    //Print potential errors and warnings
    else{
       print($conn_err);
       print_r($insert_err);
       print("<br>");
    }
    oci_free_statement($insert);
  } 
?>








<br>
<a href="index.php">Zurueck zur Startseite</a><br>

</body>
</html>
