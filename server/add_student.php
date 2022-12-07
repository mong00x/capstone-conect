<?php 
include_once 'includes.php';
$success=0;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

$data = json_decode(file_get_contents("php://input"), true);
if (!empty($data['name']) && !empty($data['email']) && !empty($data['studentid']) && !empty($data['password_token'])) {
    http_response_code(200);
    echo json_encode(["success"=>0,"msg"=>"No data"]);
}
// $data = json_decode($var);
$password_token= $data['password'];
$name= $data['name'];
$email= $data['student_email'];
$id= $data['student_id'];

$query= "INSERT INTO students (student_id, student_name, student_email, student_password_token) VALUES ('$id','$name', '$email', '$password_token')";
connectDB();
	$result=mysqli_query($_SESSION['db'],$query) or die ("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']));
closeDB();

		$success="1";
		$_SESSION['msg']="User Created";	
		$_SESSION['msgType']="success";
?>
<script type="text/javascript">
	location.replace("https://cduprojects.spinetail.cdu.edu.au/app")
</script>
