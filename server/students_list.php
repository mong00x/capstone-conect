<?php
if (isset($_GET['del']))
{
	$query="DELETE FROM projects WHERE project_id=".$_GET['del'];
	connectDB();
		$result = mysqli_query($_SESSION['db'],$query) or die("<p><b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']) . "</p>");
		closeDB();
	
}


?>

      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Students List</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        
          
        </div>
      </div>


		
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
             
			  <th scope="col">Project</th>	
            </tr>
          </thead>
          <tbody>
			  
	<?php 
			  
		if ($_SESSION['priv']>1) {	  
			$query = "SELECT student_id, student_name, student_email, project_topic FROM students
			LEFT JOIN projects ON students.project_id = projects.project_id
			ORDER BY projects.project_id ASC";
		} else {
			$query = "SELECT student_id, student_name, student_email, project_topic FROM students
			LEFT JOIN projects ON students.project_id = projects.project_id
			WHERE projects.lecturer_id =".$_SESSION['userloginID']. " OR projects.lecturer2_id = ". $_SESSION['userloginID'] .
			" ORDER BY projects.project_id ASC";
		}
		connectDB();
		$result = mysqli_query($_SESSION['db'],$query) or die("<p><b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']) . "</p>");
		// $result2=$result;
		// $result3=$result;
		closeDB();
		if(mysqli_num_rows($result)<1){
			//no results found
			echo "<p class=\"\">No results found.</p>";
		}else{
			$a=0;
			while($row = mysqli_fetch_assoc($result)){ 
	?>
		  
			  
            <tr>
              <td><?php echo $row['student_id'];?></td>
              <td><?php echo $row['student_name'];?></td>
              <td><?php echo $row['student_email'];?></td>
			  <td><?php if (is_null($row['project_topic'])) 
			  { echo "No project";}
			   else { echo $row['project_topic'];}?></td>
            </tr>
            
			  
			  							  
<?php		$a++;											  
			}
		
		}
	 ?>
			  
			  
          </tbody>
        </table>
      </div>

	 		
	