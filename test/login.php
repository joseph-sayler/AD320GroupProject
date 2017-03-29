<!DOCTYPE html>
<html>
	<head>
		<title>Login Page</title>
		<style>
		</style>
	</head>
	<body>
		<div align="center">
			<h1>Test Login Page</h1>
			<form method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>">
				<span><?php echo $error; ?></span>
				<br><br>Username: <input name="username" type="text">
				<br><br>Password: <input name="password" type="password">
				<br><br>Remember me! <input name="remember" type="checkbox">
				<br><br><input type="submit" name="submit" value="Submit">
			</form>
		</div>
	</body>
</html>