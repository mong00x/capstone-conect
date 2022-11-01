<?php

include_once 'includes.php';

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Get the projects that are over the expiration duration 
$query_expired_project_requests = "SELECT student_project_requests.student_id, student_name, project_id, project_ranking, state, state_changed_time FROM student_project_requests
JOIN students ON student_project_requests.student_id = students.student_id
WHERE state_changed_time < current_timestamp - interval 1 minute AND state = 'initial'";
connectDB();
$result_expired_project_requests = mysqli_query($_SESSION['db'], $query_expired_project_requests);
closeDB();
if (mysqli_num_rows($result_expired_project_requests) > 0) {
    // Set the project request to declined
    $row_expired_project_requests = mysqli_fetch_assoc($result_expired_project_requests);
    $student_id = $row_expired_project_requests['student_id'];
    $student_name = $row_expired_project_requests['student_name'];
    $project_id = $row_expired_project_requests['project_id'];
    $project_ranking = $row_expired_project_requests['project_ranking'];
    $query_update_decline = "UPDATE student_project_requests SET state = 'declined', state_changed_time = current_timestamp WHERE student_id = $student_id AND project_id = $project_id AND project_ranking = $project_ranking";
    connectDB();
    mysqli_query($_SESSION['db'], $query_update_decline);
    closeDB();
    if ($project_ranking < 3) {
        // Get the lecturer email and project name of the next ranking project request
        $query_project_lecturer = "SELECT lecturers.lecturer_email, projects.project_topic FROM `student_project_requests`
        JOIN projects ON student_project_requests.project_id = projects.project_id
        JOIN lecturers ON projects.lecturer_id = lecturers.lecturer_id
        WHERE student_id = $student_id
        AND project_ranking = ($project_ranking + 1)";
        connectDB();
        $result_lecturer_email = mysqli_query($_SESSION['db'], $query_project_lecturer);
        closeDB();
        $row_lecturer_email = mysqli_fetch_assoc($result_lecturer_email);
        $lecturer_email = $row_lecturer_email['lecturer_email'];
        $project_topic = $row_lecturer_email['project_topic']; 

        // Sending the email to lecturer about new project request
        $LECmail = new PHPMailer();
        $LECmail-> isSMTP();
        $LECmail->Host = 'mail.udlcanada.com';
        $LECmail->Port = "587";
        $LECmail->SMTPDebug  = 4;
        $LECmail->SMTPAuth = true;
        $LECmail->SMTPSecure = 'tls';
        $LECmail->Username = 'admin@udlcanada.com';
        $LECmail->Password = 'BrainDrain';
        // $LECmail->Host = 'mail.cduprojects.spinetail.cdu.edu.au';
        // $LECmail->Port = "465";
        // $LECmail->SMTPDebug  = 2;
        // $LECmail->SMTPAuth = true;
        // $LECmail->SMTPSecure = 'tls';
        // $LECmail->Username = 'project@cduprojects.spinetail.cdu.edu.au';
        // $LECmail->Password = 'CDUHit401';
        
        $message = file_get_contents("lecturer_email_template.html");
        $message = str_replace("%project_topic%", $project_topic, $message);
        $message = str_replace("%student_name%", $student_name, $message);
        $message = str_replace("%student_id%", $student_id, $message);

        $LECmail->Subject = 'New project request';
        $LECmail->isHTML(true);
        $LECmail->msgHTML($message);
        $LECmail->AltBody = 'You have a new project';
        $LECmail->setFrom('admin@udlcanada.com'); // sender
        $LECmail->addAddress($lecturer_email); // receiver
        if ($LECmail->Send()) {
            echo "Lecturer Mail Sent";
            // Set the next project request to initial and update the state changed time to current time
            $query_update_pending = "UPDATE student_project_requests SET state ='initial', state_changed_time = current_timestamp WHERE student_id = $student_id AND project_ranking = ($project_ranking + 1)";
            connectDB();
            mysqli_query($_SESSION['db'], $query_update_pending);
            closeDB();
        } else {
            // Lecturer email error
            echo "Error: " . $LECmail->ErrorInfo;
        }

    }

} else {
    echo "Nothing";
}