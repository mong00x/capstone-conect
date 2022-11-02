<?php
if (isset($_GET['del']))
{
	$query="DELETE FROM projects WHERE project_id=".$_GET['del'];
	connectDB();
		$result = mysqli_query($_SESSION['db'],$query) or die("<p><b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']) . "</p>");
		closeDB();
	
}


if (isset($_GET['approve']))
{
	
	$query="UPDATE student_project_requests SET approve=1 WHERE project_id=".$_GET['approve']." AND student_id=".$_GET['student_id'];
	connectDB();
		$result = mysqli_query($_SESSION['db'],$query) or die("<p><b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']) . "</p>");
		closeDB();
	
}

if (isset($_GET['decline']))
{
	
	$query="UPDATE student_project_requests SET approve=2 WHERE project_id=".$_GET['decline']." AND student_id=".$_GET['student_id'];
	connectDB();
		$result = mysqli_query($_SESSION['db'],$query) or die("<p><b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']) . "</p>");
		closeDB();
	
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
			$query = "SELECT * FROM student_project_requests ORDER BY project_id ASC";
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
	 
	 		
	