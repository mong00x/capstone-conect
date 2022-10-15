
<?php 
include_once 'includes.php';
$success=0;
$var=$_GET["data"];
$jo = json_decode($var);
$pro_id= $jo->project_id;
$pro_rank= $jo->project_ranking;
$id= $jo->studentid;


$query= "INSERT INTO `projects-register` (`project_reg_id`, `project_id`, `student_id`, `enrolment_date`, `priority`) VALUES (NULL, '$pro_id', '$id', '', '$pro_rank');";
connectDB();
	$result=mysqli_query($_SESSION['db'],$query) or die ("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']));
closeDB();

		$success="1";
		$_SESSION['msg']="User Created";	
		$_SESSION['msgType']="success";

project register added
?>