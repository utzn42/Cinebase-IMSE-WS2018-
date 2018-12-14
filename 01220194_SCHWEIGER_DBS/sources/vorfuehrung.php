
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
    <form id='searchform' action='vorfuehrung.php' method='get'>
      <a href='vorfuehrung.php'>Alle Vorfuehrungen</a> 
	  <br><br>
      Suche nach Vorfuehrung (Titel / Name): 
      <input id='search' name='search' type='text' size='20' value='<?php echo $_GET['search']; ?>' />
      <input id='submit' type='submit' value='Los!' />
    </form>
  </div>  

  <div>
    <form id='searchform' action='vorfuehrung.php' method='get'>
      Suche nach Vorfuehrung (Saal-ID): 
      <input id='search2' name='search2' type='text' size='20' value='<?php echo $_GET['search2']; ?>' />
      <input id='submit' type='submit' value='Los!' />
    </form>
  </div>
  
 
<?php
  // check if search view of list view
  if (isset($_GET['search'])) {
    $sql = "SELECT vorfuehrungs_id, titel,regisseur,land, saal_id, programm_id, to_char(datum, 'Dy DD-Mon-YYYY HH24:MI')as datum FROM film NATURAL JOIN vorfuehrung WHERE titel like '%" . $_GET['search'] . "%'";
  }
  else if (isset($_GET['search2'])) {
    $sql = "SELECT vorfuehrungs_id, titel,regisseur,land, saal_id, programm_id, to_char(datum, 'Dy DD-Mon-YYYY HH24:MI')as datum FROM film NATURAL JOIN vorfuehrung WHERE saal_id like '" . $_GET['search2'] . "'";
  }
  else if (isset($_GET['search3'])) {
    $sql = "SELECT vorfuehrungs_id, titel,regisseur,land, saal_id, programm_id, to_char(datum, 'Dy DD-Mon-YYYY HH24:MI')as datum FROM film NATURAL JOIN vorfuehrung WHERE programm_id like '" . $_GET['search3'] . "'";
  } 
  else if (isset($_GET['search4'])) {
    $sql = "SELECT vorfuehrungs_id, titel,regisseur,land, saal_id, programm_id, to_char(datum, 'Dy DD-Mon-YYYY HH24:MI')as datum FROM film NATURAL JOIN vorfuehrung WHERE vorfuehrungs_id like '" . $_GET['search4'] . "'";
  }
  else {
    $sql = "SELECT vorfuehrungs_id, titel,regisseur,land, saal_id, programm_id, to_char(datum, 'Dy DD-Mon-YYYY HH24:MI')as datum FROM film NATURAL JOIN vorfuehrung";
  }

  // execute sql statement
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
?>
  FILM-VORFUEHRUNGEN:  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Auf Vorfuehrungs-ID klicken, um verkaufte Tickets zu sehen)
  <table style='border: 1px solid #DDDDDD'>
    <thead>
      <tr>
        <th>Vorfuehrungs-ID</th>
		<th>Titel</th>
        <th>Regisseur</th>
		<th>Land</th>
		<th>Programm-ID</th>
        <th>Saal-ID</th>
        <th>Datum</th>
      </tr>
    </thead>
    <tbody>
<?php
  // fetch rows of the executed sql query
  while ($row = oci_fetch_assoc($stmt)) {
    echo "<tr>";
	echo "<td> <a href=\"ticket.php?search2=" . $row['VORFUEHRUNGS_ID'] . "\">" . $row['VORFUEHRUNGS_ID'] . " </a></td>";
    echo "<td>" . $row['TITEL'] . "</td>";
	echo "<td>" . $row['REGISSEUR'] . "</td>";
    echo "<td>" . $row['LAND'] . "</td>";
	echo "<td>" . $row['PROGRAMM_ID'] . "</td>";
	echo "<td>" . $row['SAAL_ID'] . "</td>";
	echo "<td>" . $row['DATUM'] . "</td>";
    echo "</tr>";
  }
?>
    </tbody>
  </table>
<div>Insgesamt <?php echo oci_num_rows($stmt); ?> Film-Vorfuehrung(en) gefunden!</div>
<?php  oci_free_statement($stmt); ?>


<br>
<br>
<br>




<?php
  // check if search view of list view
  if (isset($_GET['search'])) {
    $sql = "SELECT vorfuehrungs_id, typ,name, saal_id, programm_id, to_char(datum, 'Dy DD-Mon-YYYY HH24:MI')as datum FROM sondervorstellung NATURAL JOIN vorfuehrung WHERE name like '%" . $_GET['search'] . "%'";
  } else if (isset($_GET['search2'])) {
    $sql = "SELECT vorfuehrungs_id, typ,name, saal_id, programm_id, to_char(datum, 'Dy DD-Mon-YYYY HH24:MI')as datum FROM sondervorstellung NATURAL JOIN vorfuehrung WHERE saal_id like '" . $_GET['search2'] . "'";
  } else if (isset($_GET['search3'])) {
    $sql = "SELECT vorfuehrungs_id, typ,name, saal_id, programm_id, to_char(datum, 'Dy DD-Mon-YYYY HH24:MI')as datum FROM sondervorstellung NATURAL JOIN vorfuehrung WHERE programm_id like '" . $_GET['search3'] . "'";
  } else if (isset($_GET['search4'])) {
    $sql = "SELECT vorfuehrungs_id, typ,name, saal_id, programm_id, to_char(datum, 'Dy DD-Mon-YYYY HH24:MI')as datum FROM sondervorstellung NATURAL JOIN vorfuehrung WHERE vorfuehrungs_id like '" . $_GET['search4'] . "'";
  }
  else {
    $sql = "SELECT vorfuehrungs_id, typ,name, saal_id, programm_id, to_char(datum, 'Dy DD-Mon-YYYY HH24:MI')as datum FROM sondervorstellung NATURAL JOIN vorfuehrung";
  }

  // execute sql statement
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
?>


  SONDERVORFUEHRUNGEN:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Auf Vorfuehrungs-ID klicken, um verkaufte Tickets zu sehen)
  <table style='border: 1px solid #DDDDDD'>
    <thead>
      <tr>
        <th>Vorfuehrungs-ID</th>
		<th>Typ</th>
        <th>Name</th>
		<th>Programm-ID</th>
        <th>Saal-ID</th>
        <th>Datum</th>
      </tr>
    </thead>
    <tbody>
