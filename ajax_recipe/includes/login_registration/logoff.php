<?php

$action = filter_input(INPUT_POST, "action");

if ($action == 'logoff') {
    // clears cookies
    setcookie("loginForm1", '', time() - (300), "/");
    // unsets session
    session_unset();
    session_destroy();
    header($_SERVER['REQUEST_URI'].'ajax_recipe/index.php');
    exit();
}

?>
