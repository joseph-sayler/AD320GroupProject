<?php
require_once('database.php');

class RecipesDB {

	public static function getRecipesByIngredients($ingredients){
		$db = Database::getDB();
		$i = "%$ingredients%";
		$query = "SELECT DISTINCT r.title, r.recipe_id, r.prepTime, r.cookTime, r.servings, r.instructions FROM Recipes r JOIN Ingredients i ON i.recipe_id = r.recipe_id WHERE i.ingredient_name LIKE :i";
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

	

	// public static function getRecipesByMultipleIngredients($ingredients){
	// 	$db = Database::getDB();
	// 	$counter = 1;
	// 	$counter2 = 1;
	// 	$ingredient = array();
	// 	$tableNames = array();
	// 	foreach ($ingredients as $value) {
	// 		${'i'.$counter} = "%$value%";
	// 		${'r'.$counter} = "r".$counter;
	// 		array_push($ingredient, ${'i'.$counter});
	// 		array_push($tableNames, ${'r'.$counter});
	// 		$counter++;
	// 	}
		
		

		
			
			
	// 		foreach ($ingredient as $i) {
	// 			$rtable_placeholder = 'r'.$counter2;
	// 			$itable_placeholder = 'it'.$counter2;
	// 			$ingredient_placeholder = ':i'.$counter2;
	// 			$query = "SELECT DISTINCT ".$rtable_placeholder.".title,".$rtable_placeholder.".recipe_id,".$rtable_placeholder.".prepTime,".$rtable_placeholder.".cookTime,".$rtable_placeholder.".servings,".$rtable_placeholder.".instructions FROM Recipes ".$rtable_placeholder;
	// 			$counter2++;
	// 		if($counter2 = 2 && $counter = 2){

	// 			$query .= "(SELECT ".$rtable_placeholder.".recipe_id FROM Recipes " . $rtable_placeholder . " JOIN Ingredients ".$itable_placeholder." ON ".$rtable_placeholder.".recipe_id = ".$itable_placeholder.".recipe_id WHERE " .$itable_placeholder.".ingredient_name LIKE :i1)";
	// 			$query .= "AND ".$itable_placeholder.".ingredient_name LIKE :i2 ;";
	// 		} else {
	// 			 if($counter2 == 1  && $counter > 2){
	// 			 }
				
	// 			if($counter2 == $counter){
	// 				$query .= "AND ".$itable_placeholder.".ingredient_name LIKE ".$ingredient_placeholder.";";
	// 			}
	// 		 else {
	// 			$query .= "(SELECT ".$rtable_placeholder.".recipe_id FROM Recipes " . $rtable_placeholder . " JOIN Ingredients ".$itable_placeholder." ON ".$rtable_placeholder.".recipe_id = ".$itable_placeholder.".recipe_id WHERE " .$itable_placeholder.".ingredient_name LIKE ".$ingredient_placeholder.")";
	// 		}
				
			
	// 	}
			
	// 	}
	// 	return $query;
	// }

		// $query .= " JOIN Ingredients " . $itable_placeholder . " ON ".$itable_placeholder.".recipe_id = ".$rtable_placeholder.".recipe_id WHERE ".$rtable_placeholder.".recipe_id IN ";


  //           $statement = $db->prepare($query);
  //           $statement->bindValue(':i', $i);
  //           $statement->execute();
  //           $json = array();
  //           $result = $statement->fetch(PDO::FETCH_ASSOC);
		// while($result != null ){
		// 	$j = json_encode($result);
		// 	if (!empty($j)) {
		// 		array_push($json, $j);
		// 	}
		// 	$result = $statement->fetch(PDO::FETCH_ASSOC);
		// }
  //           $statement->closeCursor();
  //           return $json;

	// SELECT r.title, ia.ingredient_quantities, ia.ingredient_name FROM Recipes r JOIN Ingredients ia WHERE ia.recipe_id = 2 AND r.recipe_id = 2

	// SELECT ia.recipe_id, ia.ingredient_quantities, ia.ingredient_name
	// FROM Ingredients ia
	// WHERE ia.recipe_id IN (
	// SELECT r.recipe_id
	// FROM Recipes r 
	// JOIN Ingredients i
	// ON  r.recipe_id = i.recipe_id
	// WHERE i.ingredient_name LIKE '%onion%')


//Filters Recipes By Multiple Ingredients (below)

// SELECT DISTINCT ra.title, ra.recipe_id, ra.prepTime, ra.cookTime, ra.servings, ra.instructions
// FROM Recipes ra
// JOIN Ingredients ia 
// ON ia.recipe_id = ra.recipe_id
// WHERE ra.recipe_id IN 
// (SELECT rb.recipe_id
// FROM Recipes rb
// JOIN Ingredients i
// ON  rb.recipe_id = i.recipe_id
// WHERE i.ingredient_name LIKE '%onion%')
// AND ia.ingredient_name LIKE '%cheese%'

}


?>
