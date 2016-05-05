
<html lang = "en">
<head> 
	<title> ANIME BATTOSAI </title> 
	<meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	  <link rel="stylesheet" type="text/css" href="lamp.css" />
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head> 
<body> 

	<?php
		ini_set('display_errors', true);
		ini_set('display_startup_errors', true);
		error_reporting(E_ALL);

		
		include('db_config.php');
		$db_link = new mysqli($db_server, $db_user, $db_password, $db_name);
		if ($db_link->connect_errno) {
		}
		
		
	?>
	<nav class="navbar navbar-inverse">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <a class="navbar-brand" href="lamp.html">Anime Battosai</a>
	    </div>
	   	<div>
	      <ul class="nav navbar-nav">
	        <li class="active"><a href="lamp.html">Home</a></li>
	        <li><a href="about.html">About Us</a></li> 
	        <li><a href="list.php">Anime List</a></li> 
	        <li><a href="contact.php">Contact Us</a></li> 
	      </ul>
	    </div>
	  </div>
	</nav>
	<?php 
		$anime_id = 8; 
		$titleq = "SELECT title from anime WHERE anime_id = " .$anime_id . " "; 
		$response = mysqli_query($db_link,$titleq) or die("Query failed : " . mysql_error());
		$array = mysqli_fetch_array($response, MYSQL_ASSOC);
		$title = $array["title"];
		print("<h1> $title </h1>"); 
	?>
	

	<div class="container-fluid">
	  <div class="row">
	    <div class="col-sm-3">
	    	<?php 
				
				$image = "Select image from image WHERE anime_id = " . $anime_id . " "; 
				$response = mysqli_query($db_link,$image) or die("Query failed : " . mysql_error());
				$image_array = mysqli_fetch_array($response, MYSQL_ASSOC);
	   			$theimage = $image_array['image']; 
	   			print("<img src = '$theimage' alt= 'anime' style='width:200px;height:280px;'' >\n" ); 
			?>
	    </div>
	    <div class="col-sm-9">
	    	<?php
	    		$synopsis = "Select synopsis FROM anime WHERE anime_id = " . $anime_id . " "; 
	    		$response = mysqli_query($db_link,$synopsis) or die("Query failed : " . mysql_error());
	    		$array = mysqli_fetch_array($response, MYSQL_ASSOC);
	    		$thesyn = $array['synopsis'];
	    		print("<h2> Synopsis </h2> \n");
	    		print("<p id = 'synopsis' > $thesyn </p> \n"); 
	    	?> 
	    </div>
	  </div>
	</div>
	<div class="container">
		 <a href="#" class="btn btn-info" align = "right" role="button" style="float: right;">Find Out More</a>
	</div>
	<h2> Reviews </h2> 
	<?php 
		//Obtain reviews 
		$review_query = "SELECT username, review, date_posted, star_rating from reviews WHERE anime_id = " . $anime_id . " ";
		$response = mysqli_query($db_link,$review_query) or die("Query failed : " . mysql_error());
		$line; 
		while($line = mysqli_fetch_array($response, MYSQL_ASSOC))
		{
				date_default_timezone_set("America/New_York");
				$username = $line['username'];
				$username = preg_replace('/\s+/', '', $username);
				$date = $line['date_posted']; 
				$date = preg_replace('/\s+/', '', $date);
				$date = date("m/d/Y", strtotime($date));
				$review = $line['review']; 
				$star = intval($line['star_rating']);
				$star = preg_replace('/\s+/', '', $star);

				

				print("\t<div class='table-hover'> \n");           
  				print("\t\t<table class='table'> \n");
    			print("\t\t\t<thead>\n"); 
      			print("\t\t\t\t<tr>\n"); 
       			print("\t\t\t\t\t<th>By $username on $date </th>\n"); 
        		print("\t\t\t\t\t<th align = center>$star</th>\n"); 
        		
        		print("\t\t\t\t</tr>\n"); 
    			print("\t\t\t</thead>\n");
    			print("\t\t\t<tbody>\n");
      			print("\t\t\t\t<tr>\n");
        		print("\t\t\t\t\t<td>$review</td>\n"); 
        		print("\t\t\t\t</tr>\n");
    			print("\t\t\t</tbody>\n");
  				print("\t\t</table>\n");
  				print("\t</div>\n"); 
			}
		
		


			print("<h3 align = center> Add Review </h3> \n");
			print("<form class='form-horizontal' role='form' method='post' action='add_review.php'>\n"); 
				
	   			print("\t<div class='form-group'>\n"); 
	        		print("\t\t<label for='usr' class='col-sm-2 control-label'>Username: </label>\n"); 
	        		print("\t\t<div class='col-sm-8'>\n"); 
	            		print("\t\t\t<input type='text' class='form-control' id='usr' name='usr'  value=' ' required> \n"); 
	       			print("\t\t</div>\n"); 
	   			print("\t</div>\n"); 


	   			print("\t<div class='form-group'>\n"); 
	        		print("\t\t<label for='pwd' class='col-sm-2 control-label'>Password: </label>\n"); 
	        		print("\t\t<div class='col-sm-8'>\n"); 
	            		print("\t\t\t<input type='password' class='form-control' id='pwd' name='pwd'  value='' required> \n"); 
	       			print("\t\t</div>\n"); 
	   			print("\t</div>\n"); 
	    
	    		print("\t<div class='form-group'>\n"); 
	        		print("\t\t<label for='title' class='col-sm-2 control-label'>Title: </label>\n"); 
	        		print("\t\t<div class='col-sm-8'>\n"); 
	        			echo "<h5>". $title. "</h5 >"; 
	            		print("\t\t\t<input type='hidden' class='form-control' id='title' name='title'  value='$anime_id' required> \n"); 
	       			print("\t\t</div>\n"); 
	   			print("\t</div>\n"); 

	   			print("\t<div class='form-group'>\n"); 
	        		print("\t\t<label for='rate' class='col-sm-2 control-label'>Rating (X/5): </label>\n"); 
	        		print("\t\t<div class='col-sm-8'>\n"); 
	            		print("\t\t\t<input type='rate' class='form-control' id='rate' name='rate' value = ''required> \n"); 
	       			print("\t\t</div>\n"); 
	   			print("\t</div>\n");
	    
	    		print("\t<div class='form-group'>\n"); 
	        		print("\t\t<label for='review' class='col-sm-2 control-label'>Review: </label>\n"); 
	        		print("\t\t<div class='col-sm-8'>\n");
	            		print("\t\t\t<textarea class='form-control' rows='4' name='review' value = ''required></textarea>\n"); 
	        		print("\t\t</div>\n"); 
	   			print("\t</div>\n"); 
	    
			    print("\t<div class='form-group'>\n");
			        print("\t\t<div class='col-sm-8 col-sm-offset-2'>\n"); 
			            print("\t\t\t<input id='submit' name='submit-review' type='submit' value='Send' class='btn btn-primary'>\n"); 
			        print("\t\t</div>\n"); 
			    print("\t</div>\n");  
	    	print("</form>\n"); 
	

	
	 	?> 


</body>
</html>
