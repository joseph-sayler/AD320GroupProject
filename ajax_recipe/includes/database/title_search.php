<?php
// File that queries database
require('recipes_db.php');

  function is_ajax_request() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
      $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
  }




// reset($_POST);

//Processes Data -- Makes Calls to Database
if(is_ajax_request()){

  $result = RecipesDB::getRecipesByTitle($title);
  // print_r($result);
  // // ."\n";
  foreach ($result as $key) {
       echo $key."\n";
    }
}

?>
