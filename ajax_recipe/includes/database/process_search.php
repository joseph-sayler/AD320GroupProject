<?php
// File that queries database
require('recipes_db.php');

  function is_ajax_request() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
      $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
  }

$input_array = array();
$counter = 1;
foreach ($_POST as $key => $value) {
  ${'ingredient'.$counter} = $value;
  array_push($input_array, ${'ingredient'.$counter});
  $counter++;
}
reset($_POST);

//Processes Data -- Makes Calls to Database
if(is_ajax_request()){

  // Check How many ingredients are neing searched on
  // If they are searching by more than one ingredient, process data with temp-table
  if(sizeof($input_array)>=2){
    $result = RecipesDB::getRecipesMultiIngredientSearch($input_array);
  //   echo $result;
    // print_r($result);
    foreach ($result as $key) {
       echo $key."\n";
    }
  } else {
  	foreach ($input_array as $ingredient) {
  		$result = RecipesDB::getRecipesByIngredients($ingredient);
  	}
  	foreach ($result as $key) {
  	   echo $key."\n";
  	}
  }
}

?>
