<?php session_start(); ?>

<?php

require 'connectDB.php';

$action = '';

$action = filter_input(INPUT_POST, 'action');

// Checks if cookies are on
if(!isset($_COOKIE["loginForm1"])) {
    if (!isset($_SESSION['user'])) {
        header('location: index.php');
        exit();
    }
}

if ($action == 'logoff') {
    // clears cookies
    setcookie("loginForm1", '', time() - (300), "/");
    setcookie("password", '', time() - (300), "/");
    // unsets session
    session_unset();
    session_destroy();
    header('location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login to Database</title>
</head>
<body>
<header>
    <h1>Database Login</h1>
</header>
<main>
    <form action="success.php" method="POST">
        <div id="success">
            You have logged in successfully!<br><br>
        </div>

        <div id="button">
            <label>&nbsp;</label>
            <input type="submit" value="logoff" name="action"><br>
        </div>
    </form>
</main>
</body>
</html>