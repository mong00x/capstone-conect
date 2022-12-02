<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'includes.php';

$data = json_decode(file_get_contents("php://input"), true);
$name= $data['name'];
$student_password_token= $data['password'];
$student_email= $data['student_email'];
$student_id= $data['student_id'];


$query= "INSERT INTO students (student_id, student_name, student_email, student_password_token) VALUES ('$student_id','$name', '$student_email', '$student_password_token')";
connectDB();
	$result=mysqli_query($_SESSION['db'],$query) or die ("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']));
closeDB();

$success="1";
$_SESSION['msg']="User Created";	
$_SESSION['msgType']="success";
echo json_encode(["success"=>1,"msg"=>"student  added"]);

?>



