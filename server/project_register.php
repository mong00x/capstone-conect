<?php

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (isset($_GET['del']))
{
	$query="DELETE FROM projects WHERE project_id=".$_GET['del'];
	connectDB();
		$result = mysqli_query($_SESSION['db'],$query) or die("<p><b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']) . "</p>");
		closeDB();
	
}


if (isset($_GET['approve']))
{
	
	$query="UPDATE student_project_requests SET approve=1, state_changed_time = current_timestamp WHERE project_id=".$_GET['approve']." AND student_id=".$_GET['student_id'];
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
    WHERE projects.project_id=".$_GET['approve'].
    connectDB();
    $result_project_info = mysqli_query($_SESSION['db'], $query_project_info);
    closeDB();
    $row_project_info = mysqli_fetch_assoc($result_project_info);
    $lecturer_email = $row_project_info['lecturer_email'];
    $project_topic = $row_project_info['project_topic'];

	$query_update_student = "UPDATE students SET project_id=" .$_GET['approve']. " WHERE student_id=" .$_GET['student_id'];
	connectDB();
	mysqli_query($_SESSION['db'], $query_update_student);
	closeDB();

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
	$mail->setFrom('admin@udlcanada.com'); // sender

	
	// Spinetail Mail Settings
    // $mail->Host = 'mail.cduprojects.spinetail.cdu.edu.au';
    // $mail->Port = "587";
    // $mail->SMTPAuth = true;
    // $mail->SMTPSecure = 'tls';
    // $mail->Username = 'no-reply@cduprojects.spinetail.cdu.edu.au';
    // $mail->Password = 'pRsdKrr8DeHwTY3';
    // $mail->setFrom('no-reply@cduprojects.spinetail.cdu.edu.au');
    
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
        echo "<script>window.location.href='index.php?p=project_register';</script>";
        exit;
    } else {
        // error
        echo "Error: " . $mail->ErrorInfo;
    }

}

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
		// $LECmail->SMTPSecure = 'tls';
		$LECmail->Username = 'admin@udlcanada.com';
		$LECmail->Password = 'BrainDrain';
		$LECmail->setFrom('admin@udlcanada.com'); // sender

		// Spinetail Mail Settings
		// $LECmail->Host = 'mail.cduprojects.spinetail.cdu.edu.au';
		// $LECmail->Port = "587";
		// $LECmail->SMTPDebug  = 2;
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
            echo "<script>window.location.href='index.php?p=project_register';</script>";
            exit;
		} else {
			// Lecturer email error
			echo "Error: " . $LECmail->ErrorInfo;
		}

	}

	elseif ($project_ranking = 3) {
		$query_update_decline = "UPDATE student_project_requests SET approve = '2', state_changed_time = current_timestamp WHERE project_ranking = $project_ranking AND project_id=".$_GET['decline']." AND student_id=".$_GET['student_id'];
		connectDB();
		mysqli_query($_SESSION['db'], $query_update_decline);
		closeDB();
        echo "<script>window.location.href='index.php?p=project_register';</script>";
        exit;
	}

}

