<html>
<head>
	<title>Change emailjs variable</title>
</head>

<body>
<?php
//including the database connection file

include_once 'includes.php';
connectDB();
if(isset($_POST['Submit'])) {	
	$serviceID = mysqli_real_escape_string($_SESSION['db'], $_POST['serviceID']);
	$templateID = mysqli_real_escape_string($_SESSION['db'], $_POST['templateID']);
	$publicKey = mysqli_real_escape_string($_SESSION['db'], $_POST['publicKey']);
		
	// checking empty fields
	if(empty($serviceID) || empty($templateID) || empty($publicKey)) {
				
		echo "<font color='red'>Do not leave any field empty.</font><br/>";
		
		//link to the previous page
		echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
	}
	
	else 
	{ 
		// if all the fields are filled (not empty) 
			
		//insert data to database	
		$result = mysqli_query($_SESSION['db'], "UPDATE emailjs SET  serviceID='$serviceID',templateID='$templateID',  publicKey = '$publicKey' WHERE id = 1;");
		
		//display success message
		echo "<font color='green'>Data added successfully.";
		?>
		<script>
		window.location.href = "mail.php";
		</script>
		<?php
	}
}
?>
</body>
</html>