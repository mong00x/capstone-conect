<?php
require("includes.php");


if (isset($_GET['decline'])) // 
{
	$query = "SELECT *  FROM student_project_requests WHERE project_id=".$_GET['project_id']." AND student_id=".$_GET['student_id'];
	connectDB();
	$result = mysqli_query($_SESSION['db'], $query);
	closeDB();
	$approve_result = mysqli_fetch_assoc($result);
	if ($approve_result["approve"] == 0 ) {
		$query="UPDATE student_project_requests SET approve=2 WHERE project_id=".$_GET['project_id']." AND student_id=".$_GET['student_id'];
		connectDB();
		$result = mysqli_query($_SESSION['db'],$query) or die("<p><b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']) . "</p>");
		closeDB();
		$decline="Declined successful, you can now close this window.";
	}
	else {
		$is_declined = ($approve_result["approve"] == 1) ? "Approved" : "Declined";
		$decline="Failed to decline, the application has already been processed.\n". "Current status: " . $is_declined ."\n" . "Last updated: " . $approve_result["state_changed_time"];
	}


}

?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>HIT401</title>
</head>

<body>
	<h1>
		<?php
			echo $decline 
		?>
	</h1>
	
</body>
</html>
