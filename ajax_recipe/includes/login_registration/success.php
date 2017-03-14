<?php session_start(); ?>
<?php include 'navBarlogOff.php'; ?>

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

if ($action == 'back') {
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
    <div class="container">
    <form action="success.php" method="POST">
        <div id="success">
            You have logged in successfully!<br><br>
        </div>

        <div id="button">
            <label>&nbsp;</label>
            <input type="submit" value="back" name="action" class="btn btn-primary"><br>
        </div>
    </form>
    </div>
</main>
</body>
</html>