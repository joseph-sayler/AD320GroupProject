<!DOCTYPE html>
<html>
	<head>
		<title>Login Page</title>
		<style>
		</style>
	</head>
	<body>
		<div align="center">
			<h1>Welcome to your account!</h1>
			<form method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>">
			<br>Username: <?php echo $username."<br>".$message; ?>
			<br><br><input type="submit" name="logout" value="LogOut"></p>
		</div>
	</body>
</html>
