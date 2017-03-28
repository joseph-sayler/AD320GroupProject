<?php
	// web page parser for AD320 project
	
function parse_webpage($webPage) {
	
	// pulls file in as a string
	$page = file_get_contents($webPage);
/*
	breaks the above string down into substrings by looking at text between the html comment tag; all text between
	such tag is put in its own element (this code produces an extra empty element at the end of the array for some reason)
*/
	$page_array = explode('<!-- .recipe-summary -->', $page);
/*
	formats each element in the array as follows:
		$get_substr contains the substring between 2 html tags that we want to remove the array element
		$rm_substr replaces the text in $get_substr with an empty string
		the remaining string is then stripped of all HTML tags and stored in the last index of the array
*/
	foreach ($page_array as $recipe) {
		$get_substr = get_string_between("<p class=\"dateline\">", "</span>", $recipe);
		$rm_substr = str_replace($get_substr, '', $recipe);
		// preg_replace removes all extra whitespace (lines, tabs, etc)
		$recipe_array[] = preg_replace("/\s+/", " ", strip_tags($rm_substr, "<br>, <img>, <li>, <dl>, <dt>")) . "<p>";
		// the appended <p> tag is so the instructions text can be parsed out later...
	}
	// removes that last index to prevent problems later on
	$new_recipe_array = array_diff($recipe_array, array(' <p>'));
/*
	pulls each recipe item out of a recipe and stores all of them in another array;
	compact is used to create an associative array with the variable names as keys;
	the last line puts each array of recipe items into a master array of recipes
*/
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
	// test statements
	//var_dump($master_array);
	/*foreach ($master_array as $test_array) {
		foreach ($test_array as $key => $value) {
			echo $key . ": " . $value . "<br>";
		}
		echo "<br><hr><br>";
	}*/
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