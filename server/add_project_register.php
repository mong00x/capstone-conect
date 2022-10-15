<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'includes.php';

// get data posted 
$data = json_decode(file_get_contents("php://input"), true);

// check if data is not empty
if (!empty($data['name']) && !empty($data['email']) && !empty($data['studentid']) && !empty($data['password_token'])) {
    http_response_code(200);
    echo json_encode(["success"=>0,"msg"=>"No data"]);
} else {
    $success=0;
    $student_id= $data['student_id'];
    $project_id= $data['project_id'];
    $project_ranking= $data['project_ranking'];
    $state= $data['state'];
    $state_changed_time= $data['state_changed_time'];
    $approve= $data['approve'];
    $query = "INSERT INTO student_project_requests (student_id, project_id, project_ranking, state,	state_changed_time, approve) VALUES ( '$student_id', '$project_id', '$project_ranking', '$state', '$state_changed_time', '$approve')";
    connectDB();
    $result=mysqli_query($_SESSION['db'],$query) or die ("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']) . "Data: " . $data);
    closeDB();
    $success="1";
    $_SESSION['msg']="Submission Created";	
    $_SESSION['msgType']="success";
    http_response_code(200);
    echo json_encode(["success"=>1,"msg"=>"Submission Created"]);
}
