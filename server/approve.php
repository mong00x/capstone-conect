<?php
require("includes.php");


if (isset($_GET['approve']))
{
	$query = "SELECT *  FROM student_project_requests WHERE project_id=".$_GET['project_id']." AND student_id=".$_GET['student_id'];
	connectDB();
	$result = mysqli_query($_SESSION['db'], $query);
	closeDB();
	$approve_result = mysqli_fetch_assoc($result);
	

	if ($approve_result["approve"] == 0) {
		$query="UPDATE student_project_requests SET approve=1 WHERE project_id=".$_GET['project_id']." AND student_id=".$_GET['student_id'];
		connectDB();
		$result = mysqli_query($_SESSION['db'],$query) or die("<p><b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']) . "</p>");
		closeDB();
		$approve="Approve successful, you can now close this window.";
	}
	else {
		$is_approved = ($approve_result["approve"] == 1) ? "Approved" : "Declined";
		$approve="failed to approve, the application has already been processed.\n" . "Current status: " . $is_approved . "\n" . "Last updated: " . $approve_result["state_changed_time"];
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
			echo $approve 
		?>
	</h1>
</body>
</html>
