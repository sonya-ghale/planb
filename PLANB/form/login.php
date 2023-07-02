<!-- ==================================CLEAR===================================== -->
<?php
session_start();
if (isset($_SESSION["user"])) {
   header("Location: /planb/pages/mainpage.php");
   exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="/planb/style/style.css">
</head>
<body>
    <div class="container">
        <?php
        require_once "action_page.php";

        if (isset($_POST["login"])) {
            $email = $_POST["email"];
            $password = $_POST["password"];

            $sql = "SELECT * FROM users WHERE email = ?";
            $stmt = mysqli_stmt_init($conn);
            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $user = mysqli_fetch_assoc($result);

                if ($user) {
                    $storedPasswordHash = $user['password_hash'];
                    if (password_verify($password, $storedPasswordHash)) {
                        $_SESSION["user"] = $user; // Store user data in the session
                        header("Location: /planb/pages/mainpage.php");
                        exit();
                    } else {
                        echo "<div class='alert alert-danger'>Password does not match</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>User not found</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Something went wrong</div>";
            }
            mysqli_stmt_close($stmt);
        }
        ?>

        <form action="login.php" method="post">
            <div class="form-group">
                <input type="email" placeholder="Enter Email:" name="email" class="form-control">
            </div>
            <div class="form-group">
                <input type="password" placeholder="Enter Password:" name="password" class="form-control">
            </div>
            <div class="form-btn">
                <input type="submit" value="Login" name="login" class="btn btn-primary">
            </div>
        </form>
        <div>
            <p>Not registered yet? <a href="registration.php">Register Here</a></p>
        </div>
        <div>
        <a href="/planb/pages/firstpage.php"> 
        <input type="submit" value="Back">
        </div>
    </div>
</body>
</html>
 
