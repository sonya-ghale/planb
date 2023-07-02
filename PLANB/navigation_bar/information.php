<?php
session_start();
if (!isset($_SESSION["user"])) {
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

// Debugging session data

if (isset($_SESSION["user"]["id"])){
    $userId = $_SESSION["user"]["id"];

    $sql = "SELECT username, email, phone, password FROM users WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $userId);
    $stmt->execute();
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($userData) {
        // Step 3: Display User Data
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="/planb/style/style.css">
    <title>Personal Information</title>
</head>
<body>
    <div class="container">
    <h1>Personal Information</h1>
    <?php if (!empty($userData['username'])) { ?>
        <p>Username: <?php echo $userData['username']; ?></p>
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
    <div class="form-group">
       <a href="/planb/access/reset.php"> 
        <input type="submit" name="reset" value="Reset" class="btn btn-primary"></a> 
       
        <a href="/planb/access/delete.php">
        <input type="submit" name="reset" value="Delete" class="btn btn-primary">
        </a>
    </div>

    <!--=========end of container=========  -->
</div>
</body>
</html>
<?php
    } else {
        echo "User data not found.";
    }
} else {
    echo "User ID not found in session.";
}
?>


