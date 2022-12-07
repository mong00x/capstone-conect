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
        <h1 class="h2">Project List</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        
          
        </div>
      </div>


		
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <!--<th scope="col">Project ID</th>-->
              <th scope="col" class="col-5">Topic Title</th>
              <th scope="col" class="col-2">Lecturer Name</th>
             
			  <th scope="col" class="col-2">Disciplines</th>	
              <th scope="col" class="col-3">Actions</th>
            </tr>
          </thead>
          <tbody>
			  
	<?php 
			  
		if ($_SESSION['priv']>1) {	  
			$query = "SELECT * FROM projects ORDER BY project_id ASC";
		} else {
			
			$query = "SELECT * FROM projects WHERE lecturer_id= ".$_SESSION['userloginID']." OR lecturer2_id= ".$_SESSION['userloginID']." ORDER BY project_id ASC";
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
			$a=0; // what is $a for? seems like a counter
			while($row = mysqli_fetch_assoc($result)){ 
	?>
		  
			  
            <tr>
              <!-- <td><?php echo $row['project_id'];?></td> -->
              <td><?php echo $row['project_topic'];?></td>
              <td><?php echo $row['lecturer_name'];?><br>
<?php echo $row['lecturer2_name'];?></td>
				<td>
			<?php 	
			$query2 = "SELECT * FROM discipline d, discipline_project_mapping dd WHERE dd.project_id= ".$row['project_id']." AND d.discipline_id=dd.discipline_id ";
				connectDB();
		$result4= mysqli_query($_SESSION['db'],$query2) or die("<p><b>A fatal MySQL error occured</b>.\n<br />Query: " . $query2 . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']) . "</p>");
		
				while($row4 = mysqli_fetch_assoc($result4)){
					
					
					
             ?>
				<?php echo $row4['discipline']; echo "<br>"?>
				<?php }?>
					</td>
              <td><a href="index.php?p=add_project&project_id=<?php echo $row['project_id'];?>"  class="btn btn-primary mr-3" role="button">Edit</a>  <a href="index.php?p=project_list&del=<?php echo $row['project_id'];?>"  class="btn btn-primary " role="button" onclick="return confirm('Confirm to delete this project, please.');">Delete</a></td>
            </tr>
            
			  
			  							  
<?php		$a++;											  
			}
		
		}
	 ?>
			  
			  
          </tbody>
        </table>
      </div>

	 
	 		
	