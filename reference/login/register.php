<?php

// Includes connection to SQL Database
require "../database/database.php";
include 'navBarLogOn.php';
// Set Variables
$email = '';
$userNameSubmit = '';
$passwordSubmit = '';
$passwordConfirm = '';
$registerSuccess = false;
$message = '';
$userNameCheck = false;
$emailCheck = false;

// Retrieve Values for Variables
$email = filter_input(INPUT_POST, 'email_submit', FILTER_VALIDATE_EMAIL);
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

        // Checks for duplicate name
        try {
            $dbstmt = "
                  SELECT userName
                   FROM user_DB
                   WHERE userName='$userName'
                  ";
            $conn = Database::getDB();
            $result = $conn->prepare($dbstmt);
            $result->execute();
            $count = $result->rowCount();

            // Should have only 1 row that matches the conditions
            if ($count == 0) {
                $userNameCheck = true;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        } finally {
            //$conn = null;
        }

        // Checks for duplicate email
        try {
            $dbstmt = "
                   SELECT email
                   FROM user_DB
                   WHERE email= '$email'
                  ";
            $conn = Database::getDB();
            $result = $conn->prepare($dbstmt);
            $result->execute();
            $count = $result->rowCount();

            // Should have only 1 row that matches the conditions
            if ($count == 0) {
                $emailCheck = true;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        } finally {
            //$conn = null;
        }

        if ($userNameCheck && $emailCheck) {

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
        } else {
            $message = 'There is already a username or email being used.';
        }
    }
}

if ($registerSuccess) {
    header("location: registrationSuccess.php");
    exit();
}

if ($action == 'back') {
    header('location: ../index.php');
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
<main>
    <div class="container">
        <form action="register.php" method="POST">
            <h3>Register Your Account</h3><br>
            <h4>Welcome! Please enter your email, username and password!</h4><br>

            <label>Email:</label>
            <input type="email" name="email_submit" class="form-control"
                   value="<?php echo $email; ?>"/><br>

            <label>Username:</label>
            <input type="text" name="username_submit" class="form-control"
                   value="<?php echo $userNameSubmit; ?>"/><br>

            <label>Password:</label>
            <input type="password" name="password_submit" class="form-control"/><br>

            <label>Confirm Password:</label>
            <input type="password" name="password_confirm" class="form-control"/><br>

            <div id="button">
                <label>&nbsp;</label>
                <input type="submit" value="register" name="action" class="btn btn-primary"><br>
            </div>

            <div id="button">
                <label>&nbsp;</label>
                <input type="submit" value="back" name="action" class="btn btn-primary">
            </div>
        </form>
    </div>
    <p><?php echo nl2br(htmlspecialchars($message)); ?></p>
</main>
</body>
</html>
