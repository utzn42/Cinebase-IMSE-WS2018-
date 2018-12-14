
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
    <form id='searchform' action='ticket.php' method='get'>
      <a href='ticket.php'>Alle Tickets</a> 
	  <br><br>
      Suche nach Ticket (Ticket-ID): 
      <input id='search' name='search' type='text' size='20' value='<?php echo $_GET['search']; ?>' />
      <input id='submit' type='submit' value='Los!' />
    </form>
  </div>
    <div>
    <form id='searchform' action='ticket.php' method='get'>
      Suche nach Ticket (Vorfuehrungs-ID): 
      <input id='search2' name='search2' type='text' size='20' value='<?php echo $_GET['search2']; ?>' />
      <input id='submit' type='submit' value='Los!' />
    </form>
  </div>
<?php
  // check if search view of list view
  if (isset($_GET['search'])) {
    $sql = "SELECT ticket_id, vorfuehrungs_id, titel, preis, ermaessigung FROM ticket NATURAL JOIN vorfuehrung NATURAL JOIN film WHERE ticket_id like '" . $_GET['search'] . "'";
  } else if (isset($_GET['search2'])) {
    $sql = "SELECT ticket_id, vorfuehrungs_id, titel, preis, ermaessigung FROM ticket NATURAL JOIN vorfuehrung NATURAL JOIN film WHERE vorfuehrungs_id like '" . $_GET['search2'] . "'";
  }
	else {
    $sql = "SELECT ticket_id, vorfuehrungs_id, titel, preis, ermaessigung FROM ticket NATURAL JOIN vorfuehrung NATURAL JOIN film";
  }

  // execute sql statement
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
?>
<br>
FILM-TICKETS:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Auf Vorfuehrungs-ID klicken, um Details der Vorfuehrung zu sehen)
  <table style='border: 1px solid #DDDDDD'>
    <thead>
      <tr>
        <th>ID</th>
        <th>Vorfuehrungs-ID</th>
		<th>Film-Titel</th>
        <th>Preis</th>
        <th>Ermaessigung</th>
      </tr>
    </thead>
    <tbody>
<?php
  // fetch rows of the executed sql query
  while ($row = oci_fetch_assoc($stmt)) {
    echo "<tr>";
    echo "<td>" . $row['TICKET_ID'] . "</td>";
	echo "<td> <a href=\"vorfuehrung.php?search4=" . $row['VORFUEHRUNGS_ID'] . "\">" . $row['VORFUEHRUNGS_ID'] . " </a></td>";
	echo "<td>" . $row['TITEL'] . "</td>";
	echo "<td>" . $row['PREIS'] . "</td>";
    echo "<td>" . $row['ERMAESSIGUNG'] . "</td>";
    echo "</tr>";
  }
?>
    </tbody>
  </table>
<div>Insgesamt <?php echo oci_num_rows($stmt); ?> Ticket(s) gefunden!</div>
<?php  oci_free_statement($stmt); ?>


<br>
<br>
<br>


<?php
  // check if search view of list view
  if (isset($_GET['search'])) {
    $sql = "SELECT ticket_id, vorfuehrungs_id, name, preis, ermaessigung FROM ticket NATURAL JOIN vorfuehrung NATURAL JOIN sondervorstellung WHERE ticket_id like '" . $_GET['search'] . "'";
  } else if (isset($_GET['search2'])) {
    $sql = "SELECT ticket_id, vorfuehrungs_id, name, preis, ermaessigung FROM ticket NATURAL JOIN vorfuehrung NATURAL JOIN sondervorstellung WHERE vorfuehrungs_id like '" . $_GET['search2'] . "'";
  }
  else {
    $sql = "SELECT ticket_id, vorfuehrungs_id, name, preis, ermaessigung FROM ticket NATURAL JOIN vorfuehrung NATURAL JOIN sondervorstellung";
  }

  // execute sql statement
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
?>

SONDERVORSTELLUNG-TICKETS:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Auf Vorfuehrungs-ID klicken, um Details der Vorfuehrung zu sehen)
  <table style='border: 1px solid #DDDDDD'>
    <thead>
      <tr>
        <th>ID</th>
        <th>Vorfuehrungs-ID</th>
		<th>Sondervorstellung-Name</th>
        <th>Preis</th>
        <th>Ermaessigung</th>
      </tr>
    </thead>
    <tbody>
<?php
  // fetch rows of the executed sql query
  while ($row = oci_fetch_assoc($stmt)) {
    echo "<tr>";
    echo "<td>" . $row['TICKET_ID'] . "</td>";
    echo "<td> <a href=\"vorfuehrung.php?search4=" . $row['VORFUEHRUNGS_ID'] . "\">" . $row['VORFUEHRUNGS_ID'] . " </a></td>";
	echo "<td>" . $row['NAME'] . "</td>";
	echo "<td>" . $row['PREIS'] . "</td>";
    echo "<td>" . $row['ERMAESSIGUNG'] . "</td>";
    echo "</tr>";
  }
?>
    </tbody>
  </table>
<div>Insgesamt <?php echo oci_num_rows($stmt); ?> Ticket(s) gefunden!</div>
<?php  oci_free_statement($stmt); ?>

<br>
<br>
<br>


<div>
  <form id='insertform' action='ticket.php' method='get'>
    Neues Ticket einfuegen:
	<table style='border: 1px solid #DDDDDD'>
	  <thead>
	    <tr>
        <th>ID</th>
        <th>Vorfuehrungs-ID</th>
        <th>Preis</th>
        <th>Ermaessigung</th>  
	    </tr>
	  </thead>
	  <tbody>
	     <tr>
	        <td>
	           <input id='ticket_id' name='ticket_id' type='text' size='10' value='<?php echo $_GET['ticket_id']; ?>' />
                </td>
                <td>
                   <input id='vorfuehrungs_id' name='vorfuehrungs_id' type='text' size='20' value='<?php echo $_GET['vorfuehrungs_id']; ?>' />
                </td>
		<td>
		   <input id='preis' name='preis' type='text' size='20' value='<?php echo $_GET['preis']; ?>' />
		</td>
		<td>
		   <input id='ermaessigung' name='ermaessigung' type='text' size='20' value='<?php echo $_GET['ermaessigung']; ?>' />
		</td>
	      </tr>
           </tbody>
        </table>
        <input id='submit' type='submit' value='Insert!' />
  </form>
</div>


<?php
  //Handle insert
  if (isset($_GET['ticket_id'])) 
  {
    //Prepare insert statementd
    $sql = "INSERT INTO ticket VALUES(" . $_GET['ticket_id'] . ",'"  . $_GET['vorfuehrungs_id'] . "','" . $_GET['preis'] . "','" . $_GET['ermaessigung'] . "')";
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
	   print($conn_err0);
       print_r($insert_err0);
       print("<br>");
    }
	oci_free_statement($insert);
  } 
?>





<br>
<a href="index.php">Zurueck zur Startseite</a><br>

</body>
</html>
