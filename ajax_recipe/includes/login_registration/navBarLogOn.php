<?php //session_start(); ?>

<?php
/**
 * Created by PhpStorm.
 * User: jamesno
 * Date: 3/12/17
 * Time: 4:25 PM
 */
?>
<!DOCTYPE html>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">Gotta Eat</a>
        </div>
        <ul class="nav navbar-nav">
            <li class="active"><a href="index.php">Home</a></li>
        </ul>
        <form class="navbar-form navbar-right" method="POST">
            <input type="checkbox" name="remember">
            <label>Remember me!</label>
            <div class="form-group">
                <input type="text" class="form-control" name="user_name" placeholder="Username">
            </div>
            <div class="form-group">
                <input type ="password" class="form-control" name="password" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-primary" value="login" name="action">Submit</button>
            <a href="includes/login_registration/register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a>
        </form>
    </div>
</nav>
</body>
