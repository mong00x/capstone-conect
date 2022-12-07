<?php
	if ((isset($_POST['update']))&&($_POST['update']=="update"))
		{
	
		$query="UPDATE settings SET waiting_day='".$_POST['days']."'";		
				
				connectDB();
		$result=mysqli_query($_SESSION['db'],$query) or die ("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']));
				closeDB();
	}
?> 


	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
	</div>

	<!-- Content Row -->
	<div class="row">

		<!-- Total projects Card  -->
		<a class="col-xl-6 col-md-6 mb-4" href="index.php?p=project_list">
			<div class="card border-left-primary shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<!-- get project data -->
							<?php
							// if logged in as lecturer display only his projects
							if ($_SESSION['priv'] == 0)
							{
								$query = "SELECT * FROM projects WHERE lecturer_name = '".$_SESSION['user_name']."' OR lecturer2_name = '".$_SESSION['user_surname']."'";
							}
							
							else
							{
								$query="SELECT * FROM projects";
							}
							connectDB();
							$result=mysqli_query($_SESSION['db'],$query) or die ("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']));
							closeDB();

							$project_count=mysqli_num_rows($result);

							
							?>

							
							<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
								<?php 
									if ($_SESSION['priv'] == 0)
									{
										echo "My projects";
									}
									else
									{
										echo "Total projects";
									} 
								?>
							</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $project_count;?></div>
						</div>
						<div class="col-auto">
							<i class="fa-solid fa-layer-group fa-2x text-gray-300"></i>
							
						
						</div>
					</div>
				</div>
			</div>
		</a>

		<!-- Total applications Card  -->
		<a class="col-xl-6 col-md-6 mb-4" href="index.php?p=project_register">
			<div class="card border-left-info shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<!-- get project data -->
							<?php
							// if logged in as lecturer display only his applications
							if ($_SESSION['priv'] == 0)
							{
								// get all projects id from this lecturer
								$query = "SELECT * FROM projects WHERE lecturer_name = '".$_SESSION['user_name']."'";
								connectDB();
								$result=mysqli_query($_SESSION['db'],$query) or die ("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']));
								closeDB();
								$project_count=mysqli_num_rows($result);
								$project_id = array();
								$i = 0;
								while ($row = mysqli_fetch_array($result)) 
								{
									$project_id[$i] = $row['project_id']; 
									$i++;
								}
								// count all applicaions of this lecturer
								$application_count = 0;
								// get all projects
								$query = "SELECT * FROM student_project_requests";
								connectDB();
								$result=mysqli_query($_SESSION['db'],$query) or die ("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']));
								closeDB();
								while ($row = mysqli_fetch_array($result)) 
								{
									for ($i = 0; $i < $project_count; $i++)
									{
										if ($row['project_id'] == $project_id[$i])
										{
											$application_count++;
										}
									}
								}
								
							}
							
							else
							{
								$query="SELECT * FROM student_project_requests";
							}
							connectDB();
							$result=mysqli_query($_SESSION['db'],$query) or die ("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']));
							closeDB();

							$application_count=mysqli_num_rows($result);

							
							
							?>

							
							<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Applications</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $application_count;?></div>
						</div>
						<div class="col-auto">
							<i class="fa-solid fa-square-check fa-2x text-gray-300"></i>
						
						</div>
					</div>
				</div>
			</div>
		</a>

	

		<!-- Pending Requests Card 
		<a class="col-xl-4 col-md-6 mb-4" href="index.php?p=project_register">
			<div class="card border-left-warning shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<?php
							// if logged in as lecturer display only his applications that are pending
							// if ($_SESSION['priv'] == 0)
							// {
							// 	// get all projects id from this lecturer
							// 	$query = "SELECT * FROM projects WHERE lecturer_name = '".$_SESSION['user_name']."'";
							// 	connectDB();
							// 	$result=mysqli_query($_SESSION['db'],$query) or die ("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']));
							// 	closeDB();
							// 	$project_count=mysqli_num_rows($result);
							// 	$project_id = array();
							// 	$i = 0;
							// 	while ($row = mysqli_fetch_array($result)) 
							// 	{
							// 		$project_id[$i] = $row['project_id']; 
							// 		$i++;
							// 	}
							// 	// count all applicaions of this lecturer
							// 	$debug = 0;
							// 	$pending_count = 0;
							// 	for ($i = 0; $i < $project_count; $i++)
							// 	{
							// 		$query = "SELECT * FROM student_project_requests WHERE project_id = '".$project_id[$i]."' ";
							// 		connectDB();
							// 		$result=mysqli_query($_SESSION['db'],$query) or die ("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']));
							// 		closeDB();
							// 		while($row = mysqli_fetch_assoc($result)){
							// 			$debug = var_dump($row);
							// 		}
							// 	}
								
							// }
							
							// else
							// {
							// 	$query="SELECT * FROM student_project_requests WHERE approve = 0";
							// }
							// connectDB();
							// $result=mysqli_query($_SESSION['db'],$query) or die ("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']));
							// closeDB();
							
							// $pending_count=mysqli_num_rows($result);

							?>

							<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Pending Requests</div>
							<?php 
								// echo $debug;
							?>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $pending_count;?></div>
						</div>
						<div class="col-auto">
							<i class="fa-solid fa-clock fa-2x text-gray-300"></i>
						</div>
					</div>
				</div>
			</div>
		</a> -->


	</div>
	<!-- Content Row -->

	<div class="row">

	<!-- Area Chart -->
	<div class="col-12">
		<div class="card shadow mb-4">
			<!-- Card Header - Dropdown -->
			<div
				class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">Overview</h6>
				<div class="dropdown no-arrow">
					
					
				</div>
			</div>
			<!-- Card Body -->
			<div class="card-body h-900px">
				<?php if ($_SESSION['priv'] == 0) { ?>
					<div class="chart-bar"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
						<canvas id="myBarChart" style="display: block; height: 160px; width: 443px;" width="553" height="200" class="chartjs-render-monitor"></canvas>
					</div>
				<?php } ?>
				<?php if ($_SESSION['priv'] == 3) { ?>
						<div class="chart-pie pt-4 "><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
							<canvas id="myPieChart" style="display: block; height: 253px; width: 358px;" width="447" height="316" class="chartjs-render-monitor"></canvas>
						</div>     
					</div>
				<?php } ?>
				
			</div>
		</div>
	</div>






	
	
	
	
	  
	  
	  
	
	
	
	
	
	
	
	
	
	
	
  <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
		  
		  
		    
		  
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
<?php /*
  <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
	
	
	
	
	
	
	
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
	
	
	
	
	
	</div>
	
	*/?>
	
<!--</div>-->



	 
	 
	 
	 
	 
	 
	 