<?php //session_start(); ?>

<?php
/**
 * Created by PhpStorm.
 * User: jamesno
 * Date: 3/13/17
 * Time: 5:29 PM
 */

$action = filter_input(INPUT_POST, "action");

if ($action == 'logoff') {
    // clears cookies
    setcookie("loginForm1", '', time() - (300), "/");
    // unsets session
    session_unset();
    session_destroy();
    header('location: ../../index.php');
    exit();
}

?>
