<div class="container">

	<!-- This is the original content displayed when the page loads. -->
  <div class="row">
    <div class="col-md-12 text-center">
      <h1>Search recipes by:<br></h1>
    </div>
  </div>
   <div class="row">
   <!-- Start Ingredient Search -->
   <div class="col-md-6">
    <h2>Ingredient(s):</h2>
    <p><br>Input ingredients available to you, and we'll return a list of recipes utilizing what's already in your pantry.</p>
    </div>
    <div class="col-md-6">
    <h2>Title:</h2>
    <p><br>Have something in mind? Search for recipes using a keyword (think 'lasagna')</p>
    </div>
    </div>
    <div class="row">
    <form id="search" action="includes/database/process_search.php" method="POST">
       <div class="col-md-6">

        <!-- Ingredient Input -->
        <div id="ingredientInput" class="form-group">
        	<label for="ingredients[]">Ingredient 1:</label>
           <input type="text" name="ingredient1" class="form-control">
        </div>

       <!-- Add another ingredient to search -->
        <div class="form-group">
        	<input type="button" value="Add another ingredient +" onClick="addInput('ingredientInput');">
        </div>

        <!-- Search Submit -->
        <div class="form-group">
  	      <input id="submit" type="button" class="btn btn-default" value="Search" />
        </div>
        </div>
    
    <div class="col-md-6">
        <!-- Title search input-->
        <div id="titleInput" class="form-group">
            <label for="recipe_title">Recipe Title:</label>
            <input type="text" id="title" name="title" class="form-control">
        </div>

        <!-- Title Submit -->
        <div class="form-group">
          <input id="title_submit" type="button" class="btn btn-default" value="Search" />
        </div>

      </div>

    </form>
    </div>
      </div>
        <!-- End  Search -->

      </div>
       <!-- end row -->
   </div>
    <!-- end container -->


 <!-- The JavaScript to process form -->
<script>
$("#title_submit").bind('click', function () {
        recipes = [];
        clearResult();
         var t = document.getElementById("title").value;
         $.post("includes/database/search_title.php", {
          recipe_id: t
         },
         function(data){
          var strLines = data.split("\n");
          // console.log(strLines);
          var counter = 0;
          for (var i in strLines) {
              if(strLines[i].length!= 0){
              var obj = JSON.parse(strLines[i]);
              recipes.push(obj);
              var title = recipes[counter].title;
              var recipe_id = recipes[counter].recipeID;
              var img = recipes[counter].image;
              var prep_time = recipes[counter].prepTime;
              var cook_time = recipes[counter].cookTime;
              var ingredients = recipes[counter].ingredients;
              var instructions = recipes[counter].instructions;
              makeRecipeCard(title, recipe_id, img, prep_time, cook_time, ingredients, instructions);
              counter++;
              }
            }
         });
});


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

  // var result_div = document.getElementById("result");
  var recipes = document.getElementById("recipes");
  var button = document.getElementById("submit");
  var action = document.getElementById("search");
  var form = document.getElementById("search");
  var search_results = document.getElementById("recipe-list");
  var resultHTML = '';
  var recipes = [];

  function clearResult() {
    $("#recipes").empty();
    // result_div.style.display = 'none';
  }

  function postResult(value) {
        $("#recipes").append(value);
        // result_div.style.display = 'block';
  }

  function makeRecipeCard(title, id, image, prep_time, cook_time, ingredients, instructions) {
      item = $('<a href="#" class="list-group-item">'+title+'</a>');

      postResult(item);
      item.bind('click', function (e) {
          e.preventDefault();
          ingredientsHTML = '<ul>'+ingredients+'</ul>';
          makeRecipeDisplay(title, image, prep_time, cook_time, ingredientsHTML, instructions);
      });
  }

function makeRecipeDisplay(title, image, prep_time, cook_time, ingredients, instructions){
    var html = '<h2>Selected Recipe:</h2>';
    html += '<div class="panel panel-default"><div class="panel-heading text-center"><h2>'+title+'</h2></div>';
    html += '<div class="panel-body"><img class="img-responsive center-block" src="'+image+'" alt="'+title+'"/>';
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
            // console.log(result);
            var strLines = result.split("\n");
            var counter = 0;
            for (var i in strLines) {
                if(strLines[i].length!= 0){
                var obj = JSON.parse(strLines[i]);
                recipes.push(obj);
                var title = recipes[counter].title;
                var recipe_id = recipes[counter].recipeID;
                var img = recipes[counter].image;
                var prep_time = recipes[counter].prepTime;
                var cook_time = recipes[counter].cookTime;
                var ingredients = recipes[counter].ingredients;
                var instructions = recipes[counter].instructions;
                makeRecipeCard(title, recipe_id, img, prep_time, cook_time, ingredients, instructions);
                counter++;
              }
            }
            console.log(recipes.length);
          }
        };
        xhr.send(form_data);
  }


      button.addEventListener("click", function(event) {
        recipes = [];
        event.preventDefault();
        searchRecipes();
      });


</script>
