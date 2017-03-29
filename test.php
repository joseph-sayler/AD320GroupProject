<?php
	include "recipe_connection.php";
	try {
		$stmt = $conn->prepare("SELECT username, password FROM user_db WHERE username='test'");
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
	} catch(PDOException $e) {
			echo "Connection failed: " . $e->getMessage();
	}
	$conn = null;
	print_r($result);
	
	$pswd = 'test';
	$hashpass = password_hash($pswd, PASSWORD_DEFAULT);
	echo "<br><br>" . $pswd . " hashes to " . $hashpass;
	echo "<br><br>";
	if (password_verify($pswd, $hashpass)) {
		$answer = "true";
	} else {
		$answer = "false";
	}
	echo $pswd . " verifies to " . $hashpass . "? " . $answer;
	
	echo "<br><br><br>";
	echo $result['password'] . "<br><br>";
	echo password_verify('test', $result['password']);
	echo "<br><br><br>";
	
	if (password_verify('tiny', $result['password'])) {
		echo 'Password is valid!';
	} else {
		echo 'Invalid password.';
	}
	
?>