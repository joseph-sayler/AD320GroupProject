<?php
	include 'recipe_function_library.php';
	$message = '';
	if (isset($_POST['submit'])) {
		$message = register_form();
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Register</title>
		<style>
		</style>
	</head>
	<body>
		<div align="center">
			<h1>Account Registration</h1>
			<form method="POST" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>">				
				<label>Email:</label>
				<input type="email" name="email"/><br><br>
				<label>Username:</label>
				<input type="text" name="username"/><br><br>
				<label>Password:</label>
				<input type="password" name="password"/><br><br>
				<label>&nbsp;</label><input type="submit" name="submit" value="Submit">
				<br><br><?php echo $message; ?>
			</form>
		</div>
	</body>
</html>