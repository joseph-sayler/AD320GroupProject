<?php
// require('includes/database/process_search.php');
 // calls header to display
include('views/header.php');

?>

<div class="container">
	
	<!-- This is the original content displayed when the page loads. -->
	 <div class="row">
	      <p>Welcome to our recipe search. There are over 700 recipes in our database. Please enter an ingredient in the box below to find recipes that contain this ingredient.</p>
	      <form id="search" action="includes/database/process_search.php" method="POST">
       
	      <!-- Ingredient Input -->
	      <div id="ingredientInput" class="form-group">
	      	<label for="ingredients[]">Ingredient 1:</label>
	         <input type="text" name="ingredient1" class="form-control" value="onion">
	      </div>
	     <!-- Add another ingredient to search -->
	     <!--  <div class="form-group">
	      	<input type="button" value="Add another ingredient +" onClick="addInput('ingredientInput');">
	      </div> -->

	      <!-- Search Submit -->
	      <div class="form-group">
		      <input id="submit" type="button" class="btn btn-default" value="Search" />
	      </div>
	      </form>

	 </div>
   <!-- end row -->


	<!-- The results area -->
	 <div id="result" class="row">
   
    <div id="recipes" class="col-md-6">
       <h2>Search Results:</h2>
       <div class="list-group">
         
       </div>
     </div>
     <div class="panel md-col-6">
        <div class="recipe-panel"></div>
     </div>
     
   </div>
    <!-- end row -->


    </div>
<!-- end container -->




<!-- The JavaScript to process form -->
<script>

  // Tracks the number of inputs being added
  // var counter = 2;
  // function addInput(divName){
  //   var newLabel = document.createElement('label');
  //   newLabel.htmlFor = "ingredients[]";
  //   newLabel.innerHTML = "Ingredient " + counter + ":";
  //   var newIngredient = document.createElement('div');
  //   newIngredient.innerHTML = "<input type='text' name='ingredient"+counter+"' class='form-control'>";
  //   document.getElementById(divName).appendChild(newLabel);
  //   document.getElementById(divName).appendChild(newIngredient);
  //   counter++;
  // }

  var result_div = document.getElementById("result");
  var recipes = document.getElementById("recipes");
  var button = document.getElementById("submit");
  var action = document.getElementById("search");
  var form = document.getElementById("search");
  var resultHTML = '';
  var recipe_title = '';
  var recipes = [];

  function clearResult() {
    recipes.innerHTML = '';
    result_div.style.display = 'none';
  }

  function postResult(value) {
        $("#recipes").append(value);
        result_div.style.display = 'block';
  }

  function makeRecipeCard(title, id, image, prep_time, cook_time, instructions) {
     
      item = $('<a href="#" class="list-group-item">'+title+'</a>');
      postResult(item);
      item.bind('click', function () {
         recipe_title = title;
         $.post("includes/database/get_ingredients.php", {
          recipe_id: id
         }, 
         function(data){
          ingredientsHTML = '<ul>';
          var strLines = data.split("\n");
          for (var i in strLines) {
                if(strLines[i].length!= 0){
                var obj = JSON.parse(strLines[i]);
                var str = obj['ingredient_quantities']+' '+obj['ingredient_name'];
                ingredientsHTML += '<li>'+str+'</li>'
                }
              }
            ingredientsHTML += '</ul>';
            makeRecipeDisplay(recipe_title, image, prep_time, cook_time, ingredientsHTML, instructions);
         });
      });
  }

function makeRecipeDisplay(title, image, prep_time, cook_time, ingredients, instructions){
    var html = '<h2>Selected Recipe:</h2>';
    html += '<div class="panel panel-default col-md-6"><div class="panel-heading text-center"><h2>'+recipe_title+'</h2></div>';
    html += '<div class="panel-body"><img class="img-responsive" src="'+image+'" alt="'+recipe_title+'"/>';
    html += '<br><p>Prep Time: '+prep_time+'</p><p>Cook Time: '+cook_time+'</p>';
    html += '<p>Ingredients:</p>'+ingredients+'</div>';
    html += '<div class="panel-footer"><p>Instructions:</p><p>'+instructions+'</p></div>';
    $(".recipe-panel").html(html);
  }

  function searchRecipes(){
    clearResult();
        
        var form = document.getElementById("search");

        var form_data = new FormData(form);
        for ([key, value] of form_data) {
          console.log(key + ': ' + value);
        }

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'includes/database/process_search.php', true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onreadystatechange = function () {
          if(xhr.readyState == 4 && xhr.status == 200) {
            var result = xhr.responseText;
            console.log(result);
            var strLines = result.split("\n");
            var counter = 0;
            for (var i in strLines) {
                if(strLines[i].length!= 0){
                var obj = JSON.parse(strLines[i]);
                recipes.push(obj);
                var title = recipes[counter].title;
                var recipe_id = recipes[counter].recipe_id;
                var img = "http://placehold.it/700x400";
                var prep_time = recipes[counter].prepTime;
                var cook_time = recipes[counter].cookTime;
                var instructions = recipes[counter].instructions;
                makeRecipeCard(title, recipe_id, img, prep_time, cook_time, instructions);
                counter++;
              }
            }
             
          }
        };
        xhr.send(form_data);
  }


      button.addEventListener("click", function(event) {
        event.preventDefault();
        searchRecipes();
      });

   
</script>

 <?php
 // calls footer to display
include('views/footer.php');
?>
