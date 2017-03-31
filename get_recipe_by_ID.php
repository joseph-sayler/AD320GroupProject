<?php

// performs search by recipe ID
		include "recipe_connection.php";
		$col1 = 'image';
		$col2 = 'title';
		$col3 = 'prepTime';
		$col4 = 'cookTime';
		$col5 = 'difficulty';
		$col6 = 'servings';
		$col7 = 'ingredients';
		$col8 = 'instructions';
		$col9 = 'recipeID';
		$data = array();
		$user_input = (isset($_GET['ID'])) ? $_GET['ID'] : "";
		try {
			$stmt = $conn->prepare("SELECT $col1, $col2, $col3, $col4, $col5, $col6, $col7, $col8, $col9 FROM recipe_data WHERE $col9='$user_input';");
			$stmt->execute();
			$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
			foreach ($stmt->fetchAll() as $k=>$v) {
				foreach ($v as $key => $value) {
					$data[$key] = $value;
				}
			}
		}
		catch(PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
		$conn = null;
		echo json_encode($data);



//============ deprecated functions ============\\
// outputs the recipe data after search performed
/*
	function recipe_output($data) {
		if (!empty($data)) {
			echo "<div>";
			echo "<h1>" . $data['title'] . "</h1><br>";
			echo "<img src=\"" . $data['image'] . "\"><br><br>";
			echo "Difficulty: " . $data['difficulty'] . "<br>";
			echo "Cooking Time: ";
			time_output(explode(':', $data['cookTime']));
			echo "<br>";
			echo "Preparation Time: ";
			time_output(explode(':', $data['prepTime']));
			echo "<br>";
			echo "Servings: " . $data['servings'] . "<br><br>";
			echo $data['ingredients'] . "<br>";
			echo $data['instructions'] . "<br>";
			echo "</div>";
		}
	}

// sends username/pass/email to server to register a new user
	function register_form() {
		include "recipe_connection.php";
		$error = $message = $username = $password = $email = $hashpass = '';
		if(isset($_POST['username'])){
			$username = $_POST['username'];
		}
		if(isset($_POST['password'])){
			$password = $_POST['password'];
		}
		if(isset($_POST['email'])){
			$email = $_POST['email'];
		}
		$hashpass = password_hash($password, PASSWORD_DEFAULT);
		$sql = "INSERT INTO user_db (username, password, email) VALUES ('$username', '$hashpass', '$email');";
		try {
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			return "Registration successful";
		} catch(PDOException $e) {
			return "Connection failed: " . $e->getMessage();
		}
		$conn = null;
	}

// formats the time output for prepTime and cookTime in recipe_output
	function time_output($timer1) {
		if ($timer1[0] != 0) {
			if ($timer1[1] == 0 && $timer1[2] == 0) {
				if (ltrim($timer1[0], '0') == 1) {
					echo ltrim($timer1[0], '0') . " hour";
				} else {
					echo ltrim($timer1[0], '0') . " hours";
				}
			} else if ($timer1[1] != 0 && $timer1[2] == 0) {
				if (ltrim($timer1[0], '0') == 1 && ltrim($timer1[1], '0') == 1) {
					echo ltrim($timer1[0], '0') . " hour and " . ltrim($timer1[1], '0') . " minute";
				} else if (ltrim($timer1[0], '0') > 1 && ltrim($timer1[1], '0') == 1) {
					echo ltrim($timer1[0], '0') . " hours and " . ltrim($timer1[1], '0') . " minute";
				} else if (ltrim($timer1[0], '0') == 1 && ltrim($timer1[1], '0') > 1) {
					echo ltrim($timer1[0], '0') . " hour and " . ltrim($timer1[1], '0') . " minutes";
				} else {
					echo ltrim($timer1[0], '0') . " hours and " . ltrim($timer1[1], '0') . " minutes";
				}
			} else if ($timer1[1] != 0 && $timer1[2] != 0) {
				if (ltrim($timer1[0], '0') == 1 && ltrim($timer1[1], '0') == 1 && ltrim($timer1[2], '0') == 1) {
					echo ltrim($timer1[0], '0') . " hour, " . ltrim($timer1[1], '0') . " minute, and " . ltrim($timer1[2], '0') . " second";
				} else if (ltrim($timer1[0], '0') > 1 && ltrim($timer1[1], '0') == 1 && ltrim($timer1[2], '0') == 1) {
					echo ltrim($timer1[0], '0') . " hours and " . ltrim($timer1[1], '0') . " minute" . ltrim($timer1[2], '0') . " second";
				} else if (ltrim($timer1[0], '0') > 1 && ltrim($timer1[1], '0') > 1 && ltrim($timer1[2], '0') == 1) {
					echo ltrim($timer1[0], '0') . " hours and " . ltrim($timer1[1], '0') . " minutes" . ltrim($timer1[2], '0') . " second";
				} else if (ltrim($timer1[0], '0') > 1 && ltrim($timer1[1], '0') > 1 && ltrim($timer1[2], '0') > 1) {
					echo ltrim($timer1[0], '0') . " hour and " . ltrim($timer1[1], '0') . " minutes" . ltrim($timer1[2], '0') . " seconds";
				} else if (ltrim($timer1[0], '0') == 1 && ltrim($timer1[1], '0') > 1 && ltrim($timer1[2], '0') == 1) {
					echo ltrim($timer1[0], '0') . " hour and " . ltrim($timer1[1], '0') . " minutes" . ltrim($timer1[2], '0') . " second";
				} else if (ltrim($timer1[0], '0') == 1 && ltrim($timer1[1], '0') > 1 && ltrim($timer1[2], '0') > 1) {
					echo ltrim($timer1[0], '0') . " hour and " . ltrim($timer1[1], '0') . " minutes" . ltrim($timer1[2], '0') . " seconds";
				} else {
					echo ltrim($timer1[0], '0') . " hour and " . ltrim($timer1[1], '0') . " minute" . ltrim($timer1[2], '0') . " seconds";
				}
			}
		} else if ($timer1[0] == 0 && $timer1[1] != 0) {
			if ($timer1[2] == 0) {
				if ($timer1[1] == 1) {
					echo ltrim($timer1[1], '0') ." minute";
				} else {
					echo ltrim($timer1[1], '0') ." minutes";
				}
			} else if ($timer1[2] != 0) {
				if ($timer1[1] == 1 && $timer[2] == 1) {
					echo ltrim($timer1[1], '0') . " minute, and " . ltrim($timer1[2], '0') . " second";
				} else if ($timer1[1] > 1 && $timer[2] == 1) {
					echo ltrim($timer1[1], '0') . " minutes, and " . ltrim($timer1[2], '0') . " second";
				} else {
					echo ltrim($timer1[1], '0') . " minute, and " . ltrim($timer1[2], '0') . " seconds";
				}
			}
		} else {
			echo "not available";
		}
	}
*/
?>