if (isset($_GET['pending']))
{
	
	$query="UPDATE student_project_requests SET approve=0 WHERE project_id=".$_GET['pending']." AND student_id=".$_GET['student_id'];
	connectDB();
		$result = mysqli_query($_SESSION['db'],$query) or die("<p><b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']) . "</p>");
		closeDB();
	
}


?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Project Register List</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        
          
        </div>
      </div>


		
		<h2>Section title</h2>
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">Project Name</th>
              <th scope="col">Student Name</th>
              <th scope="col">Student ID</th>
             
			  <th scope="col">Priority</th>	
              <th scope="col">Approve / Decline</th>
            </tr>
          </thead>
          <tbody>
			  
	<?php 
			  
		if ($_SESSION['priv']>1) {	  
			$query = "SELECT * FROM student_project_requests ORDER BY student_id ASC";
		} else {
			
			$query = "SELECT * FROM student_project_requests s, projects p WHERE s.project_id=p.project_id AND (p.lecturer_id= ".$_SESSION['userloginID']." OR p.lecturer2_id= ".$_SESSION['userloginID'].") ORDER BY s.project_id ASC";
		}
		connectDB();
		$result = mysqli_query($_SESSION['db'],$query) or die("<p><b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']) . "</p>");
		$result2=$result;
		$result3=$result;
		closeDB();
		if(mysqli_num_rows($result)<1){
			//no results found
			echo "<p class=\"\">No results found.</p>";
		}else{
			$a=0;
			while($row = mysqli_fetch_assoc($result)){ 
		
			
				
			
			
				
		$query_prj = "SELECT * FROM projects WHERE project_id='".$row['project_id']."'"	;
		connectDB();
		$result_prj = mysqli_query($_SESSION['db'],$query_prj);
		$row_prj = mysqli_fetch_assoc($result_prj);
		closeDB();
				
		$query_st = "SELECT * FROM students WHERE student_id='".$row['student_id']."'"	;
		connectDB();
		$result_st = mysqli_query($_SESSION['db'],$query_st);
		$row_st = mysqli_fetch_assoc($result_st);
		closeDB();		
	
				
	?>
		  	
			  
            <tr>
              <td><?php echo $row_prj['project_topic'];?>
				  
				  
				  <?php if ($row['approve']==0) echo '<span class="badge bg-warning text-dark">Pending</span>';
				  		if ($row['approve']==1) echo '<span class="badge bg-primary">Approved</span>';
						if ($row['approve']==2) echo '<span class="badge bg-danger">Declined</span>';
				  ?>
				  
				
				
				</td>
              <td><?php echo $row_st['student_name'];?></td>
              <td><?php echo $row_st['student_id'];?></td>
				<td><?php echo $row['project_ranking'];?>
					</td>
              <td>
				  
				<?php 
				
				$show=0;
				if (($row['approve']==0) AND ($row['project_ranking']==1)) $show=1; 
				if (($row['approve']==0) AND ($row['project_ranking']==2)) {
					
					
						$query5 = "SELECT * FROM student_project_requests  WHERE student_id=".$row_st['student_id']." AND project_ranking=1 AND approve<>2 ";
		connectDB();
		$result5 = mysqli_query($_SESSION['db'],$query5) or die("<p><b>A fatal MySQL error occured</b>.\n<br />Query: " . $query5 . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']) . "</p>");
		closeDB();
		if(mysqli_num_rows($result5)==0){$show=1;  }
					
					
				} 
				if (($row['approve']==0) AND ($row['project_ranking']==3)) {
					
					
						$query5 = "SELECT * FROM student_project_requests  WHERE student_id=".$row_st['student_id']." AND project_ranking=1 AND approve<>2 ";
		connectDB();
		$result5 = mysqli_query($_SESSION['db'],$query5) or die("<p><b>A fatal MySQL error occured</b>.\n<br />Query: " . $query5 . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']) . "</p>");
		closeDB();
		if(mysqli_num_rows($result5)==0){
		
			$query5 = "SELECT * FROM student_project_requests  WHERE student_id=".$row_st['student_id']." AND project_ranking=2 AND approve<>2 ";
		connectDB();
		$result5 = mysqli_query($_SESSION['db'],$query5) or die("<p><b>A fatal MySQL error occured</b>.\n<br />Query: " . $query5 . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']) . "</p>");
		closeDB();
		if(mysqli_num_rows($result5)==0){$show=1; }
		
		
		}
					
					
				} 
				
				
				
				
				if ($show==1) {
				?>
				  <a href="index.php?p=project_register&approve=<?php echo $row['project_id'];?>&student_id=<?php echo $row['student_id']?>"  class="btn btn-primary " role="button" onclick="return confirm('Confirm to APPROVE this project, please.');">Approve</a> | <a href="index.php?p=project_register&decline=<?php echo $row['project_id'];?>&student_id=<?php echo $row['student_id'];?>"  class="btn btn-primary " role="button" onclick="return confirm('Confirm to DECLINE this project, please.');">Decline</a>| <a href="index.php?p=project_register&pending=<?php echo $row['project_id'];?>&student_id=<?php echo $row['student_id'];?>"  class="btn btn-primary " role="button" onclick="return confirm('Confirm to PENDING this project, please.');">Pending</a>
				
				<?php }?>
				
				</td>
            </tr>
            
			  
			  							  
<?php		$a++;											  
			}
		
		}
	 ?>
			  
			  
          </tbody>
        </table>
      </div>

	 </main>
	 
	 		
	