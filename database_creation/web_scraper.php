<?php
    // Defining the basic cURL function
    // Defining the basic cURL function
    function curl($url) {
        // Assigning cURL options to an array
        $options = Array(
            CURLOPT_RETURNTRANSFER => TRUE,  // Setting cURL's option to return the webpage data
            CURLOPT_FOLLOWLOCATION => TRUE,  // Setting cURL to follow 'location' HTTP headers
            CURLOPT_AUTOREFERER => TRUE, // Automatically set the referer where following 'location' HTTP headers
            CURLOPT_CONNECTTIMEOUT => 120,   // Setting the amount of time (in seconds) before the request times out
            CURLOPT_TIMEOUT => 120,  // Setting the maximum amount of time for cURL to execute queries
            CURLOPT_MAXREDIRS => 10, // Setting the maximum number of redirections to follow
            CURLOPT_USERAGENT => "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1a2pre) Gecko/2008073000 Shredder/3.0a2pre ThunderBrowse/3.2.1.8",  // Setting the useragent
            CURLOPT_URL => $url, // Setting cURL's URL option with the $url variable passed into the function
        );
         
        $ch = curl_init();  // Initialising cURL 
        curl_setopt_array($ch, $options);   // Setting cURL's options using the previously assigned array data in $options
        $data = curl_exec($ch); // Executing the cURL request and assigning the returned data to the $data variable
        curl_close($ch);    // Closing cURL 
        return $data;   // Returning the data from the function 
    }

            // Defining the basic scraping function
    function scrape_between($data, $start, $end){
        $data = stristr($data, $start); // Stripping all data from before $start
        $data = substr($data, strlen($start));  // Stripping $start
        $stop = stripos($data, $end);   // Getting the position of the $end of the data to scrape
        $data = substr($data, 0, $stop);    // Stripping all data from after and including the $end of the data to scrape
        return $data;   // Returning the scraped data from the function
    }
    
    
    	$continue = TRUE;
    	$scraped_urls = array();
    	$url = "http://thepioneerwoman.com/cooking_cat/all-pw-recipes";
     	while ($continue == TRUE) {
    		$results_page = curl($url);
    		$results_data = scrape_between($results_page, '<div class="container category-with-latest-filter-results" id="category-filter-results">', '<nav class="navigation pagination" role="navigation">');
    		$results_array = explode('<div class="col-sm-3">', $results_data);
    		array_shift($results_array);
    		
		    foreach ($results_array as $result) {
		    	$new_url = scrape_between($result, '<a class="post-card-permalink" href="', '"');
		    	array_push($scraped_urls, $new_url); 
		    }
		    

			//Search for next link
	        if (strpos($results_page, "Next")) {
	            $continue = TRUE;
	            $url = scrape_between($results_page, '<a class="next page-numbers" href="', '"');
	        } else {
	            $continue = FALSE;  // Setting $continue to FALSE if there's no 'Next' link
	        }
	        //sleep(rand(3,5));   // Sleep for 3 to 5 seconds. Useful if not using proxies. We don't want to get into trouble.
    	}

    	
    
	foreach ($scraped_urls as $recipes) {
		$recipe_page = curl($recipes);
		$recipe_data = scrape_between($recipe_page, '<div class="recipe-summary wide">', '<div class="entry-sidebar">');
		echo $recipe_data;
	}

	
	


#post-90585 > div > div.entry-content > div
    // foreach ($separate_results as $separate_result) {
    //     if ($separate_result != "") {
    //         $results_urls[] = scrape_between($separate_result, 'href="', '">');
    //     }
    // }
    // print_r($results_urls);

    // foreach ($results_urls as $result) {
    // 	$page = curl($result);
    // 	$page_data = scrape_between($page, '<li  class="active" >', '<nav class="navigation pagination"');
    // 	$page_data_urls[] = scrape_between($page_data, '<a class="post-card-permalink" href="', '">');
    // }

    //print_r($page_data_urls);
    


// ///////////////////////////////////////////////////////////

//Scrapes a the pioneer womans printable recipes

    // ///////////////////////////////////////////////////////////
    // $scraped_website = curl("http://thepioneerwoman.com/cooking/macaroni-cheese/");  // Executing our curl function to scrape the webpage http://www.example.com and return the results into the $scraped_website variable

    // $scraped_page = curl("http://thepioneerwoman.com/cooking/macaroni-cheese/?printable_recipe=11497");    // Downloading IMDB home page to variable $scraped_page
    // $scraped_data = scrape_between($scraped_page, '<div class="col-right">', "</div>");   // Scraping downloaded dara in $scraped_page for content between <title> and </title> tags
     
    // echo $scraped_data; // Echoing $scraped data, should show "The Internet Movie Database (IMDb)"



// ///////////////////////////////////////////////////////////




?>