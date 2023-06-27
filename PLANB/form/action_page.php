<!-- ====================connection login and registration form php============================= -->
<?php
// error_reporting(0);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "planb";

$conn = mysqli_connect($servername,$username,$password,$dbname);

if($conn){
    echo "connection ok";
}
else{
    echo "connection fail";
}
?>
