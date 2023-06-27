<?php
session_start();
if (!isset($_SESSION["user"])) {
   header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>firstpage</title>
</head>
<body>
    <ul>
        <li><a href="#home">Home</a></li>
        <li><a href="#news">News</a></li>
        <li><a href="#contact">Contact</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="/planb/navigation_bar/information.php">Personal information</a></li>
  <li> <a href="/planb/form/logout.php" class="btn btn-warning">Logout</a></li> 
          </ul>
    
</body>
</html>