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
	
	$query="UPDATE student_project_requests SET approve=1 WHERE project_id=".$_GET['project_id']." AND student_id=".$_GET['student_id'];
	connectDB();
	$result = mysqli_query($_SESSION['db'],$query) or die("<p><b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']) . "</p>");
	closeDB();
	
	$query_student_email="SELECT student_email FROM students WHERE student_id=".$_GET['student_id'];
	connectDB();
	$result_student_email = mysqli_query($_SESSION['db'],$query_student_email) or die("<p><b>A fatal MySQL error occured</b>.\n<br />Query: " . $query_student_email . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']) . "</p>");
	closeDB();
	$row_student_email = mysqli_fetch_assoc($result_student_email);
	$student_email = $row_student_email['student_email'];
	
}
    $mail = new PHPMailer();
    $mail-> isSMTP();
    $mail->Host = 'mail.cduprojects.spinetail.cdu.edu.au';
    $mail->Port = "587";
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Username = 'no-reply@cduprojects.spinetail.cdu.edu.au';
    $mail->Password = 'pRsdKrr8DeHwTY3';

    //Recipients
    $mail->setFrom('no-reply@cduprojects.spinetail.cdu.edu.au');
    $mail->addAddress($student_email);     //Add a recipient
    
    //Content
    $mail->isHTML(true); //Set email format to HTML
    $mail->Subject = 'Your registered project is approved!';
    $mail->Body = 'Your registered project is approved!';
    $mail->AltBody = 'Your registered project is approved!';

    if ($mail->Send()) {
        echo 'Message has been sent';
    }
    else {
        echo "Error: " . $mail->ErrorInfo;
    }
?>

