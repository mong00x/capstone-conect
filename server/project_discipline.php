<?php
header("Access-Control-Allow-Origin: *"); // 
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'includes.php';


$query = "SELECT projects.project_id, discipline.discipline_code FROM discipline_project_mapping JOIN projects ON discipline_project_mapping.project_id = projects.project_id JOIN discipline ON discipline_project_mapping.discipline_id = discipline.discipline_id ORDER BY projects.project_id ASC;";
connectDB();
$result = mysqli_query($_SESSION['db'], $query);
closeDB();
if (mysqli_num_rows($result) > 0) {
    $all_project_discipline_mapping = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode(["success" => 1, "projects discipline mapping" => $all_project_discipline_mapping]);
} else {
    echo json_encode(["success" => 0, "msg" => "No project discipline mapping found"]);
}
