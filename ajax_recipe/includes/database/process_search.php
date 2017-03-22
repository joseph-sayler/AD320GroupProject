<?php
// File that queries database
require('recipes_db.php');

  function is_ajax_request() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
      $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
  }

$input_array = array();
$counter = 1;
$title = isset($_POST['title']) ? (int) $_POST['title'] : '';
foreach ($_POST as $key => $value) {
    ${'ingredient'.$counter} = $value;
    array_push($input_array, ${'ingredient'.$counter});
    $counter++;
}
reset($_POST);

if(is_ajax_request()){

  $result = RecipesDB::getRecipesMultiIngredientSearch($input_array);
  
  foreach ($result as $key) {
     echo $key."\n";
  }
    
}

?>
