
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
    <form id='searchform' action='mitarbeiter.php' method='get'>
      <a href='mitarbeiter.php'>Alle Mitarbeiter</a> ---
      Suche nach Mitarbeiter (Nachname): 
      <input id='search' name='search' type='text' size='20' value='<?php echo $_GET['search']; ?>' />
      <input id='submit' type='submit' value='Los!' />
    </form>
  </div>
<?php
  // check if search view of list view
  if (isset($_GET['search'])) {
    $sql = "SELECT * FROM mitarbeiter WHERE nachname like '%" . $_GET['search'] . "%'";
  } else {
    $sql = "SELECT * FROM mitarbeiter";
  }

  // execute sql statement
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
?>
  <table style='border: 1px solid #DDDDDD'>
    <thead>
      <tr>
        <th>Personal-ID</th>
        <th>Partner-ID</th>
        <th>Vorname </th>
        <th>Nachname</th>
		<th>E-Mail</th>
      </tr>
    </thead>
    <tbody>
<?php
  // fetch rows of the executed sql query
  while ($row = oci_fetch_assoc($stmt)) {
    echo "<tr>";
    echo "<td>" . $row['PERSONAL_ID'] . "</td>";
    echo "<td>" . $row['PARTNER_ID'] . "</td>";
	echo "<td>" . $row['VORNAME'] . "</td>";
    echo "<td>" . $row['NACHNAME'] . "</td>";
	echo "<td>" . $row['EMAIL'] . "</td>";
    echo "</tr>";
  }
?>
    </tbody>
  </table>
<div>Insgesamt <?php echo oci_num_rows($stmt); ?> Mitarbeiter gefunden!</div>
<?php  oci_free_statement($stmt); ?>


<br>
<br>
<br>






<div>
  <form id='searchabt' action='mitarbeiter.php' method='get'>
    Suche Partner von Mitarbeiter (Nachname):
      <input id='mitarbeiter' name='mitarbeiter' type='text' size='20' value='<?php echo $_GET['mitarbeiter']; ?>' />
      <input id='submit' type='submit' value='Aufruf Stored Procedure!' />
  </form>
</div>

<?php
  //Handle Stored Procedure
  if (isset($_GET['mitarbeiter']))
  {
	  //Call Stored Procedure	
	  $mitarbeiter = $_GET['mitarbeiter'];
	  $partner_id='';
	  $sproc = oci_parse($conn, 'begin proc_partner(:p1, :p2); end;');
	  //Bind variables, p1=input (nachname), p2=output (abtnr)
	  oci_bind_by_name($sproc, ':p1', $mitarbeiter);
	  oci_bind_by_name($sproc, ':p2', $partner_id, 20);
	  oci_execute($sproc);
	  $conn_err=oci_error($conn);
	  $proc_err=oci_error($sproc);

	  if(!$conn_err && !$proc_err){
	     echo("<br><b>" . " Partner von " . $mitarbeiter . " hat ID: " . $partner_id . "</b><br>" );  // prints OUT parameter of stored procedure
	  }
	  else{
	     //Print potential errors and warnings
	     print($conn_err);
	     print_r($proc_err);
	  }  
  }

  
  // clean up connections
  // oci_free_statement($sproc);
  oci_close($conn);
?>

<br>
<a href="index.php">Zurueck zur Startseite</a><br>
</body>
</html>
