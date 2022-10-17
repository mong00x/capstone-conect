<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'includes.php';

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


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

    

    if ( $data['project_ranking'] == 3) 
    { 
        $STUmail = new PHPMailer();
        $STUmail-> isSMTP();
        $STUmail->Host = 'mail.udlcanada.com';
        $STUmail->Port = "587";
        $STUmail->SMTPDebug  = 2;
        $STUmail->SMTPAuth = true;
        $STUmail->SMTPSecure = 'tls';
        $STUmail->Username = 'admin@udlcanada.com';
        $STUmail->Password = 'BrainDrain';

        $STUmail->Subject = 'Application submitted';
        $STUmail->Body = 'Your application has been submitted. Please wait for the lecturer to approve.';
        $STUmail->setFrom('admin@udlcanada.com'); // sender
        $STUmail->addAddress('s342742@students.cdu.edu.au'); // receiver
        if ($STUmail->Send()) {
            echo "Mail sent";
        } else {
            // error
            echo "Error: " . $STUmail->ErrorInfo;
        }
    } else {
        echo "Email to student Not sent" . $data["project_ranking"];
    }

    if($data['project_ranking'] == 1) { 
        $LECmail = new PHPMailer();
        $LECmail-> isSMTP();
        $LECmail->Host = 'mail.udlcanada.com';
        $LECmail->Port = "587";
        $LECmail->SMTPDebug  = 2;
        $LECmail->SMTPAuth = true;
        $LECmail->SMTPSecure = 'tls';
        $LECmail->Username = 'admin@udlcanada.com';
        $LECmail->Password = 'BrainDrain';
        
        // get project TOPIC information 
        $query = "SELECT project_topic FROM projects WHERE project_id = '$project_id'";
        connectDB();
        $result=mysqli_query($_SESSION['db'],$query) or die ("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']) . "Data: " . $data);
        closeDB();
        $row = mysqli_fetch_assoc($result);

        
        $project_topic = $row['project_topic'];
        $lecturer_id = $row['lecturer_id'];
        
        // get student information
        $query = "SELECT student_name, student_id FROM students WHERE student_id = '$student_id'";
        connectDB();
        $result=mysqli_query($_SESSION['db'],$query) or die ("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']) . "Data: " . $data);
        closeDB();
        $row = mysqli_fetch_assoc($result);
       
        $student_name = $row['student_name'];
        
        $student_id = $row['student_id'];


        //get lecturer email
        $query = "SELECT lecturer_email FROM lecturers WHERE lecturer_id = '$lecturer_id'";
        connectDB();
        $result=mysqli_query($_SESSION['db'],$query) or die ("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']) . "Data: " . $data);
        closeDB();
        $row = mysqli_fetch_assoc($result);
       

        $lecturer_email = $row['lecturer_email'];

        $message = file_get_contents("lecturer_email_template.html");
        $message = str_replace("%project_topic%", $project_topic, $message);
        $message = str_replace("%student_name%", $student_name, $message);
        $message = str_replace("%student_id%", $student_id, $message);

        

        $LECmail->Subject = 'New project request';
        $LECmail->isHTML(true);
        $LECmail->msgHTML($message);
        $LECmail->AltBody = 'You have a new project';
        $LECmail->setFrom('admin@udlcanada.com'); // sender
        $LECmail->addAddress('$lecturer_email '); // receiver
        if ($LECmail->Send()) {
            echo " Lecturer Mail sent";
        } else {
            // error
            echo "Error: " . $LECmail->ErrorInfo;
        }
    } else {
        echo "Email to student Not sent" . $data["project_ranking"];
    }


}
