<?php 
include_once 'includes.php';
$success=0;


$var=$_GET["x"];
$jo = json_decode($var);
$password_token= $jo->password_token;
$name= $jo->name;
$email= $jo->email;
$id= $jo->studentid;


$query= "INSERT INTO students (student_id, student_name, student_email, student_password_token) VALUES ('$id','$name', '$email', '$password_token')";
connectDB();
	$result=mysqli_query($_SESSION['db'],$query) or die ("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']));
closeDB();

		$success="1";
		$_SESSION['msg']="User Created";	
		$_SESSION['msgType']="success";
				

?>
<script type="text/javascript">
	location.replace("http://127.0.0.1:5173/app")
</script>
