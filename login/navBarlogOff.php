<?php
include 'logoff.php';

$userName = $_SESSION['user'];

//$action = filter_input(INPUT_POST, "action");
//
//if ($action == 'logoff') {
//    // clears cookies
//    setcookie("loginForm1", '', time() - (300), "/");
//    // unsets session
//    session_unset();
//    session_destroy();
//    header('location: index.php');
//    exit();
//}

?>
<!DOCTYPE html>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
      integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>

<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header"><!-- all files must reside under ../ajax_recipe/ or this will not work -->
            <a class="navbar-brand" href="<?php echo substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],"login/"))."index.php"?>">Gotta Eat</a>
        </div>
        <ul class="nav navbar-nav"><!-- all files must reside under ../ajax_recipe/ or this will not work -->
            <li class="active"><a href="<?php echo substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],"login/"))."index.php"?>">Home</a></li>
        </ul>
        <form class="navbar-form navbar-right" method="POST">
            <?php echo "Welcome " . $userName . " " ?>
            <button type="submit" class="btn btn-info btn-lg" name="action" value="logoff"> Log out
            </button>

        </form>
    </div>
</nav>
</body>
