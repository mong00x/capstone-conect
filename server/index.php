<?php
require("includes.php");

if (!isset($_SESSION['auth']))
{ header("Location:login.php");}

// if( $_SESSION['priv'] == 0)
// {
    $query = "SELECT * FROM projects WHERE lecturer_id= ".$_SESSION['userloginID']." ORDER BY project_id ASC";

    // get current user's project title 
    connectDB();
    $result = mysqli_query($_SESSION['db'], $query) or die(mysqli_error($_SESSION['db']));
    closeDB();
    $projectsTopics = array();
    $projectsID = array();
    while($row = mysqli_fetch_assoc($result)){
      $projectsTopics[] = $row['project_topic'];
      $projectsID[] = $row['project_id'];
    }

    $projectsNumOfApp = array();
    for($i = 0; $i < count($projectsID); $i++)
    {
        $query = "SELECT * FROM student_project_requests WHERE project_id = ".$projectsID[$i];
        connectDB();
        $result = mysqli_query($_SESSION['db'], $query) or die(mysqli_error($_SESSION['db']));
        closeDB();
        $row = mysqli_fetch_assoc($result);
        if ($row['approve'] == 1){
          if ($projectsNumOfApp[$i] == 0){
            $projectsNumOfApp[$i] = 1;
          }
          else{
            $projectsNumOfApp[$i]++;
          }
        }
        else{
          $projectsNumOfApp[$i] = 0;
        }
    }
    if( $_SESSION['priv'] == 3){
      $projectsNumOfAppApproved = 0;
      $projectsNumOfAppDeclined = 0;
      $projectsNumOfAppPending = 0;
      $projectsNumOfAppQueuing = 0;

      // get number of applications based on approve status
     $query = "SELECT * FROM student_project_requests";
      connectDB();
      $result = mysqli_query($_SESSION['db'], $query) or die(mysqli_error($_SESSION['db']));
      closeDB();
      while($row = mysqli_fetch_assoc($result)){
        if($row['approve'] == 0){
          $projectsNumOfAppPending++;
        }
        else if($row['approve'] == 1){
          $projectsNumOfAppApproved++;
        }
        else if($row['approve'] == 2){
          $projectsNumOfAppDeclined++;
        }
        else{
          $projectsNumOfAppQueuing++;
        }
      }

  }
     
//   }
// else
// {
    // from student_project_requests get all projects where ranking is 1
    // $query = "SELECT * FROM student_project_requests WHERE project_ranking = 1";
    // connectDB();
    // $result = mysqli_query($_SESSION['db'], $query) or die(mysqli_error($_SESSION['db']));
    // closeDB();
    // $projectsID = array();
    // while($row = mysqli_fetch_assoc($result)){
    //   // if duplicate project_id, do not add to array
    //   if(!in_array($row['project_id'], $projectsID)){
    //     $projectsID[] = $row['project_id'];
    //   }
    // }
    // // for all projects, get number of application from student_project_requests where ranking is 1 and project_id is the current project
    // $projectsNumOfApp = array();
    // for($i = 0; $i < count($projectsID); $i++)
    // {
    //     $query = "SELECT COUNT(*) FROM student_project_requests WHERE project_ranking = 1 AND project_id = ".$projectsID[$i];
    //     connectDB();
    //     $result = mysqli_query($_SESSION['db'], $query) or die(mysqli_error($_SESSION['db']));
    //     closeDB();
    //     $row = mysqli_fetch_assoc($result);
    //     $projectsNumOfApp[] = $row['COUNT(*)'];
    // }

// }


// for all projects, get number of application from student_project_requests where ranking is 1 and project_id is the current project 




   

?>




