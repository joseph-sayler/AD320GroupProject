<?php
require_once('database.php');

class RecipesDB {

	public static function getRecipesByIngredients($ingredients){
		$db = Database::getDB();
		$i = "%$ingredients%";
		$query = "SELECT DISTINCT a.recipeID, a.image, a.title, a.servings, a.prepTime, a.cookTime, a.instructions FROM recipe_data a WHERE a.ingredients LIKE :i";
            $statement = $db->prepare($query);
            $statement->bindValue(':i', $i);
            $statement->execute();
            $json = array();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
		while($result != null ){
			$j = json_encode($result);
			if (!empty($j)) {
				array_push($json, $j);
			}
			$result = $statement->fetch(PDO::FETCH_ASSOC);
		}
            $statement->closeCursor();
            return $json;
	}

	public static function getRecipeIngredients($recipe_id){
		$db = Database::getDB();
		$query = "SELECT ia.ingredient_quantities, ia.ingredient_name FROM Ingredients ia WHERE ia.recipe_id = :id";
		$statement = $db->prepare($query);
            $statement->bindValue(':id', $recipe_id);
            $statement->execute();
            $json = array();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
		while($result != null ){
			$j = json_encode($result);
			if (!empty($j)) {
				array_push($json, $j);
			}
			$result = $statement->fetch(PDO::FETCH_ASSOC);
		}
            $statement->closeCursor();
            return $json;
	}

	public static function getRecipesMultiIngredientSearch($ingredients_array){
		$db = Database::getDB();
		$ingreds = $ingredients_array;
		$query1 = "SELECT DISTINCT a.recipeID, a.image, a.title, a.servings, a.prepTime, a.cookTime, a.instructions FROM recipe_data a WHERE a.ingredients LIKE ";
		$count = 1;
		foreach ($ingreds as $value) {
			if($count == sizeof($ingreds)){
				$query1 .= ":".$count;
			} else {
				$addOn = ":".$count." AND a.ingredients LIKE ";
				$query1 .= $addOn;
			}
			$count++;
		}
		$statement = $db->prepare($query1);
		$count = 1;
		foreach ($ingreds as $value) {
			$ing = "%".$value."%";
			$statement->bindValue(":".$count, $ing);
			$count++;
		}
		$statement->execute();
            $json = array();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
		while($result != null ){
			$j = json_encode($result);
			if (!empty($j)) {
				array_push($json, $j);
			}
			$result = $statement->fetch(PDO::FETCH_ASSOC);
		}
            $statement->closeCursor();
            return $json;
	}

}


?>
