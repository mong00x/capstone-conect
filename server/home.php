 <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        
          
        </div>
      </div>




		<h2>Welcome to admin page !</h2>
    
	 
	 
	 
	 
	 
		<h2>Dashboard</h2>
      <div class="table-responsive">
		  
		   <table class="table table-striped table-sm">
          <thead>
            <tr>
           
              <th scope="col">Lecturer</th>
              <th scope="col">Registered Student  </th>
             
			  
            </tr>
          </thead>
          <tbody>
			  
	<?php 
			  
			  
			$query = "SELECT * FROM lecturers ORDER BY lecturer_id ASC";
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
             
              <td width="30%"><?php echo $row['lecturer_name'];?></td>
              <td>
				  <?php
				  $query_st = "SELECT * FROM student_project_requests s, projects p WHERE s.project_id = p.project_id AND (p.lecturer_id='".$row['lecturer_id']."' OR p.lecturer2_id='".$row['lecturer_id']."')"	;
				
				
 $query_st2 = "SELECT * FROM student_project_requests s, projects p WHERE s.project_id = p.project_id AND s.approve=1 AND (p.lecturer_id='".$row['lecturer_id']."' OR p.lecturer2_id='".$row['lecturer_id']."')"	;				
				
		connectDB();
		$result_st = mysqli_query($_SESSION['db'],$query_st);
				$result_st2 = mysqli_query($_SESSION['db'],$query_st2);
			closeDB();	
				  
				 $width=mysqli_num_rows($result_st)*30;
				$width2=mysqli_num_rows($result_st2)*30;
				  ?>
				  <img src="bg2.jpg" width="<?php echo $width2?>" height="30" alt=""/> <?php echo mysqli_num_rows($result_st2);?> approved<br>
				  
				  <img src="bg.jpg" width="<?php echo $width?>" height="30" alt=""/>Total: <?php echo mysqli_num_rows($result_st);?>
				
				
				
				</td>
			
            </tr>
            
			  
			  							  
<?php		$a++;											  
			}
		
		}
	 ?>
			  
			  
          </tbody>
        </table>
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
        <table class="table table-striped table-sm">
          <thead>
            <tr>
           
              <th scope="col">Topic Title</th>
              <th scope="col">Total Registered Student  </th>
             
			  
            </tr>
          </thead>
          <tbody>
			  
	<?php 
			  
		if ($_SESSION['priv']>1) {	  
			$query = "SELECT * FROM projects ORDER BY project_id ASC";
		} else {
			
			$query = "SELECT * FROM projects WHERE lecturer_id= ".$_SESSION['userloginID']." ORDER BY project_id ASC";
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
             
              <td width="30%"><?php echo $row['project_topic'];?></td>
              <td>
				  <?php
				  $query_st = "SELECT * FROM student_project_requests WHERE project_id='".$row['project_id']."'"	;
		connectDB();
		$result_st = mysqli_query($_SESSION['db'],$query_st);
			closeDB();	
				  
				 $width=mysqli_num_rows($result_st)*30;
				  ?>
				  
				  <img src="bg.jpg" width="<?php echo $width?>" height="30" alt=""/> <?php echo mysqli_num_rows($result_st);?>
				
				
				
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