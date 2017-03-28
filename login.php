<?php
	
	include "recipe_connection.php";
	// initializes all variables
	$error = $message = $username = $password = $hashpass = '';
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
			$stmt = $conn->prepare("SELECT username, password FROM user_db WHERE username='$username'");
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
				echo "Connection failed: " . $e->getMessage();
		}
		$conn = null;
		$hashpass = $result['password'];
		if (!empty($result) && $result['username'] == $username) {
			// checks result variable not empty and username matches
			if (password_verify($password, $hashpass)) {
				//checks if password matches and then sets cookies if
				// remember is not null
				if (!is_null($remember)) {
					$message = "Login remembered";
					setcookie('username', $username, time() + 3600, "/");
					setcookie('password', $hashpass, time() + 3600, "/");
				}
				include "welcome.php";
			} else {
				// displays error if password incorrect
				$error = "password incorrect";
				include "login_page.php";
			}
		} else {
			// displays error if no username found
			$error = "no username found";
			include "login_page.php";
		}
	} else if (isset($_POST['logout'])) {
		// this removes cookies, clears username/password values
		// and displays the login page
		setcookie('username', $username, time() - 3600, "/");
		setcookie('password', $hashpass, time() - 3600, "/");
		$username = '';
		$password = '';
		$error = "You have been logged out.";
		include "login_page.php";
	} else {
		if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
			// this sets username/password values and displays the welcome screen
			$username = $_COOKIE['username'];
			$password = $_COOKIE['password'];
			include "welcome.php";
		} else {
			// this displays the main login screen when cookies are not set
			include "login_page.php";
		}
	}

?>
