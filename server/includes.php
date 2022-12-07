<?php
session_start();

// Connect to the Database
function connectDB(){
	// $db_username = "cduprojects";
	// $db_password = "Webapplication123";
	// $db_database = "cduprojects_hit401";
	// $db_host = "localhost";

	// $_SESSION['db'] = mysqli_connect(
	// $db_host,
	// $db_username,
	// $db_password,
	// $db_database);
	$db_username = "root";
	$db_password = "";
	$db_database = "hit401";
	$db_host = "localhost";

	$_SESSION['db'] = mysqli_connect(
	$db_host,
	$db_username,
	$db_password,
	$db_database);
	//Check connection
	if(mysqli_connect_errno()){
		echo "Failed to connect to MySQL:" . mysqli_connect_error();	
	}
}
function closeDB(){
	mysqli_close($_SESSION['db']);  
}

function get_project_topic($id)
{
	$query = "SELECT project_topic  FROM projects where project_id = '$id'";
	connectDB();
	$result=mysqli_query($_SESSION['db'],$query) or die ("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']) . "Data: " . $data);
	closeDB();

	$row = mysqli_fetch_assoc($result);
	$project_topic = $row['project_topic'];
	return $project_topic;
}












function msg(){
	if ($_SESSION['msg']) {
		echo "<div class=\"bg-primary ";
		if ($_SESSION['msgType']=="success"){
			echo "success" ;	
		}elseif ($_SESSION['msgType']=="caution"){
			echo "caution";
		}
		else {echo "error";}
		
		echo "\">".$_SESSION['msg']."</div>";

			
	
	}
	$_SESSION['msg']="";
	
}





















function auth($priv){
	
	if(!isset($_SESSION['priv'])){
		$_SESSION['priv']=0;
	}
	if ($priv>$_SESSION['priv']){
		header("Location: ?link=404&e=noAccess");	
	}else {
		if (!$_SESSION['accessTime']){
			$_SESSION['accessTime'] = time();
		}
		if ($priv>0) {
			
			$timeOut=500;
			if ($_SESSION['accessTime']<(time()-$timeOut)){

				header("Location: /adminpage/login.php");
			}else {
				//all good
			
			}			
			
		}
	
		
	}
	
$_SESSION['accessTime']=time();		
	

	}
	
	


 

function curPageName() {

return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

}

function cleanInput($input) {

$search = array(

'@<script[^>]*?>.*?</script>@si', // Strip out javascript

'@<[\/\!]*?[^<>]*?>@si', // Strip out HTML tags

'@<style[^>]*?>.*?</style>@siU', // Strip style tags properly

'@<![\s\S]*?--[ \t\n\r]*>@' // Strip multi-line comments

);

$output = preg_replace($search, '', $input);

return $output;

}

 

function sanitize($input) {

connectDB();

if (is_array($input)) {

foreach($input as $var=>$val) {

$output[$var] = sanitize($val);

}

}

else {

if (get_magic_quotes_gpc()) {

$input = stripslashes($input);

}

$input = cleanInput($input);

$output = mysqli_real_escape_string ( $_SESSION['db'] , $input );

}

closeDB();

return $output;

}

 

function getUserIP()

{

// Get real visitor IP behind CloudFlare network

if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {

$_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];

$_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];

}

$client = @$_SERVER['HTTP_CLIENT_IP'];

$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];

$remote = $_SERVER['REMOTE_ADDR'];

 

if(filter_var($client, FILTER_VALIDATE_IP))

{

$ip = $client;

}

elseif(filter_var($forward, FILTER_VALIDATE_IP))

{

$ip = $forward;

}

else

{

$ip = $remote;

}

 

return $ip;

}	


?>