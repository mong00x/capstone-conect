<?php 
$success=0;


if ((isset($_POST['submit']))&&($_POST['submit']=="CreateNewUser"))
	{
// check email available	
$query = "SELECT * FROM projects WHERE project_topic='".$_POST['title']."'"	;
		connectDB();
		$result = mysqli_query($_SESSION['db'],$query);
		closeDB();
		if (mysqli_num_rows($result)>0){
			$errorArray[] =  "<h1>This title is not available !</h1>";
		
		}
	
	
	else {
	
//insert information to database	
	
$dis="";
$lec=$_SESSION['user_name'];		


/*
if(isset($_POST['lecturer'])){
      foreach($_POST['lecturer'] as $value2){
		  $lec.= $value2.", ";
    }
  }	*/
		
	$dis=explode("|",$_POST['lecturer2_name']);
		
		

		
$query= "INSERT INTO projects (project_topic, project_description,lecturer_id, lecturer_name, lecturer2_id,lecturer2_name) VALUES ('".$_POST['title']."','".$_POST['detail']."','".$_SESSION['userloginID']."','".$_SESSION['user_name']."','".$dis[1]."','".$dis[0]."')";

		connectDB();
$result=mysqli_query($_SESSION['db'],$query) or die ("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']));
		closeDB();
	
		
		
		
	$query = "SELECT * FROM projects WHERE project_topic='".$_POST['title']."'"	;
		connectDB();
		$result = mysqli_query($_SESSION['db'],$query);
		$row2 = mysqli_fetch_assoc($result);
		closeDB();	
	
if(isset($_POST['discipline'])){
      foreach($_POST['discipline'] as $value){
		  $dis= $value;
		  
		  $query= "INSERT INTO discipline_project_mapping (project_id, discipline_id) VALUES ('".$row2['project_id']."','".$dis."')";

		connectDB();
$result=mysqli_query($_SESSION['db'],$query) or die ("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']));
		closeDB();
		  
		  
		  
    }
  }				
		
		
		
		$success="1";
		$_SESSION['msg']="User Created";
		$_SESSION['msgType']="success";
		
	
		
	
}}
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Add a project </h1>
		  
        <div class="btn-toolbar mb-2 mb-md-0">
        
          
        </div>
      </div>



	  <form method="post" action="index.php?p=add_project" id="userManagement" class="form-signin" enctype="multipart/form-data">
		   <h2><?php if (isset($errorArray[0])) echo $errorArray[0];?></h2> 
 
	 <?php if ($success<>1) { ?>	
		  <label for="inputPassword" class="sr-only">Project Title</label>
  <input type="text" id="title" name="title" class="form-control" placeholder="Title" required value="<?php if (isset($_POST['title'])) echo $_POST['title'];?>" >
  <label for="" class="sr-only">Project Detail</label>
<textarea class="form-control" id="detail" name="detail" rows="8"><?php if (isset($_POST['detail'])) echo $_POST['detail'];?></textarea>
   
  <label for="category" class="sr-only">Discipline</label>
		
  
			  
		<?php	  
		$query = "SELECT * FROM discipline "	;
		connectDB();
		$result = mysqli_query($_SESSION['db'],$query);
		closeDB();
		$aa=1;					 
		while($row = mysqli_fetch_assoc($result)){					
		?>					 
			
			  
<div class="form-check">
  <input class="form-check-input" type="checkbox" value="<?php echo $row['discipline_id']?>" name="discipline[]" >
  <label class="form-check-label" for="flexCheckDefault">
    <?php echo $row['discipline']?>
  </label>
</div>
			  
			  

  		<?php }?>

  <br>
		 <?php /*
<div class="form-check">
  <input class="form-check-input" type="checkbox" value="1" name="internal" checked>
  <label class="form-check-label" for="flexCheckDefault">
    Internal
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="checkbox" value="1" name="external" checked>
  <label class="form-check-label" for="flexCheckChecked">
    External
  </label>
</div><br>



<div class="form-check">
  <input class="form-check-input" type="checkbox" value="<?php echo $row['lecturer_name']?>" name="lecturer[]" >
  <label class="form-check-label" for="flexCheckDefault">
    <?php echo $row['lecturer_name']?>
  </label>
</div>


*/?>

 <label for="category" class="sr-only">Second Lecturer :</label>
		
 
		  

		  <select id="lecturer2_name" name="lecturer2_name">
			  
		<?php	  
		$query = "SELECT * FROM lecturers "	;
		connectDB();
		$result = mysqli_query($_SESSION['db'],$query);
		closeDB();
		$aa=1;					 
		while($row = mysqli_fetch_assoc($result)){					
		?>					 
			
			  

		  
  <option value="<?php echo $row['lecturer_name']?>|<?php echo $row['lecturer_id']?>"><?php echo $row['lecturer_name']?></option>

		  
		  
		<?php }?>  
		  
  
</select>
		  
		  		  

<button type="submit" name="submit" value="CreateNewUser" class="btn btn-lg btn-primary btn-block" > Add </button> 		  
		    <?php } else { echo "You have added a project successfully !";  ?>

		  
		  
		  <?php }?>
		  
		  
	<br>

</form> 
	
	  
	  
		
    </main>