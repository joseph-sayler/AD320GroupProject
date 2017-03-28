<?php

require('recipes_db.php');

	if($_POST){
	$id = $_POST['recipe_id'];
	$result = RecipesDB::getRecipesByTitle($id);
		foreach ($result as $key) {
		   echo $key."\n";
		}
	}

?>