<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
  
    <title>Capstone Connect Admin</title>
    <link rel="icon" type="image/svg+xml" href="https://cduprojects.spinetail.cdu.edu.au/adminpage/CC.svg" />
      <!-- Custom fonts for this template-->
      <script src="https://kit.fontawesome.com/5fbc3928d7.js" crossorigin="anonymous"></script>

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    
  </head>
  <body id="page-top">
    <div id="wrapper">
      <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
            <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect x="0.405762" y="0.274902" width="46.9502" height="46.9502" rx="4" fill="#4E73DF"/>
              <path d="M14.4969 34.086C12.4995 34.086 10.7729 33.7313 9.31686 33.022C7.87953 32.294 6.76886 31.2953 5.98486 30.026C5.20086 28.738 4.80886 27.254 4.80886 25.574C4.80886 23.9127 5.09819 22.3633 5.67686 20.926C6.27419 19.4887 7.10486 18.2473 8.16886 17.202C9.25153 16.138 10.5302 15.3073 12.0049 14.71C13.4982 14.1127 15.1595 13.814 16.9889 13.814C18.7435 13.814 20.2929 14.1127 21.6369 14.71C22.9809 15.3073 23.9982 16.166 24.6889 17.286L21.4129 19.974C20.9089 19.2273 20.2649 18.658 19.4809 18.266C18.6969 17.874 17.7635 17.678 16.6809 17.678C15.5795 17.678 14.5809 17.874 13.6849 18.266C12.7889 18.6393 12.0142 19.1807 11.3609 19.89C10.7262 20.5807 10.2409 21.3927 9.90486 22.326C9.56886 23.2593 9.40086 24.2487 9.40086 25.294C9.40086 26.2833 9.61553 27.1513 10.0449 27.898C10.4742 28.626 11.0995 29.1953 11.9209 29.606C12.7422 30.0167 13.7315 30.222 14.8889 30.222C15.8969 30.222 16.8395 30.0447 17.7169 29.69C18.5942 29.3167 19.3875 28.738 20.0969 27.954L22.7849 30.698C21.7582 31.8927 20.5355 32.7607 19.1169 33.302C17.7169 33.8247 16.1769 34.086 14.4969 34.086ZM34.6219 34.086C32.6245 34.086 30.8979 33.7313 29.4419 33.022C28.0045 32.294 26.8939 31.2953 26.1099 30.026C25.3259 28.738 24.9339 27.254 24.9339 25.574C24.9339 23.9127 25.2232 22.3633 25.8019 20.926C26.3992 19.4887 27.2299 18.2473 28.2939 17.202C29.3765 16.138 30.6552 15.3073 32.1299 14.71C33.6232 14.1127 35.2845 13.814 37.1139 13.814C38.8685 13.814 40.4179 14.1127 41.7619 14.71C43.1059 15.3073 44.1232 16.166 44.8139 17.286L41.5379 19.974C41.0339 19.2273 40.3899 18.658 39.6059 18.266C38.8219 17.874 37.8885 17.678 36.8059 17.678C35.7045 17.678 34.7059 17.874 33.8099 18.266C32.9139 18.6393 32.1392 19.1807 31.4859 19.89C30.8512 20.5807 30.3659 21.3927 30.0299 22.326C29.6939 23.2593 29.5259 24.2487 29.5259 25.294C29.5259 26.2833 29.7405 27.1513 30.1699 27.898C30.5992 28.626 31.2245 29.1953 32.0459 29.606C32.8672 30.0167 33.8565 30.222 35.0139 30.222C36.0219 30.222 36.9645 30.0447 37.8419 29.69C38.7192 29.3167 39.5125 28.738 40.2219 27.954L42.9099 30.698C41.8832 31.8927 40.6605 32.7607 39.2419 33.302C37.8419 33.8247 36.3019 34.086 34.6219 34.086Z" fill="#FEFEFE"/>
            </svg>


                <div class="sidebar-brand-text mx-3">Capstone Connect</div>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item  <?php if(!isset($_GET['p'])) {echo "active";};  ?>">
            <a class="nav-link" href="index.php">
                    <span>Dashboard</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">
           

            <!-- Heading -->
            <?php if ($_SESSION['priv']>1) {?>	
              <div class="sidebar-heading">
                Admin Menu
              </div>
             
               <li class="nav-item  <?php if(isset($_GET['p']) and $_GET['p'] == "add_lecturer") {echo "active";};  ?>">
                <a class="nav-link active" aria-current="page" href="index.php?p=add_lecturer">
                  <span data-feather="file-plus" class="align-text-bottom"></span>
                  Add a lecturer
                </a>
              </li>
              <li class="nav-item  <?php if(isset($_GET['p']) and $_GET['p'] == "lecturers_list") {echo "active";};  ?>">
                <a class="nav-link active" aria-current="page" href="index.php?p=lecturers_list">
                  <span data-feather="users" class="align-text-bottom"></span>
                  Lecturer List
                </a>
              </li>
              <li class="nav-item  <?php if(isset($_GET['p']) and $_GET['p'] == "discipline") {echo "active";};  ?>">
                <a class="nav-link active" href="index.php?p=discipline">
                  <span data-feather="layers" class="align-text-bottom"></span>
                  Discipline
                </a>
              </li>
              <li class="nav-item  <?php if(isset($_GET['p']) and $_GET['p'] == "settings") {echo "active";};  ?>">
                <a class="nav-link active" aria-current="page" href="index.php?p=settings">
                 Settings
                </a>
              </li>
                <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <?php }?>
			
          <li class="nav-item  <?php if(isset($_GET['p']) and $_GET['p'] == "add_project") {echo "active";};  ?>">
            <a class="nav-link" href="index.php?p=add_project">
              <span data-feather="file-plus" class="align-text-bottom"></span>
              Add a Project
            </a>
          </li>
          <li class="nav-item  <?php if(isset($_GET['p']) and $_GET['p'] == "project_list") {echo "active";};  ?>">
            <a class="nav-link" href="index.php?p=project_list">
              <span data-feather="list" class="align-text-bottom"></span>
              Project List
            </a>
          </li>
          <li class="nav-item  <?php if(isset($_GET['p']) and $_GET['p'] == "project_register") {echo "active";};  ?>">
            <a class="nav-link" href="index.php?p=project_register">
              <span data-feather="layers" class="align-text-bottom"></span>
              Project Register
            </a>
          </li>
          <li class="nav-item  <?php if(isset($_GET['p']) and $_GET['p'] == "students_list") {echo "active";};  ?>">
            <a class="nav-link" href="index.php?p=students_list">
              <span data-feather="users" class="align-text-bottom"></span>
              Student List
            </a>
          </li>




            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

           
        </ul>
                <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
              
              <!-- Topbar -->
              <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>



                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">


                    <!-- Nav Item - User Information -->
                 
                    <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle text-primary" href="#" id="messagesDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa-solid fa-user mr-3"></i>
                        Hello <b class="mr-1 ml-1"><?php echo ucwords($_SESSION['user_name']);?></b>
                            
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in primary"
                            aria-labelledby="userDropdown">
                            
                            <a class="dropdown-item" href="logout.php">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                              Sign out

                            </a>
                        </div>
                    </li>

                </ul>

              </nav>
              <!-- End of Topbar -->

              <!-- page -->
              <!-- Begin Page Content -->
              <div class="container-fluid">
              <?php
                
                if (isset($_GET['p'])) $page=$_GET['p'];
                else $page="";
                
                switch ($page) {
                  case "":
                    include_once('home.php');
                    break;
                  case "add_lecturer":
                    include_once('add_lecturer.php');
                    break;
                  case "lecturers_list":
                    include_once('lecturers_list.php');
                    break;
                  case "add_project":
                    include_once('add_project.php');
                    break;
                  case "project_list":
                    include_once('project_list.php');
                    break;	
                  case "project_register":
                    include_once('project_register.php');
                    break;
                  case "discipline":
                    include_once('discipline.php');
                    break;
                  case "settings":
                      include_once('settings.php');
                      break;
                  case "students_list":
                      include_once('students_list.php');
                      break;
                  default:	
                  include_once('home.php');
                    break;	
                  
                }
                ?>

              </div>


            </div>

        </div>

    </div>





