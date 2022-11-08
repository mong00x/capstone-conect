<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Settings</h1>
        <div class="btn-toolbar mb-2 mb-md-0"> 
        </div>
      </div>

<h4>Auto Decline Project Request Interval</h4>

<?php
$query_expired_project_time = "SELECT day, hour, minute FROM expiration_project_time LIMIT 1";
connectDB();
$result_expired_project_time = mysqli_query($_SESSION['db'], $query_expired_project_time)  or die ("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']));
closeDB();
$row_expired_project_requests = mysqli_fetch_assoc($result_expired_project_time);
$expired_project_time_day = $row_expired_project_requests['day'];
$expired_project_time_hour = $row_expired_project_requests['hour'];
$expired_project_time_minute = $row_expired_project_requests['minute'];

if ((isset($_POST['submit']))&&($_POST['submit']=="updateProjectExpiry"))
{
    $day = $_POST['day'];
    $hour = $_POST['hour'];
    $minute = $_POST['minute'];
    $query_update_expired_project_time = "UPDATE expiration_project_time SET day = $day, hour = $hour, minute = $minute";
    connectDB();
    $result=mysqli_query($_SESSION['db'], $query_update_expired_project_time) or die ("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $query_update_expired_project_time . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']));
    closeDB();
    echo "<meta http-equiv='refresh' content='0'>";
}

?>

<form method="post" action="index.php?p=settings">
    <label class="sr-only" for="days">Days</label><input type="number" class="form-control" id="day" name="day" required value=<?php echo $expired_project_time_day; ?>>
    <label class="sr-only" for="hours">Hours</label><input type="number" class="form-control" id="hour" name="hour" required value=<?php echo $expired_project_time_hour; ?>>
    <label class="sr-only" for="minutes">Minutes</label><input type="number" class="form-control" id="minute" name ="minute" required value=<?php echo $expired_project_time_minute; ?>>
    <button type="submit" name="submit" value="updateProjectExpiry" class="btn btn-lg btn-primary btn-block" style="margin-top: 1%;">Update</button> 		
</form>