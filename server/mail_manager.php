
<?php 

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


$success=0;
$name= $data['name'];
$password= $data['password'];
$student_email= $data['student_email'];


$mail-> isSMTP();
$mail->Host = 'mail.cduprojects.spinetail.cdu.edu.au';
$mail->Port = "587";
$mail->SMTPDebug  = 2;
$mail->SMTPAuth = true;
// $mail->SMTPSecure = 'tls';
$mail->Username = 'no-reply@cduprojects.spinetail.cdu.edu.au';
$mail->Password = 'pRsdKrr8DeHwTY3';

$message_std = file_get_contents("OTP_template.html");
$message_std= str_replace("%student_name%", $name, $message_std);
$message_std= str_replace("%password%", $password, $message_std);

$mail->Subject = 'Your OTP';
$mail->isHTML(true);
$mail->msgHTML($message_std);
$mail->AltBody = 'your OTP is '. $password;
$mail->setFrom('no-reply@cduprojects.spinetail.cdu.edu.au'); // sender
$mail->addAddress($student_email); // receiver
if ($mail->Send()) {
    echo "verification Mail sent\n";
} else {
    // error
    echo "Error: " . $mail->ErrorInfo;
}


?>