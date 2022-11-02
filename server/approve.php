<?php




require ("PHPMailer\Exception.php");
require ("PHPMailer\PHPMailer.php");
require ("PHPMailer\SMTP.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require("includes.php");


if (isset($_GET['approve']))
{
	
	$query="UPDATE student_project_requests SET approve=1 WHERE project_id=".$_GET['project_id']." AND student_id=".$_GET['student_id'];
	connectDB();
		$result = mysqli_query($_SESSION['db'],$query) or die("<p><b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']) . "</p>");
		closeDB();
	
}


//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);


    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'mail.udlcanada.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'admin@udlcanada.com';                     //SMTP username
    $mail->Password   = 'BrainDrain';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('project@cduprojects.spinetail.cdu.edu.au', 'project@cduprojects.spinetail.cdu.edu.au');
    $mail->addAddress('s328390@students.cdu.edu.au', 'Khanh Dzu Do');     //Add a recipient
    $mail->addReplyTo('project@cduprojects.spinetail.cdu.edu.au', 'project@cduprojects.spinetail.cdu.edu.au');
    
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Your registered project is approved !';
    $mail->Body    = 'Your registered project is approved !';
    $mail->AltBody = 'Your registered project is approved !';

    $mail->send();
    echo 'Message has been sent';



?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>HIT401</title>
</head>

<body>
	<h1>The student register has been approved !</h1>
</body>
</html>
