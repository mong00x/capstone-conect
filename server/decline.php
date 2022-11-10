<?php
require("includes.php");

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


if (isset($_GET['decline']))
{
    $query_check_request = "SELECT student_name, approve, project_ranking FROM student_project_requests JOIN students ON student_project_requests.student_id = students.student_id WHERE student_project_requests.project_id=".$_GET['decline']." AND students.student_id=".$_GET['student_id'];
	connectDB();
	$result_check_request = mysqli_query($_SESSION['db'],$query_check_request) or die("<p><b>A fatal MySQL error occured</b>.\n<br />Query: " . $query_check_request . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']) . "</p>");
	closeDB();
	$row_check_request = mysqli_fetch_assoc($result_check_request);
	$check_request = $row_check_request['approve'];
	$project_ranking = $row_check_request['project_ranking'];
	$student_name = $row_check_request['student_name'];
	
	if ($check_request != 0) {
		echo "This project request has either been already been processed or it is now invalid.";
	}
	else {        
		if ($project_ranking < 3) {
			// Get the lecturer email and project name of the next ranking project request
			$query_project_lecturer = "SELECT lecturers.lecturer_email, projects.project_topic, projects.project_id FROM `student_project_requests`
			JOIN projects ON student_project_requests.project_id = projects.project_id
			JOIN lecturers ON projects.lecturer_id = lecturers.lecturer_id
			WHERE student_id = ".$_GET['student_id']."
			AND project_ranking = ($project_ranking + 1)";
			connectDB();
			$result_lecturer_email = mysqli_query($_SESSION['db'], $query_project_lecturer);
			closeDB();
			$row_lecturer_email = mysqli_fetch_assoc($result_lecturer_email);
			$lecturer_email = $row_lecturer_email['lecturer_email'];
			$project_topic = $row_lecturer_email['project_topic'];
			$project_id = $row_lecturer_email['project_id'];
	
			// Sending the email to lecturer about new project request
			$LECmail = new PHPMailer();
			$LECmail-> isSMTP();

			// Localhost Mail Settings
			$LECmail->Host = 'mail.udlcanada.com';
			$LECmail->Port = "587";
			$LECmail->SMTPDebug  = 2;
			$LECmail->SMTPAuth = true;
			$LECmail->SMTPSecure = 'tls';
			$LECmail->Username = 'admin@udlcanada.com';
			$LECmail->Password = 'BrainDrain';
			$LECmail->setFrom('admin@udlcanada.com'); // sender
	
			// Spinetail Mail Settings
			// $LECmail->Host = 'mail.cduprojects.spinetail.cdu.edu.au';
			// $LECmail->Port = "587";
			// $LECmail->SMTPAuth = true;
			// $LECmail->SMTPSecure = 'tls';
			// $LECmail->Username = 'no-reply@cduprojects.spinetail.cdu.edu.au';
			// $LECmail->Password = 'pRsdKrr8DeHwTY3';
			// $LECmail->setFrom('no-reply@cduprojects.spinetail.cdu.edu.au'); // sender	
			
			$message = file_get_contents("lecturer_email_template.html");
			$message = str_replace("%project_topic%", $project_topic, $message);
			$message = str_replace("%student_name%", $student_name, $message);
			$message = str_replace("%student_id%", $_GET['student_id'], $message);
			
	        $accept_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/approve.php?approve=$project_id&student_id=".$_GET['student_id']."";
            $decline_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/decline.php?decline=$project_id&student_id=".$_GET['student_id']."";
            $message = str_replace("%accept%", $accept_url, $message);
            $message = str_replace("%decline%", $decline_url, $message);
	
			$LECmail->Subject = 'New project request';
			$LECmail->isHTML(true);
			$LECmail->Body = $message;
			$LECmail->AltBody = $message;
			$LECmail->addAddress($lecturer_email); // receiver
			if ($LECmail->Send()) {
                $query_update_decline = "UPDATE student_project_requests SET approve = '2', state_changed_time = current_timestamp WHERE project_ranking = $project_ranking AND project_id=".$_GET['decline']." AND student_id=".$_GET['student_id'];
				connectDB();
				mysqli_query($_SESSION['db'], $query_update_decline);
				closeDB();
				// Set the next project request to initial and update the state changed time to current time
				$query_update_pending = "UPDATE student_project_requests SET approve = '0', state_changed_time = current_timestamp WHERE project_ranking = ($project_ranking + 1) AND student_id=".$_GET['student_id'];
				connectDB();
				mysqli_query($_SESSION['db'], $query_update_pending);
				closeDB();
				echo "The project request has been declined.";
			} else {
				// Lecturer email error
				echo "Error: " . $LECmail->ErrorInfo;
			}
	
		}
	
		if ($project_ranking = 3) {
			$query_update_decline = "UPDATE student_project_requests SET approve = '2', state_changed_time = current_timestamp WHERE project_ranking = $project_ranking AND project_id=".$_GET['decline']." AND student_id=".$_GET['student_id'];
			connectDB();
			mysqli_query($_SESSION['db'], $query_update_decline);
			closeDB();
		}

	}
}
