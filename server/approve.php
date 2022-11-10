<?php
require("includes.php");

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


if (isset($_GET['approve']))
{
    $query_check_request = "SELECT approve FROM student_project_requests WHERE project_id=".$_GET['approve']." AND student_id=".$_GET['student_id'];
	connectDB();
	$result_check_request = mysqli_query($_SESSION['db'],$query_check_request) or die("<p><b>A fatal MySQL error occured</b>.\n<br />Query: " . $query_check_request . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']) . "</p>");
	closeDB();
	$row_check_request = mysqli_fetch_assoc($result_check_request);
	$check_request = $row_check_request['approve'];
	if ($check_request != 0) {
		echo "This project request has either been already been processed or it is now invalid.";
	}
	else {
        $query="UPDATE student_project_requests SET approve=1 WHERE project_id=".$_GET['approve']." AND student_id=".$_GET['student_id'];
        connectDB();
        $result = mysqli_query($_SESSION['db'],$query) or die("<p><b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']) . "</p>");
        closeDB();
        
        $query_student_email="SELECT student_email FROM students WHERE student_id=".$_GET['student_id'];
        connectDB();
        $result_student_email = mysqli_query($_SESSION['db'],$query_student_email) or die("<p><b>A fatal MySQL error occured</b>.\n<br />Query: " . $query_student_email . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']) . "</p>");
        closeDB();
        $row_student_email = mysqli_fetch_assoc($result_student_email);
        $student_email = $row_student_email['student_email'];
        
        $query_project_info = "SELECT lecturers.lecturer_email, projects.project_topic FROM `student_project_requests`
        JOIN projects ON student_project_requests.project_id = projects.project_id
        JOIN lecturers ON projects.lecturer_id = lecturers.lecturer_id
        WHERE project_id=".$_GET['approve'].;
        connectDB();
        $result_project_info = mysqli_query($_SESSION['db'], $query_project_info);
        closeDB();
        $row_project_info = mysqli_fetch_assoc($result_project_info);
        $lecturer_email = $row_project_info['lecturer_email'];
        $project_topic = $row_project_info['project_topic'];

        $mail = new PHPMailer();
        $mail-> isSMTP();

        // Localhost Mail Settings
        $mail->Host = 'mail.udlcanada.com';
        $mail->Port = "587";
        $mail->SMTPDebug  = 2;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Username = 'admin@udlcanada.com';
        $mail->Password = 'BrainDrain';

        // Spinetail Mail Settings
        // $mail->Host = 'mail.cduprojects.spinetail.cdu.edu.au';
        // $mail->Port = "587";
        // $mail->SMTPAuth = true;
        // $mail->SMTPSecure = 'tls';
        // $mail->Username = 'no-reply@cduprojects.spinetail.cdu.edu.au';
        // $mail->Password = 'pRsdKrr8DeHwTY3';
        // $mail->setFrom('no-reply@cduprojects.spinetail.cdu.edu.au');

        //Recipients
        $mail->setFrom('admin@udlcanada.com'); // sender
        $mail->addAddress($student_email);     //Add a recipient
        
        $message = file_get_contents("student_approve_template.html");
        $message = str_replace("%project_topic%", $project_topic, $message);
        $message = str_replace("%lecturer_email%", $lecturer_email, $message);

        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = 'HIT401 Capstone Project: Your registered project is approved';
        $mail->Body = $message;
        $mail->AltBody = $message;

        if ($mail->Send()) {
            echo 'The project request has been approved and an email message has been sent to the student.';
        }
        else {
            echo "Error: " . $mail->ErrorInfo;
        }
	}
}

?>

