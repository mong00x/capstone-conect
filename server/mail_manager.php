
<?php 
/*
CREATE TABLE `emailjs` (
  id int NOT NULL AUTO_INCREMENT,
  serviceID varchar(255) DEFAULT NULL,
  templateID varchar(255) DEFAULT NULL,
  publicKey varchar(255) DEFAULT NULL,
  PRIMARY KEY (id)
);

--
-- Dumping data for table "emailjs"
--

INSERT INTO `emailjs` (`serviceID`, `templateID`, `publicKey`) VALUES
('service_v7jhvcq', 'template_7s3j2wa', 'pEzK7znAU0MbBXUsH');
*/
?>
<?php

header("Access-Control-Allow-Origin: *"); // 
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include 'includes.php';
$query = "SELECT * from emailjs";
connectDB();

$result=mysqli_query($_SESSION['db'],$query) or die ("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']));

closeDB();
$json_array= array();
while($row = mysqli_fetch_assoc($result))
{
    $json_array[]=$row;
}
echo json_encode($json_array);
?>