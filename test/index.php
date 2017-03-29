<?php

	// initializes all variables
	$error = $message = $username = $password = '';
	// remember is null until the checkbox is marked
	$remember = NULL;
	// checks if submit button has been pressed
	// if it has, it sets each variable to the value sent via POST
	if (isset($_POST['submit'])) {
		if(isset($_POST['username'])){
			$username = $_POST['username'];
		}
		if(isset($_POST['password'])){
			$password = $_POST['password'];
		}
		if(isset($_POST['remember'])){
			$remember = $_POST['remember'];
		}
		try {
			// mysql login info (remove local login info and replace with class server info)
			$servername = "localhost";
			$dbname = "ad_320_test";
			$dbusername = "root";
			//$dbpassword = "root";
			/*$dbname = "icoolsho_jsayler";
			$dbusername = "icoolsho_jsayler";
			$dbpassword = "$!950-64-3266";*/
			$conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername);//, $dbpassword);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt = $conn->prepare("SELECT username, password FROM assignment8 WHERE username='$username'");
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
				echo "Connection failed: " . $e->getMessage();
		}
		$conn = null;
		if (!empty($result) && $result['username'] == $username) {
			// checks result variable not empty and username matches
			if ($result['password'] == $password) {
				//checks if password matches and then sets cookies if
				// remember is not null
				if (!is_null($remember)) {
					$message = "Login remembered";
					setcookie('username', $username, time() + 3600, "/");
					setcookie('password', $password, time() + 3600, "/");
				}
				include "welcome.php";
			} else {
				// displays error if password incorrect
				$error = "password incorrect";
				include "login.php";
			}
		} else {
			// displays error if no username found
			$error = "no username found";
			include "login.php";
		}
	} else if (isset($_POST['logout'])) {
		// this removes cookies, clears username/password values
		// and displays the login page
		setcookie('username', $username, time() - 3600, "/");
		setcookie('password', $password, time() - 3600, "/");
		$username = '';
		$password = '';
		$error = "You have been logged out.";
		include "login.php";
	} else {
		if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
			// this sets username/password values and displays the welcome screen
			$username = $_COOKIE['username'];
			$password = $_COOKIE['password'];
			include "welcome.php";
		} else {
			// this displays the main login screen when cookies are not set
			include "login.php";
		}
	}

?>
