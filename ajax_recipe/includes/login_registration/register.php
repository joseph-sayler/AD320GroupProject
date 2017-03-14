<?php session_start(); ?>

<?php

// Includes connection to SQL Database
require 'connectDB.php';

// Set Variables
$email = '';
$userNameSubmit = '';
$passwordSubmit = '';
$passwordConfirm = '';
$registerSuccess = false;
$message = '';

// Retrieve Values for Variables
$email = filter_input(INPUT_POST, 'email_submit');
$userNameSubmit = filter_input(INPUT_POST, 'username_submit');
$passwordSubmit = filter_input(INPUT_POST, 'password_submit');
$passwordConfirm = filter_input(INPUT_POST, 'password_confirm');
$action = filter_input(INPUT_POST, 'action');

/*
 * Scripts to register user to database
 */

if ($action == 'register') {

    // Check for null values
    if (empty($email)) {
        $message = 'Please enter an email address.';
    } else if (empty($userNameSubmit)) {
        $message = 'Please enter a username.';
    } else if (empty($passwordSubmit)) {
        $message = 'Please enter a password.';
    } else if (empty($passwordConfirm)) {
        $message = 'Please confirm your password.';
    } // Check if password matches confirmation
    else if ($passwordSubmit != $passwordConfirm) {
        $message = 'Your passwords do not match.';
    } else if (!empty($email) && !empty($userNameSubmit) && !empty($passwordSubmit)) {

        /*
         * Checks are good, Hash password & insert into createUserDB
         */

        //Salt & Hash Password
        $hashPass = password_hash($passwordSubmit, PASSWORD_DEFAULT);


        //Check if hash & password match
        if (password_verify($passwordSubmit, $hashPass)) {
            //Insert user data into database
            try {
                $sql_insert = "INSERT INTO user_DB (userName, password, email) 
                           VALUES ('$userNameSubmit', '$hashPass', '$email');";
                $conn->exec($sql_insert);
                $registerSuccess = true;
                $_SESSION['user'] = $userNameSubmit;
            } catch (PDOException $e) {
                echo $sql_insert . "<br>" . $e->getMessage();
            } finally {
                $conn = null;
            }
        }
    }
}

if ($registerSuccess) {
    header("location: registrationSuccess.php");
    exit();
}

if ($action == 'back') {
    header('location: index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration</title>
</head>
<body>
<header>
    <h1>Register Your Account</h1>
</header>
<main>
    <form action="register.php" method="POST">
        <h5>Welcome! Please enter your email, username and password!</h5><br>
        <table>
            <tr>
                <td align="right">Email:</td>
                <td align="left"><input type="email" name="email_submit"
                                        value="<?php echo $email; ?>"/></td>
            </tr>
            <tr>
                <td align="right">Username:</td>
                <td align="left"><input type="text" name="username_submit"
                                        value="<?php echo $userNameSubmit; ?>"/></td>
            </tr>
            <tr>
                <td align="right">Password:</td>
                <td align="left"><input type="password" name="password_submit"></td>
            </tr>
            <tr>
                <td align="right">Confirm Password:</td>
                <td align="left"><input type="password" name="password_confirm"</td>
            </tr>
            <tr>
                <td align="left">
                    <div id="button">
                        <label>&nbsp;</label>
                        <input type="submit" value="register" name="action">
                </td>
                </div>
            </tr>
            <tr>
                <td align="left">
                    <div id="button">
                        <label>&nbsp;</label>
                        <input type="submit" value="back" name="action">
                </td>
                </div>
            </tr>
        </table>
    </form>
    <p><?php echo nl2br(htmlspecialchars($message)); ?></p>
</main>
</body>
</html>