<?php
require_once('database.php');

class RecipesDB {

	public static function getRecipesByIngredients($ingredients){
		$db = Database::getDB();
		$i = "%$ingredients%";
		$query = "SELECT DISTINCT r.title FROM Recipes r JOIN Ingredients i ON i.recipe_id = r.recipe_id WHERE i.ingredient_name LIKE :i";
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
  //           while($result != null ){
		// 	if (!empty($result)) {
		// 		array_push($json, $result);
		// 	}
		// 	$result = $statement->fetch(PDO::FETCH_ASSOC);
		// }
  //           $statement->closeCursor();
  //           return $json;
	}

}


?>
