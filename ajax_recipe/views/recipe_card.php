  <h2>Panel Footer</h2>
  <div class="panel panel-default">
    <div class="panel-heading">Panel Heading</div>
    <div class="panel-body">Panel Content</div>
    <div class="panel-footer">Panel Footer</div>
  </div>

  function makeRecipeDisplay(title, image, prep_time, cook_time, ingredients, instructions){
    var html = '<h2>'+recipe_title+'</h2>';
    html += '<div class="panel panel-default"><div class="panel-heading col-sm-3"><img src="'+image+'" alt="'+recipe_title+'"/></div><div class="panel-heading col-sm-3"><ul><li></li>></ul>></div>';
    </div>';
    $(".recipe-panel").html(html);
  }
<div class="panel panel-default col-md-6"><div class="panel-heading"><h2>'+recipe_title+'</h2></div><div class="panel-body"><ul><li>Prep Time:'+prep_time+'</li></ul><img src="'+image+'" alt="'+recipe_title+'"/></div></div>
