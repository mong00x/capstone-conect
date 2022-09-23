<?php
header("Access-Control-Allow-Origin: *"); // 
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'includes.php';


$query = "SELECT * FROM projects ORDER BY project_id ASC";
connectDB();
$result = mysqli_query($_SESSION['db'], $query);
closeDB();
if (mysqli_num_rows($result) > 0) {
    $all_projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode(["success" => 1, "projects" => $all_projects]);
} else {
    echo json_encode(["success" => 0, "msg" => "No projects found"]);
}
