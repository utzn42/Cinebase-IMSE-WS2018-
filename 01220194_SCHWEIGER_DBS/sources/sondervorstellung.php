
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
    <form id='searchform' action='sondervorstellung.php' method='get'>
      <a href='sondervorstellung.php'>Alle Sondervorstellungen</a> ---
      Suche nach Name: 
      <input id='search' name='search' type='text' size='20' value='<?php echo $_GET['search']; ?>' />
      <input id='submit' type='submit' value='Los!' />
    </form>
  </div>
<?php
  // check if search view of list view
  if (isset($_GET['search'])) {
    $sql = "SELECT * FROM sondervorstellung NATURAL JOIN programm WHERE name like '%" . $_GET['search'] . "%'";
  } else {
    $sql = "SELECT * FROM sondervorstellung NATURAL JOIN programm";
  }

  // execute sql statement
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
?>
SONDERVORSTELLUNGEN:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Auf Namen klicken, um Vorfuehrungen zu sehen)
  <table style='border: 1px solid #DDDDDD'>
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Typ</th>
		<th>Sprache</th>
		<th>Altersfreigabe</th>
      </tr>
    </thead>
    <tbody>
<?php
  // fetch rows of the executed sql query
  while ($row = oci_fetch_assoc($stmt)) {
    echo "<tr>";
    echo "<td>" . $row['PROGRAMM_ID'] . "</td>";
	echo "<td><a href=\"vorfuehrung.php?search3=" . $row['PROGRAMM_ID'] . "\">" . $row['NAME'] . "</a></td>";
	echo "<td>" . $row['TYP'] . "</td>";
	echo "<td>" . $row['SPRACHE'] . "</td>";
	echo "<td>" . $row['ALTERSFREIGABE'] . "</td>";
    echo "</tr>";
  }
?>
    </tbody>
  </table>
<div>Insgesamt <?php echo oci_num_rows($stmt); ?> Sondervorstellung(en) gefunden!</div>
<?php  oci_free_statement($stmt); ?>

<br>
<br>
<br>

<div>
  <form id='insertform' action='sondervorstellung.php' method='get'>
    Neue Sondervorstellung einfuegen:
	<table style='border: 1px solid #DDDDDD'>
	  <thead>
	    <tr>
	      <th>Programm-ID</th>
	      <th>Name</th>
	      <th>Typ</th>
		  <th>Sprache</th>
		  <th>Altersfreigabe</th>
	    </tr>
	  </thead>
	  <tbody>
	     <tr>
	        <td>
	           <input id='programm_id' name='programm_id' type='text' size='10' value='<?php echo $_GET['programm_id']; ?>' />
            </td>
            <td>
               <input id='name' name='name' type='text' size='20' value='<?php echo $_GET['name']; ?>' />
            </td>
		    <td>
		       <input id='typ' name='typ' type='text' size='20' value='<?php echo $_GET['typ']; ?>' />
		    </td>
		    <td>  
		       <input id='sprache' name='sprache' type='text' size='20' value='<?php echo $_GET['sprache']; ?>' />
		    </td>
		    <td>
		       <input id='altersfreigabe' name='altersfreigabe' type='text' size='20' value='<?php echo $_GET['altersfreigabe']; ?>' />
		    </td>			
	     </tr>
      </tbody>
        </table>
        <input id='submit' type='submit' value='Insert!' />
  </form>
</div>


<?php
  //Handle insert
  if (isset($_GET['programm_id'])) 
  {
    //Prepare insert statementd
//Prepare insert statementd
	$sql0 = "INSERT INTO programm VALUES(" . $_GET['programm_id'] . ",'"  . $_GET['sprache'] . "','" . $_GET['altersfreigabe'] .  "')";
    $sql = "INSERT INTO sondervorstellung VALUES(" . $_GET['programm_id'] . ",'"  . $_GET['typ'] . "','" . $_GET['name'] . "')";
    //Parse and execute statement
	
	$insert0 = oci_parse($conn, $sql0);
    oci_execute($insert0);
    $conn_err0=oci_error($conn);
    $insert_err0=oci_error($insert0);
	
	
	
    $insert = oci_parse($conn, $sql);
    oci_execute($insert);
    $conn_err=oci_error($conn);
    $insert_err=oci_error($insert);
	
	
	
    if(!$conn_err & !$insert_err & !$conn_err0 & !$insert_err0){
	print("Successfully inserted");
 	print("<br>");
    }
    //Print potential errors and warnings
    else{
       print($conn_err);
       print_r($insert_err);
       print("<br>");
    }
	oci_free_statement($insert0);
    oci_free_statement($insert);
  } 
?>
<br>
<br>
<br>

<div>
  <form id='searchabt' action='sondervorstellung.php' method='get'>
    Suche Altersfreigabe von Sondervorstellung (Name):
      <input id='sondervorstellung' name='sondervorstellung' type='text' size='20' value='<?php echo $_GET['sondervorstellung']; ?>' />
      <input id='submit' type='submit' value='Aufruf Stored Procedure!' />
  </form>
</div>

<?php
  //Handle Stored Procedure
  if (isset($_GET['sondervorstellung']))
  {
	  //Call Stored Procedure	
	  $sondervorstellung = $_GET['sondervorstellung'];
	  $altersfreigabe='';
	  $sproc = oci_parse($conn, 'begin proc_alter_sonder(:p1, :p2); end;');
	  //Bind variables, p1=input (nachname), p2=output (abtnr)
	  oci_bind_by_name($sproc, ':p1', $sondervorstellung);
	  oci_bind_by_name($sproc, ':p2', $altersfreigabe, 20);
	  oci_execute($sproc);
	  $conn_err=oci_error($conn);
	  $proc_err=oci_error($sproc);

	  if(!$conn_err && !$proc_err){
	     echo("<br><b>" . $sondervorstellung . " hat die Altersfreigabe: " . $altersfreigabe . "</b><br>" );  // prints OUT parameter of stored procedure
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
