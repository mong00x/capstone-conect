 <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Lecturer List</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        
          
        </div>
      </div>


		
		<h2>Section title</h2>
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">Project ID</th>
              <th scope="col">Topic Title</th>
              <th scope="col">Lecturer Name</th>
              <th scope="col">Internal / External</th>
			  <th scope="col">Category</th>	
              <th scope="col">Edit/Delete</th>
            </tr>
          </thead>
          <tbody>
			  
	<?php 
			  
		if ($_SESSION['priv']>1) {	  
			$query = "SELECT * FROM projects ORDER BY project_id DESC";
		} else {
			
			$query = "SELECT * FROM projects WHERE lecturer_id= ".$_SESSION['userloginID']." ORDER BY project_id DESC";
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
	?>
		  
			  
            <tr>
              <td><?php echo $row['project_id'];?></td>
              <td><?php echo $row['project_topic'];?></td>
              <td><?php echo $row['lecturer_id'];?></td>
              <td><?php echo $row['project_internal'];?> / <?php echo $row['project_external'];?></td>
				<td><?php echo $row['category'];?></td>
              <td><a href="#"  class="btn btn-primary " role="button">Edit</a> | <a href="#"  class="btn btn-primary " role="button">Delete</a></td>
            </tr>
            
			  
			  							  
<?php		$a++;											  
			}
		
		}
	 ?>
			  
			  
          </tbody>
        </table>
      </div>

	 </main>
	 
	 		
	