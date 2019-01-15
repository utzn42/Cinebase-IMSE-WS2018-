<html>
<header><title>This is title</title></header>
<body>

<?php
session_start();
$_SESSION = array();
header("location:index.php");
?>
Hello world
</body>
</html>