<!-- <div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">
        
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <span data-feather="home" class="align-text-bottom"></span>
              Dashboard
            </a>
          </li>
		
			
          <li class="nav-item">
            <a class="nav-link" href="index.php?p=add_project">
              <span data-feather="file-plus" class="align-text-bottom"></span>
              Add a Project
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?p=project_list">
              <span data-feather="list" class="align-text-bottom"></span>
              Project List
            </a>
          </li>
			<li class="nav-item">
            <a class="nav-link" href="index.php?p=project_register">
              <span data-feather="layers" class="align-text-bottom"></span>
              Project Register
            </a>
          </li>
            <li class="nav-item">
            <a class="nav-link" href="index.php?p=students_list">
              <span data-feather="users" class="align-text-bottom"></span>
              Student List
            </a>
          </li>
         
         
			
         
        </ul>

      
      </div>
    </nav> -->

   

     
		

  <!-- </div>
</div> -->

<!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>


    

    <script>
      // Set new default font family and font color to mimic Bootstrap's default styling
      Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
      Chart.defaults.global.defaultFontColor = '#858796';

      // read the current user variable from php
      


      function number_format(number, decimals, dec_point, thousands_sep) {
        // *     example: number_format(1234.56, 2, ',', ' ');
        // *     return: '1 234,56'
        number = (number + '').replace(',', '').replace(' ', '');
        var n = !isFinite(+number) ? 0 : +number,
          prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
          sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
          dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
          s = '',
          toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
          s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
          s[1] = s[1] || '';
          s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
      }

      // Bar Chart Example



      var priv = <?php echo $_SESSION['priv'];?>;
      

      var projects = <?php echo json_encode($projectsTopics);?>;
      console.log(projects)


      
      if (priv == 0){
        var ctx = document.getElementById("myBarChart");

        
        var projects = <?php echo json_encode($projectsTopics);?>;
        var projectNumofApp = <?php echo json_encode($projectsNumOfApp);?>;
        console.log(projects, projectNumofApp)

        console.log("normal user")
        var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: projects,
          datasets: [{
            label: "Number of Applications",
            backgroundColor: "#4e73df",
            hoverBackgroundColor: "#2e59d9",
            borderColor: "#4e73df",
            data: projectNumofApp,
          }],
        },
        options: {
          maintainAspectRatio: false,
          layout: {
            padding: {
              left: 10,
              right: 25,
              top: 25,
              bottom: 0
            }
          },
          scales: {
            xAxes: [{
              // project name
              time: {
                unit: 'project'
              },

              gridLines: {
                display: false,
                drawBorder: false
              },
              ticks: {
                maxTicksLimit: 6
              },
              maxBarThickness: 25,
            }],
            yAxes: [{
              ticks: {
                min: 0,
                // max is the largest number of applications using Math.max()
                max:(Math.max(...projectNumofApp)) < 5 ? 5 : Math.max(...projectNumofApp),
                maxTicksLimit: (Math.max(...projectNumofApp)) < 5 ? 6 : Math.max(...projectNumofApp) + 1,
                padding: 10,
                
              },
              gridLines: {
                color: "rgb(234, 236, 244)",
                zeroLineColor: "rgb(234, 236, 244)",
                drawBorder: false,
                borderDash: [2],
                zeroLineBorderDash: [2]
              }
            }],
          },
          legend: {
            display: false
          },
          tooltips: {
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
            
          },
        }
      });

      } else {
        console.log("admin user")
        var data_accetped = <?php echo json_encode($projectsNumOfAppApproved);?>;
        var data_declined = <?php echo json_encode($projectsNumOfAppDeclined);?>;
        var data_pending = <?php echo json_encode($projectsNumOfAppPending);?>;
        var data_queuing = <?php echo json_encode($projectsNumOfAppQueuing);?>;


        console.log(data_accetped, data_declined, data_pending)
        // Set new default font family and font color to mimic Bootstrap's default styling
        Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';

        // Pie Chart Example
        var ctx = document.getElementById("myPieChart");
        var myPieChart = new Chart(ctx, {
          type: 'doughnut',
          data: {
            labels: ["Approved", "Declined/Expired", "Pending", "Queuing"],
            datasets: [{
              data: [data_accetped, data_declined, data_pending, data_queuing],
              backgroundColor: ['#48BB78', '#F56565', '#ECC94B', '#4299E1'],
              hoverOffset: 4
            }],
          },
          options: {
            maintainAspectRatio: false,
            tooltips: {
              backgroundColor: "rgb(255,255,255)",
              bodyFontColor: "#858796",
              borderColor: '#dddfeb',
              xPadding: 15,
              yPadding: 15,
              displayColors: false,
              caretPadding: 10,
            },
            legend: {
              display: true,
              position: 'bottom',
              labels: {
                fontColor: '#858796',
                fontSize: 14,
              }

            },
            cutoutPercentage: 40,
          },
        });
      }

      

      

    </script>

  </body>
</html>
