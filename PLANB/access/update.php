<?php
session_start();
if (!isset($_SESSION["user"])) {
   header("Location: /planb/login.php");
   exit();
}

// this is connection path to database
include "../form/action_page.php";

// Fetch user data
$user = $_SESSION["user"];
$userID = $user["id"];

// Resetting username, phone, and password
if (isset($_POST["reset"])) {
    $newUsername = $_POST["new_username"];
    $newPhone = $_POST["new_phone"];
    $currentPassword = $_POST["current_password"];
    $newPassword = $_POST["new_password"];
    $confirmPassword = $_POST["confirm_password"];

    // Validation
    $errors = array();

    // Check if the current password matches the stored password
    if (!password_verify($currentPassword, $user["password_hash"])) {
        array_push($errors, "Current password is incorrect");
    }

    // Check if the new password and confirm password match
    if ($newPassword !== $confirmPassword) {
        array_push($errors, "New password and confirm password do not match");
    }

    // Additional validation for new username, phone, and password
    // ...

    // If there are no validation errors, update the user's information
    if (count($errors) === 0) {
        // Update username and phone
        $updateSql = "UPDATE users SET username = ?, phone = ?, password = ? WHERE id = ?";
        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, $updateSql)) {
            mysqli_stmt_bind_param($stmt, "sssi", $newUsername, $newPhone, $newPassword, $userID);
            mysqli_stmt_execute($stmt);
            $_SESSION["user"]["username"] = $newUsername; // Update the username in the session
            $_SESSION["user"]["phone"] = $newPhone; // Update the phone number in the session
            $_SESSION["user"]["password"] = $newPassword; // Update the password in the session
        } else {
            die("Something went wrong");
        }

        // Update password if a new password is provided
        if (!empty($newPassword)) {
            $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
            $updatePasswordSql = "UPDATE users SET password_hash = ? WHERE id = ?";
            $stmt = mysqli_stmt_init($conn);
            if (mysqli_stmt_prepare($stmt, $updatePasswordSql)) {
                mysqli_stmt_bind_param($stmt, "si", $newPasswordHash, $userID);
                mysqli_stmt_execute($stmt);
                header("Location: /planb/pages/mainpage.php");

            } else {
                die("Something went wrong");
            }
        }

        echo "<div class='alert alert-success'>Personal information updated successfully.</div>";
        
    } else {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    }
}
?>

<!-- HTML form for resetting user information -->
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Reset Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="/planb/style/style.css">
    </head>
    <body>
        
<div class="container">
<form action="" method="post">
    <div class="form-group">
        <label for="new_username">New Username:</label>
        <input type="text" name="new_username" id="new_username" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="new_phone">New Phone Number:</label>
        <input type="text" name="new_phone" id="new_phone" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="current_password">Current Password:</label>
        <input type="password" name="current_password" id="current_password" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" id="new_password" class="form-control">
    </div>
    <div class="form-group">
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" id="confirm_password" class="form-control">
    </div>
    <div class="form-group">
        <input type="submit" name="reset" value="Reset Information" class="btn btn-primary">
    </div>


    
    <!-- container's end -->
    </div>
    <div>
   <a href="/planb/pages/mainpage.php"> <input type="submit" value="Back"></a>
</div>
</form>
</body>
</html>
