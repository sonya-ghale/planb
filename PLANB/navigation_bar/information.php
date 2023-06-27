<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: /planb/form/login.php");
    exit();
 }

// Step 1: Establish Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "planb";

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

// Step 2: Fetch User Data
// var_dump($_SESSION);  shows everything
// Debugging session data

    $userId = $_SESSION["id"];

    $query = "SELECT username, email, phone, password FROM users WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $userId);
    $stmt->execute();
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($userData) {
        // Step 3: Display User Data
        echo "data found";
    } else {
        echo "User data not found.";
    }

?>
<!DOCTYPE html>
<html>
<head>
    <title>Personal Information</title>
</head>
<body>
    <h1>Personal Information</h1>
    <?php if (!empty($userData['username'])) { ?>
        <p>Name: <?php echo $userData['username']; ?></p>
    <?php } ?>
    <?php if (!empty($userData['email'])) { ?>
        <p>Email: <?php echo $userData['email']; ?></p>
    <?php } ?>
    <?php if (!empty($userData['phone'])) { ?>
        <p>Phone: <?php echo $userData['phone']; ?></p>
    <?php } ?>
    <?php if (!empty($userData['password'])) { ?>
        <p>Password: <?php echo $userData['password']; ?></p>
    <?php } ?>

       <a href="/planb/access/update.php"> <button>update</button></a> 
    <a href="/planb/access/delete.php"> <button>delete</button></a>
</body>
</html>


