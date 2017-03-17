<?php session_start(); ?>
<?php include 'navBarLogOn.php'; ?>

<?php
/**
 * Created by PhpStorm.
 * User: jamesno
 * Date: 2/28/17
 * Time: 7:12 PM
 */

require 'connectDB.php';

// Variables
$userName = '';
$userPass = '';
$remember = '';
$message = '';
$loginSuccess = false;
$hashPass = '';

// Retrieve Input into Variables
$userName = filter_input(INPUT_POST, "user_name");
$userPass = filter_input(INPUT_POST, "password");
$remember = isset($_POST["remember"]);

$action = filter_input(INPUT_POST, 'action');

// If user stored cookies or has a session
if (isset($_COOKIE["loginForm1"]) || isset($_SESSION['user'])) {
    if (isset($_COOKIE["loginForm1"])) {
        $userName = $_COOKIE["loginForm1"];
    } else if (isset($_SESSION['user'])) {
        $userName = $_SESSION['user'];
    }

    // Check Credentials
    try {
        $dbstmt = "
                   SELECT UserID
                   FROM user_DB
                   WHERE userName= '$userName'
                  ";
        $result = $conn->prepare($dbstmt);
        $result->execute();
        $count = $result->rowCount();

        // Should have only 1 row that matches the conditions
        if ($count == 1) {
            $loginSuccess = true;
            $_SESSION['user']= $userName;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        $conn = null;
    }
}

// User Submits data through login button
if ($action == 'login') {
    if (empty($userName)) {
        $message = "Please enter a user name.";
    } else if (empty($userPass)) {
        $message = "Please enter a password.";
    } else if (!empty($userName) && (!empty($userPass))) {

        // Check Credentials
        try {
            // Prepare and execute SQL statement
            $dbstmt = "
                       SELECT password
                       FROM user_DB
                       WHERE userName= '$userName'
                       ";
            $result = $conn->prepare($dbstmt);
            $result->execute();
            $count = $result->rowCount();
            $users = $result->fetchAll(PDO::FETCH_ASSOC);

            if ($count == 1) {
                // Fetches password data from associative array
                foreach ($users as $row) {
                    $hashPass = $row['password'];
                }

                // Check if hashed password matches current password
                if (password_verify($userPass, $hashPass)) {
                    $loginSuccess = true;
                    $_SESSION['user'] = $userName;

                    // Set Cookie
                    if ($remember == true) {
                        $cookieValue1 = $userName;
                        setcookie("loginForm1", $cookieValue1, time() + (300), "/");
                    }
                }
            } else {
                $message = "Incorrect username or password. ";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        } finally {
            $conn = null;
        }
    }
}

if ($action == 'register') {
    header("location: register.php");
    exit();
}

if ($loginSuccess) {
    header("location: success.php");
    exit();
}
?>
