<?php
include '../db/connect.php';
$question = $_POST['quest'];

//$sql = "SELECT * FROM questions WHERE question LIKE '$question%'";	// uncomment this if search start from left to right
$sql = "SELECT * FROM questions WHERE question LIKE '%$question%'";
$result = mysql_query($sql) or die(mysql_error());
while($row = mysql_fetch_array($result))
{
		echo "<font color='red'>" . $row[1] . "</font><br>";
}
return;
?>