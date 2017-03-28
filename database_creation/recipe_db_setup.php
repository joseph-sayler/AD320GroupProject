<?php

$servername = "localhost";
$username = "root";
$dbname = "recipe_database";
$raw_data = parse_webpage('PW_RECIPES.HTML');

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully\n"; 
    }
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    }

$sql = "CREATE TABLE IF NOT EXISTS recipe_data (
		recipeID INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
		image VARCHAR(200),
		title VARCHAR(100),
		prepTime TIME,
		cookTime TIME,
		difficulty VARCHAR(50),
		servings INT(11),
		ingredients TEXT,
		instructions TEXT)";
try {
	$conn->beginTransaction();
	$conn->exec($sql);
	$conn->commit();
	echo "New records created successfully";
	}
catch(PDOException $e) {
	$conn->rollback();
	echo "Error: " . $e->getMessage();
	}

try {
	$conn->beginTransaction();
	for ($i = 0; $i < count($raw_data); $i++) {
		$cols = implode(", ",array_keys($raw_data[$i]));
	if (trim(substr($raw_data[$i]['prepTime'], 2) == ' Minutes') || trim(substr($raw_data[$i]['prepTime'], 2) == 'Minutes' )) {
		$raw_data[$i]['prepTime'] = trim(substr($raw_data[$i]['prepTime'], 0, 2)) . "00";
	} else {
		$raw_data[$i]['prepTime'] = trim(substr($raw_data[$i]['prepTime'], 0, 2)) . "0000";
	}
	if (trim(substr($raw_data[$i]['cookTime'], 2) == ' Minutes') || trim(substr($raw_data[$i]['prepTime'], 2) == 'Minutes' )) {
		$raw_data[$i]['cookTime'] = trim(substr($raw_data[$i]['cookTime'], 0, 2)) . "00";
	} else {
		$raw_data[$i]['cookTime'] = trim(substr($raw_data[$i]['cookTime'], 0, 2)) . "0000";
	}
		$raw_data[$i]['servings'] = substr($raw_data[$i]['servings'], 0, 2);
		$escaped_values = array_map('mysql_real_escape_string', array_values($raw_data[$i]));
		$vals  = "'" . implode("', '", $escaped_values) . "'";
		$conn->exec("INSERT INTO recipe_data ($cols) VALUES ($vals)");
	}
	$conn->commit();
	echo "New records created successfully";
	}
catch(PDOException $e) {
	$conn->rollback();
	echo "Error: " . $e->getMessage();
	}

$conn = null;

function parse_webpage($webPage) {
	
	$page = file_get_contents($webPage);

	$page_array = explode('<!-- .recipe-summary -->', $page);

	foreach ($page_array as $recipe) {
		$get_substr = get_string_between("<p class=\"dateline\">", "</span>", $recipe);
		$rm_substr = str_replace($get_substr, '', $recipe);
		$recipe_array[] = preg_replace("/\s+/", " ", strip_tags($rm_substr, "<br>, <img>, <li>, <dl>, <dt>")) . "<p>";
	}

	$new_recipe_array = array_diff($recipe_array, array(' <p>'));

	foreach ($new_recipe_array as $fields) {
		$image = "images\\" . get_string_between("<img src=\"PW_RECIPES_files/", "\" alt=", $fields);
		$title = get_string_between("\">", " <dl>", $fields);
		$prepTime = get_string_between("Prep Time:</dt>", "</dl>", $fields);
		$difficulty = get_string_between("Difficulty:</dt>", "</dl>", $fields);
		$cookTime = get_string_between("Cook Time:</dt>", "</dl>", $fields);
		$servings = get_string_between("Servings:</dt>", "</dl>", $fields);
		$ingredients = get_string_between("Ingredients ", " Instructions", $fields);
		$instructions = get_string_between("Instructions ", " <p>", $fields);
		$recipes = compact("image", "title", "prepTime", "difficulty", "cookTime", "servings", "ingredients", "instructions");
		$master_array[] = $recipes;
	}
	return $master_array;
}

// this function adapted from http://stackoverflow.com/questions/5696412/get-substring-between-two-strings-php
function get_string_between($start, $end, $string) {
	$string = ' ' . $string;
	$ini = strpos($string, $start);
	if ($ini == 0) {
		return '';
	}
	$ini += strlen($start);
	$len = strpos($string, $end, $ini) - $ini;
	return substr($string, $ini, $len);
}
?>