<?php
  // fetch rows of the executed sql query
  while ($row = oci_fetch_assoc($stmt)) {
    echo "<tr>";
    echo "<td> <a href=\"ticket.php?search2=" . $row['VORFUEHRUNGS_ID'] . "\">" . $row['VORFUEHRUNGS_ID'] . " </a></td>";
    echo "<td>" . $row['TYP'] . "</td>";
	echo "<td>" . $row['NAME'] . "</td>";
	echo "<td>" . $row['PROGRAMM_ID'] . "</td>";
	echo "<td>" . $row['SAAL_ID'] . "</td>";
	echo "<td>" . $row['DATUM'] . "</td>";
    echo "</tr>";
  }
?>
    </tbody>
  </table>
<div>Insgesamt <?php echo oci_num_rows($stmt); ?> Sonder-Vorfuehrung(en) gefunden!</div>
<?php  oci_free_statement($stmt); ?>



<br>
<br>
<br>




<div>
  <form id='insertform' action='vorfuehrung.php' method='get'>
    Neue Vorfuehrung einfuegen:
	<table style='border: 1px solid #DDDDDD'>
	  <thead>
	    <tr>
	      <th>Vorfuehrungs-ID</th>
	      <th>Saal-ID</th>
	      <th>Programm-ID</th>
		  <th>Datum (Format: yyyy/mm/dd hh:mi)</th>
	    </tr>
	  </thead>
	  <tbody>
	     <tr>
	        <td>
	           <input id='vorfuehrungs_id' name='vorfuehrungs_id' type='text' size='10' value='<?php echo $_GET['vorfuehrungs_id']; ?>' />
                </td>
                <td>
                   <input id='saal_id' name='saal_id' type='text' size='20' value='<?php echo $_GET['saal_id']; ?>' />
                </td>
		<td>
		   <input id='programm_id' name='programm_id' type='text' size='20' value='<?php echo $_GET['programm_id']; ?>' />
		</td>
		<td>
		   <input id='datum' name='datum' type='text' size='20' value='<?php echo $_GET['datum']; ?>' />
		</td>
	      </tr>
           </tbody>
        </table>
        <input id='submit' type='submit' value='Insert!' />
  </form>
</div>


<?php
  //Handle insert
  if (isset($_GET['vorfuehrungs_id'])) 
  {
    //Prepare insert statementd
    $sql = "INSERT INTO vorfuehrung VALUES(" . $_GET['vorfuehrungs_id'] . ",'"  . $_GET['saal_id'] . "','" . $_GET['programm_id'] . "', TO_DATE('" . $_GET['datum'] . "','yyyy/mm/dd hh24:mi'))";
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
  <form id='insertform' action='vorfuehrung.php' method='get'>
    Bestehende Vorfuehrung loeschen:
	<table style='border: 1px solid #DDDDDD'>
	  <thead>
	    <tr>
	      <th>Vorfuehrungs-ID</th>
	    </tr>
	  </thead>
	  <tbody>
	     <tr>
	        <td>
	           <input id='loesch_id' name='loesch_id' type='text' size='10' value='<?php echo $_GET['loesch_id']; ?>' />
            </td>
	      </tr>
           </tbody>
        </table>
        <input id='submit' type='submit' value='Delete!' />
  </form>
</div>

<?php
  //Handle delete
  if (isset($_GET['loesch_id'])) 
  {
    //Prepare insert statementd
    $sql = "DELETE FROM vorfuehrung WHERE vorfuehrungs_id=". $_GET['loesch_id']  ;
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
<br>
<br>

<div>
  <form id='searchabt' action='vorfuehrung.php' method='get'>
    Suche Datum von Vorfuehrung (ID):
      <input id='vorf_id' name='vorf_id' type='text' size='20' value='<?php echo $_GET['vorf_id']; ?>' />
      <input id='submit' type='submit' value='Aufruf Stored Procedure!' />
  </form>
</div>

<?php
  //Handle Stored Procedure
  if (isset($_GET['vorf_id']))
  {
	  //Call Stored Procedure	
	  $vorf_id = $_GET['vorf_id'];
	  $datum='';
	  $sproc = oci_parse($conn, 'begin vorf_name(:p1, :p2); end;');
	  //Bind variables, p1=input (nachname), p2=output (abtnr)
	  oci_bind_by_name($sproc, ':p1', $vorf_id);
	  oci_bind_by_name($sproc, ':p2', $datum, 20);
	  oci_execute($sproc);
	  $conn_err=oci_error($conn);
	  $proc_err=oci_error($sproc);

	  if(!$conn_err && !$proc_err){
	     echo("<br><b>" . "Vorfuehrung mit ID ". $vorf_id . " findet statt am " . $datum . "</b><br>" );  // prints OUT parameter of stored procedure
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
