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


if(is_ajax_request()){


foreach ($input_array as $ingredient) {
  $result = RecipesDB::getRecipesByIngredients($ingredient);
}
// $recipes = array();

foreach ($result as $key) {
   echo $key."\n";
}



// print_r($recipes);



// $recipes = array();
// $count = 0;
// foreach ($result as $value) {
//   array_push($recipes, $value);
  
// }
// foreach ($recipes as $value) {
//   echo $value[$count;];
//   $count++;
// }
// echo $recipes[$count];

} 





?>
