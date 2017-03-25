<?php include 'navBarlogOff.php';
$action = filter_input(INPUT_POST, 'action');

if (!isset($_SESSION['user'])) {
    header('location: ../index.php');
    exit();
}

if ($action == 'back') {
    session_unset();
    session_destroy();
    header("location: ../index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Success</title>
</head>
<body>
<header>

</header>
<main>
    <div class="container">
        <form action="register.php" method="POST">
            <h1>Success!</h1>
            <h5>You have successfully registered!</h5>

            Press the button to go back to the login screen.
            <div id="button">
                <label>&nbsp;</label>
                <input type="submit" value="back" name="action" class="btn btn-primary"><br>
            </div>
        </form>
    </div>
</main>
