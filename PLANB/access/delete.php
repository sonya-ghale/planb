<?php
// starts session
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
if (isset($_SESSION["user"]["id"])) {
    $userId = $_SESSION["user"]["id"];

    // Check if the delete button is clicked
    if (isset($_POST["delete"])) {
        // Step 3: Delete User Data
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $userId);

        if ($stmt->execute()) {
            // Step 4: Redirect to Logout and Display Success Message
            session_destroy();
            header("Location: /planb/pages/firstpage.php");
            exit();
        } else {
            echo "Failed to delete the user's information.";
        }
    }
} else {
    echo "User ID not found in session.";
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="/planb/style/style.css">
    <title>Delete Account</title>
</head>
<body>
    <div class="container">
    <h1>Delete Account</h1>
    <p>Are you sure you want to delete your account? This action cannot be undone.</p>
    <form action="" method="POST">
        <div class="form-group">
        <input type="submit" name="delete" value="Delete" class="btn btn-primary">
        </div>
    </form>
    </div>
</body>
</html>
