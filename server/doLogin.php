<?php
include_once("includes.php");

$query = "SELECT * FROM lecturers WHERE lecturer_email='".$_POST['email']."'";
connectDB();

$result=mysqli_query($_SESSION['db'],$query) or die ("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']));

closeDB();
	// $pw="Meatpie1";
	//echo "<br>".password_hash($pw,PASSWORD_DEFAULT)."<br><br><br>";
if(mysqli_num_rows($result)<1) {
	echo "No user found<br>";?>
<script>
		window.location.href = "login.php";
	</script>
	<?php
	//header("Location:?link=404&e=noUser");
	//echo md5('Meatpie1');
	
	//	echo password_hash($pw,PASSWORD_DEFAULT)."<br>";
	//	echo password_hash($pw,PASSWORD_DEFAULT)."<br>";
	
	 ; 	
} else {
	$row = mysqli_fetch_assoc($result);
	//echo $row['lecturer_password']."<br>";
	//echo md5($_POST['pw']);
	//exit ();
	if(md5($_POST['pw'])==$row['lecturer_password']) {
			//echo "Correct credentials. you are now logged in.<br><br>";
		$_SESSION['auth'] = true;
		$_SESSION['priv'] = $row['priv'];
		$_SESSION['userloginID']=$row['lecturer_id'];
		$_SESSION['user_name']=$row['lecturer_name'];
		$_SESSION['username']=$row['lecturer_email'];
		header("Location:index.php");
	}
	else {
		//echo "Incorrect Credentials.<br><br>";
		?>
	<script>
		window.location.href = "login.php";
	</script>
	
		<?php
	}
}



//var_dump($_POST);

?>