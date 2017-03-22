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
           <input type="text" name="ingredient1" class="form-control" value="hamburger">
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
            <input type="text" id="title" name="title" class="form-control" value="hamburger">
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
<?php include('public.js'); ?>
