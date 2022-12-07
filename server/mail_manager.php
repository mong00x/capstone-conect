
<?php 

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

include_once 'includes.php';

require_once 'PHPMailer/PHPMailer.php';
require_once 'PHPMailer/SMTP.php';
require_once 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// get data
$data = json_decode(file_get_contents("php://input"), true);

$name= $data['name'];
$password= $data['password'];
$student_email= $data['student_email'];
$student_id= $data['student_id'];

// verifing student entry
//checking if student already exist in database
$query = "SELECT student_id FROM students WHERE student_id = '$student_id'";
connectDB();
$result=mysqli_query($_SESSION['db'],$query) or die ("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']) . "Data: " . $data);
closeDB();
$row = mysqli_fetch_assoc($result);
if ( $row > 0)
{
	$success="0";
	echo json_encode(["success"=>0,"msg"=>"Student with this ID has already been resistered"]);
}
else
{
    
    $mail = new PHPMailer();

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
}

if ($mail->Send()) {
    echo "verification Mail sent\n";
} else {
    // error
    echo "Error: " . $mail->ErrorInfo;
}
?>