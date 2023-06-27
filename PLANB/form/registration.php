<!-- ================================ -->
<?php
session_start();
if (isset($_SESSION["user"])) {
   header("Location: /planb/pages/mainpage.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="/planb/style/style.css">
</head>
<body>
    <div class="container">
        <?php
        require_once "action_page.php";

        if (isset($_POST["submit"])) {
           $fullName = $_POST["fullname"];
           $email = $_POST["email"];
           $phone = $_POST["phone"];
           $password = $_POST["password"];
           $passwordRepeat = $_POST["repeat_password"];
           
           $passwordHash = password_hash($password, PASSWORD_DEFAULT);
// validate form data
           $errors = array();

           if (empty($fullName) || empty($email) || empty($phone) || empty($password) || empty($passwordRepeat)) {
            array_push($errors,"All fields are required");
           }
           if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email is not valid");
           }
           if (strlen($password) < 8) {
            array_push($errors,"Password must be at least 8 charactes long");
           }
           if ($password !== $passwordRepeat) {
            array_push($errors,"Password does not match");
           }

           $sql = "SELECT * FROM users WHERE email = '$email'";
           $result = mysqli_query($conn, $sql);
           $rowCount = mysqli_num_rows($result);
           if ($rowCount > 0) {
            array_push($errors,"Email already exists!");
           }
           if (count($errors) > 0) {
            foreach ($errors as  $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
           }else{
            $sql = "INSERT INTO users (username, email, phone, password, password_hash) VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_stmt_init($conn);
if (mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_bind_param($stmt, "sssss", $fullName, $email, $phone, $password,$passwordHash);
    mysqli_stmt_execute($stmt);
    echo "<div class='alert alert-success'>You are registered successfully.</div>";

  } else {
    die("Something went wrong");
} 
           }
            // Set the user ID in the session
    $_SESSION["id"] = mysqli_insert_id($conn); 
    // Assuming you're using an auto-increment ID
 // Redirect to the information page
 header("Location: /planb/navigation_bar/information.php");
    exit();
        }
        ?>
        <form action="registration.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="fullname" placeholder="Full Name:">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email:">
            </div>
            <div class="form-group">
                <input type="phone" class="form-control" name="phone" placeholder="Phone Number:">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password:">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password:">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
        </form>
        <div>
        <div><p>Already Registered <a href="login.php">Login Here</a></p></div>
      </div>
    </div>
</body>
</html>