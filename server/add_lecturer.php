<?php 
$success=0;

if ((isset($_POST['submit']))&&($_POST['submit']=="CreateNewUser"))
	{
// check email available	
$query = "SELECT * FROM lecturers WHERE lecturer_email='".$_POST['inputEmail']."'"	;
		connectDB();
		$result = mysqli_query($_SESSION['db'],$query);
		closeDB();
		if (mysqli_num_rows($result)>0){
			$errorArray[] =  "<h1>This email is not available !</h1>";
		
		}
	
	
	else {
	
//insert information to database	
	
$query= "INSERT INTO lecturers (lecturer_email, lecturer_password, lecturer_name) VALUES ('".$_POST['inputEmail']."','".md5($_POST['inputPassword'])."','".$_POST['name']."')";

		connectDB();
$result=mysqli_query($_SESSION['db'],$query) or die ("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']));
		closeDB();
		
		$success="1";
		$_SESSION['msg']="User Created";
		$_SESSION['msgType']="success";
		
		
			$mailcontent =   "Lecturer Name :".$_POST['inputEmail']
				 ."\n<br> Password : ".$_POST['lecture_password']
				 ."\n<br> Email : ".$_POST['inputEmail']
				 ."\n<br> Login Link : ".$row['address']
				 ."\n<br> ";
		
		
		
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=utf-8\r\n";
$headers .= "From: HIT401 Team <s328390@students.cdu.edu.au>";
$toaddress_1 = "s328390@students.cdu.edu.au";
$toaddress_2= $_POST['lecture_password'];


$subject = "Project Management - Lecterer Account Login Information";

mail($toaddress_1,$subject,$mailcontent, $headers);
mail($toaddress_2,$subject,$mailcontent, $headers);

		
		
	
}}
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Add a lecturer</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        
          
        </div>
      </div>



	  <form method="post" action="index.php?p=add_lecturer" id="userManagement" class="form-signin" enctype="multipart/form-data">
		   <h2><?php if (isset($errorArray[0])) echo $errorArray[0];?></h2> 
 
	 <?php if ($success<>1) { ?>	
		  <label for="inputPassword" class="sr-only">Lecturer Name</label>
  <input type="text" id="name" name="name" class="form-control" placeholder="Your Name" required value="<?php if (isset($_POST['name'])) echo $_POST['name'];?>" >
  <label for="inputEmail" class="sr-only">Email address</label>
  <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email address"  autofocus required value="<?php if (isset($_POST['inputEmail'])) echo $_POST['inputEmail'];?>">
  <label for="inputPassword" class="sr-only">Password</label>
  <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required value="<?php if (isset($_POST['inputPassword'])) echo $_POST['inputPassword'];?>">
  
  <br>


<button type="submit" name="submit" value="CreateNewUser" class="btn btn-lg btn-primary btn-block" > Add </button> 		  
		    <?php } else { echo "You have added a lecturer successfully !";  ?>

		  
		  
		  <?php }?>
		  
		  
	<br>

</form> 
	
	  
	  
		
    </main>