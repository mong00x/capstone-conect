<?php
require("includes.php");


if (isset($_GET['decline']))
{
	
	$query="UPDATE student_project_requests SET approve=2 WHERE project_id=".$_GET['decline']." AND student_id=".$_GET['student_id'];
	connectDB();
		$result = mysqli_query($_SESSION['db'],$query) or die("<p><b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']) . "</p>");
		closeDB();
	
}

?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>HIT401</title>
</head>

<body>
	<h1>The student register has been declined !</h1>
</body>
</html>
