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

        
        $accept_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/approve.php?approve=1&student_id=$student_id&project_id=$project_id";
        $decline_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/decline.php?decline=1&student_id=$student_id&project_id=$project_id";
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

        // get student email 
        $query = "SELECT student_email FROM students WHERE student_id = '$student_id'";
        connectDB();
        $result=mysqli_query($_SESSION['db'],$query) or die ("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']) . "Data: " . $data);
        closeDB();

        $row = mysqli_fetch_assoc($result);

        $student_email = $row['student_email'];

        $mail-> isSMTP();
        $mail->Host = 'mail.cduprojects.spinetail.cdu.edu.au';
        $mail->Port = "587";
        $mail->SMTPDebug  = 2;
        $mail->SMTPAuth = true;
        // $mail->SMTPSecure = 'tls';
        $mail->Username = 'no-reply@cduprojects.spinetail.cdu.edu.au';
        $mail->Password = 'pRsdKrr8DeHwTY3';

        $mail->Subject = 'Application submitted';
        $mail->Body = 'Your application has been submitted. Please wait for the lecturer to approve.';
        $mail->setFrom('no-reply@cduprojects.spinetail.cdu.edu.au'); // sender
        $mail->addAddress($student_email); // receiver
        if ($mail->Send()) {
            echo "Student Mail sent\n";
        } else {
            // error
            echo "Error: " . $mail->ErrorInfo;
        }
        
           
    } else {
        echo "Email to student Not sent" . $data["project_ranking"]."\n";
    }


}

$mail = new PHPMailer();
$mail-> isSMTP();
$mail->Host = 'mail.cduprojects.spinetail.cdu.edu.au';
$mail->Port = "587";
$mail->SMTPDebug  = 2;
$mail->SMTPAuth = true;
// $mail->SMTPSecure = 'ssl';
$mail->Username = 'no-reply@cduprojects.spinetail.cdu.edu.au';
$mail->Password = 'pRsdKrr8DeHwTY3';
$mail->Subject = 'Test email';
$mail->Body = 'This is a test email';
$mail->setFrom('no-reply@cduprojects.spinetail.cdu.edu.au'); // sender
$mail->addAddress('s342742@students.cdu.edu.au'); // receiver