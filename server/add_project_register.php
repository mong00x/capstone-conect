<?php
date_default_timezone_set('Australia/Darwin');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'includes.php';

require_once 'PHPMailer/PHPMailer.php';
require_once 'PHPMailer/SMTP.php';
require_once 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


// get data posted 
$data = json_decode(file_get_contents("php://input"), true);
$mail = new PHPMailer();


// check if data is not empty
if (!empty($data['name']) && !empty($data['email']) && !empty($data['studentid']) && !empty($data['password_token'])) {
    http_response_code(200);
    echo json_encode(["success"=>0,"msg"=>"No data"]);
} else {
    $success=0;
    $student_id= $data['student_id'];
    $project_id= $data['project_id'];
    $project_ranking= $data['project_ranking'];
    $state_changed_time= date("Y-m-d H:i:s");    
    $approve= $data['approve'];
    $query = "INSERT INTO student_project_requests (student_id, project_id, project_ranking, state_changed_time, approve) VALUES ( '$student_id', '$project_id', '$project_ranking', '$state_changed_time', '$approve')";
    connectDB();
    $result=mysqli_query($_SESSION['db'],$query) or die ("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']) . "Data: " . $data);
    closeDB();
    $success="1";
    $_SESSION['msg']="Submission Created";	
    $_SESSION['msgType']="success";
    http_response_code(200);
    echo json_encode(["success"=>1,"msg"=>"Submission Created"]);
    


    if($data['project_ranking'] == 1) { 
        // $mail = new PHPMailer();
        $mail-> isSMTP();
        $mail->Host = 'mail.cduprojects.spinetail.cdu.edu.au';
        $mail->Port = "587";
        $mail->SMTPDebug  = 2;
        $mail->SMTPAuth = true;
        // $mail->SMTPSecure = 'tls';
        $mail->Username = 'no-reply@cduprojects.spinetail.cdu.edu.au';
        $mail->Password = 'pRsdKrr8DeHwTY3';
        
        // get project TOPIC information 
        $query = "SELECT project_topic,lecturer_id FROM projects WHERE project_id = '$project_id'";
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

        
        $accept_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/approve.php?approve=$project_id&student_id=$student_id";
        $decline_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/decline.php?decline=$project_id&student_id=$student_id";
        $message = str_replace("%accept%", $accept_url, $message);
        $message = str_replace("%decline%", $decline_url, $message);

        

        $mail->Subject = 'New project request';
        $mail->isHTML(true);
        $mail->msgHTML($message);
        $mail->AltBody = 'You have a new project';
        $mail->setFrom('no-reply@cduprojects.spinetail.cdu.edu.au'); // sender
        $mail->addAddress($lecturer_email); // receiver
        if ($mail->Send()) {
            echo " Lecturer Mail sent\n";
        } else {
            // error
            echo "Error: " . $mail->ErrorInfo;
        }
    } else {
        echo "Email to Lecturer Not sent" . $data["project_ranking"]."\n";
    }

    if ( $data['project_ranking'] == 3)  
    { 
        echo "hi";

        // get student email 
        $query = "SELECT student_email, student_name FROM students WHERE student_id = '$student_id'";
        connectDB();
        $result=mysqli_query($_SESSION['db'],$query) or die ("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']) . "Data: " . $data);
        closeDB();

        $row = mysqli_fetch_assoc($result);

        $student_email = $row['student_email'];
        $student_name =  $row['student_name'];

        $mail-> isSMTP();
        $mail->Host = 'mail.cduprojects.spinetail.cdu.edu.au';
        $mail->Port = "587";
        $mail->SMTPDebug  = 2;
        $mail->SMTPAuth = true;
        // $mail->SMTPSecure = 'tls';
        $mail->Username = 'no-reply@cduprojects.spinetail.cdu.edu.au';
        $mail->Password = 'pRsdKrr8DeHwTY3';

        
        connectDB();
        $result = mysqli_query($_SESSION['db'], "SELECT project_id FROM student_project_requests where student_id = '$student_id' ORDER BY  project_ranking ASC");
        closeDB();
        $project_ids = array();

        while($row = mysqli_fetch_assoc($result)) {
        array_push($project_ids,$row['project_id']);
        }
        
        $project_topics = array();
        for($i=0;$i<count($project_ids);$i++){
            connectDB();
            $result = mysqli_query($_SESSION['db'], "SELECT project_topic FROM projects where project_id = '$project_ids[$i]'");
            closeDB();
            $row = mysqli_fetch_assoc($result);
            array_push($project_topics,$row['project_topic']);
            }
        
 
        $message_std = file_get_contents("student_email_template.html");
        $message_std= str_replace("%project_topic1%", $project_topics[0], $message_std);
        $message_std= str_replace("%project_topic2%", $project_topics[1], $message_std);
        $message_std= str_replace("%project_topic3%", $project_topics[2], $message_std);
        $message_std= str_replace("%student_name%", $student_name, $message_std);
        $message_std= str_replace("%student_id%", $student_id, $message_std);

        $mail->Subject = 'Application submited';
        $mail->isHTML(true);
        $mail->msgHTML($message_std);
        $mail->AltBody = 'Your application has been submitted. Please wait for the lecturer to approve.';
        $mail->setFrom('no-reply@cduprojects.spinetail.cdu.edu.au'); // sender
        $mail->addAddress($student_email); // receiver
        if ($mail->Send()) {
            echo "Student Mail sent\n";
        } else {
            // error
            echo "Error: " . $mail->ErrorInfo;
        }
        
           
    }
    


}
