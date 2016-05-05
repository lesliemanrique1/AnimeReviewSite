<html lang = "en">
<head> 
	<title> ANIME BATTOSAI </title> 
	<meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" type="text/css" href="lamp.css" />
	  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head> 

<body> 
	<nav class="navbar navbar-inverse">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <a class="navbar-brand" href="lamp.html">Anime Battosai</a>
	    </div>
	   	<div>
	      <ul class="nav navbar-nav">
	        <li><a href="lamp.html">Home</a></li>
	        <li><a href="about.html">About Us</a></li> 
	        <li class="active" ><a href="list.php">Anime List</a></li> 
	        <li><a href="contact.php">Contact Us</a></li> 
	      </ul>
	    </div>
	  </div>
	</nav>
	
	<h2 id = "sort_button"> 
	<?php
		ini_set('display_errors', true);
		ini_set('display_startup_errors', true);
		error_reporting(E_ALL);

		
		include('db_config.php');
		$db_link = new mysqli($db_server, $db_user, $db_password, $db_name);
		if ($db_link->connect_errno) {
		#print( "Failed to connect to MySQL: (" .$db_link->connect_errno . ") ".$db_link->connect_error);
		}
		#print("<p>Connection: ".$db_link->host_info . "\n");
		#print("\n<br />Connected successfully</p>\n" );
		
	?>


	<form>

		<select name = "sortby"> 
			<option value = "1"> Ascending</option>
			<option value = "2"> Descending</option> 
			<option value = "3"> Review</option> 
			<option value = "4"> Genre</option> 
		</select> 
		
			<button class = "btn btn-primary" type="submit" formaction="?" formmethod="post">SORT BY </button> 
	
	</form> 
	
</h2>
	

	<?php

		$query; 
		$option = 0; 

		if(isset($_POST["sortby"]))
		{
			if($_POST["sortby"] == 1)
			{
				$query = "SELECT anime.title, COUNT(reviews.review) AS 'Total_Reviews', ROUND(AVG(reviews.star_rating),2) AS 'Average_Rating'FROM anime,reviews WHERE anime.anime_id = reviews.anime_id GROUP BY anime.title ORDER BY anime.title ASC";
			}
			if($_POST["sortby"] == 2)
			{
				//$query = "SELECT title,total_reviews,average_rating  FROM anime ORDER BY title DESC";
				$query = "SELECT anime.title, COUNT(reviews.review) AS 'Total_Reviews', ROUND(AVG(reviews.star_rating),2) AS 'Average_Rating'FROM anime,reviews WHERE anime.anime_id = reviews.anime_id GROUP BY anime.title ORDER BY anime.title DESC";
				
			}
			if($_POST["sortby"] == 3)
			{
				//$query = "SELECT title, total_reviews,average_rating FROM anime ORDER BY total_reviews DESC"; 
				$query = "SELECT anime.title, COUNT(reviews.review) AS Total_Reviews, ROUND(AVG(reviews.star_rating),2) AS 'Average_Rating'FROM anime,reviews WHERE anime.anime_id = reviews.anime_id GROUP BY anime.title ORDER BY Total_Reviews DESC";
				

				
			}
			if($_POST["sortby"] == 4)
			{
				$option = 1; 
				
				$query = "SELECT b.title, b.total_reviews,b.average_rating,a.genre FROM anime b, genre a, anime_genre c  WHERE b.anime_id = c.anime_id AND a.genre_id = c.genre_id ORDER BY genre ASC";  


			}
			

		}
		else
		{
			$query = "SELECT anime.title, COUNT(reviews.review) AS 'Total_Reviews', ROUND(AVG(reviews.star_rating),2) AS 'Average_Rating'FROM anime,reviews WHERE anime.anime_id = reviews.anime_id GROUP BY anime.title ORDER BY anime.title ASC";
			
			
		}


		

		$result = mysqli_query($db_link,$query) or die("Query failed : " . mysql_error());
		print("\n"); 
		print("<div class = 'container'> \n"); 
		print("\t<h2> Anime List </h2>\n"); 
		print("\t<table  class = 'table table-hover' align='center' >\n");
		if($option == 1)
		{
				print("\t<thread>\n");
				print( "\t\t<tr>\n");
				print( "\t\t\t<th>Title</td>\n");
				print( "\t\t\t<th>Total Reviews</td>\n");
				print( "\t\t\t<th>Average Rating</td>\n");
				print( "\t\t\t<th>Genre</td>\n");
				print( "\t\t</tr>\n");
				print("\t</thread>\n");
		}
		else
		{
			
				print("\t<thread>\n");
				print( "\t\t<tr>\n");
				print( "\t\t\t<th>Title</td>\n");
				print( "\t\t\t<th>Total Reviews</td>\n");
				print( "\t\t\t<th>Average Rating</td>\n");
				print( "\t\t</tr>\n");
				print("\t</thread>\n");

		}
		$site_link; 
		
		print("\t<tbody>\n");
		while ($line = mysqli_fetch_array($result, MYSQL_ASSOC)) 
		{	
	   		print( "\t\t<tr>\n");
	   		foreach ($line as $col_value) 
	   		{
	   			

	   			if($line['title'] == $col_value)
	   			{	
	   				$name = $col_value; 
	   				$site_link = "SELECT links FROM anime WHERE title = '$name'"; 
	   				$thesite = mysqli_query($db_link,$site_link) or die("Query failed : " . mysql_error());
	   				
	   				$anime_link = mysqli_fetch_array($thesite, MYSQL_ASSOC);
	   				
	   				$thelink = $anime_link['links'];
	   				
	   			



	  				print( "\t\t\t<td> <a href = '$thelink'> $col_value</a> </td>\n");	
	  			}
	  			else
	  			{
	  				print( "\t\t\t<td>  $col_value </td>\n");
	  			}

	  			//echo $col_value;      		
	  		}
	    	print( "\t\t</tr>\n");
	    	print("\t<tbody>\n");
		}
		print( "\t</table>\n");
		print("</div>\n");
		print("</form\n"); 
		 

			/* Free resultset */
			mysqli_free_result($result);

			/* Closing connection */
			mysqli_close($db_link); 		
	?>
</body>
</html> 
