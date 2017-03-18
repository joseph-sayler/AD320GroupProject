<?php session_start(); ?>

<?php

require 'includes/database/database.php';

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
        $conn = Database::getDB();
        $result = $conn->prepare($dbstmt);
        $result->execute();
        $count = $result->rowCount();

        // Should have only 1 row that matches the conditions
        /*if ($count == 1) {
            $loginSuccess = true;
            $_SESSION['user']= $userName;
        }*/
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        $conn = null;
    }
}

// User Submits data through login button
if ($action == 'login') {
  // if userName or userPass are empty, send alert
    if (empty($userName) || empty($userPass)) {
?>
      <script>alert("Please enter a user name and/or password.");</script>
<?php
    } else if (!empty($userName) && (!empty($userPass))) {

        // Check Credentials
        try {
            // Prepare and execute SQL statement
            $dbstmt = "
                       SELECT password
                       FROM user_DB
                       WHERE userName='$userName'
                       ";
            $conn = Database::getDB();
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
                // if userPass does not hash, send alert
                } else {
?>
              <script>alert("Password is incorrect. Please try again.");</script>
<?php
                }
            } else {
// if nothing else works, send alert (this assumes that if no conditions are met, the username is wrong)
?>
              <script>alert("Username is incorrect. Please try again.");</script>
<?php
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        } finally {
            $conn = null;
        }
    }
}

if ($action == 'register') {
    header("location: includes/login_registration/register.php");
    exit();
}

//Everything from here on down will be initially diaplayed when site loads

// checks if session loaded and displays the appropriate navBar
if ($loginSuccess) {
    header("location: includes/login_registration/success.php");
    exit();
}
if(!isset($_SESSION['user'])) {
  include 'includes/login_registration/navBarLogOn.php';
} else {
  include 'includes/login_registration/navBarlogOff.php';
}

// display header
include('views/header.php');

// display search
include('views/search_form.php');
// display search-results
include('views/search_results.php');

// display footer
include('views/footer.php');
?>
