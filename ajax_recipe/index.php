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
	      <div class="form-group">
	      	<input type="button" value="Add another ingredient +" onClick="addInput('ingredientInput');">
	      </div>

	      <!-- Search Submit -->
	      <div class="form-group">
		      <input id="submit" type="button" class="btn btn-default" value="Search" />
	      </div>
	      </form>

	 </div>

	<!-- The results area -->
	 <div id="result" class="container">
    <div id="recipes" class="row">
    </div>
	 </div>


</div>
<!-- end container -->

<!-- The JavaScript to process form -->
<script>

  // Tracks the number of inputs being added
  var counter = 2;
  function addInput(divName){
    var newLabel = document.createElement('label');
    newLabel.htmlFor = "ingredients[]";
    newLabel.innerHTML = "Ingredient " + counter + ":";
    var newIngredient = document.createElement('div');
    newIngredient.innerHTML = "<input type='text' name='ingredient"+counter+"' class='form-control'>";
    document.getElementById(divName).appendChild(newLabel);
    document.getElementById(divName).appendChild(newIngredient);
    counter++;
  }

  var result_div = document.getElementById("result");
  var recipes = document.getElementById("recipes");
  var button = document.getElementById("submit");
  var action = document.getElementById("search");
  var form = document.getElementById("search");
  var resultHTML = "";
  var recipes = [];

  function clearResult() {
    recipes.innerHTML = '';
    result_div.style.display = 'none';
  }

  function postResult(value) {
        recipes.innerHTML = value;
        result_div.style.display = 'block';
  }

  function makeRecipeCard(title, image) {
    // build the card
    var html = '<div class="card">';
    html += '<img class="img-fluid" src="'+image+'">';
    html += '<div class="card-block">';
    html += '<h4 class="card-title">'+title+'</h4>';
    html += '<a href="#" class="btn btn-primary">More</a></div></div>';
    // append the card
    //$("div#recipes").append(html);
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
            var strLines = result.split("\n");
            var counter = 0;
            for (var i in strLines) {
                if(strLines[i].length!= 0){
                var obj = JSON.parse(strLines[i]);
                recipes.push(obj);
                var t = recipes[counter].title;
                resultHTML = makeRecipeCard(t, "#");
                console.log(t);
                counter++;
              }
            }
            postResult(resultHTML);
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
