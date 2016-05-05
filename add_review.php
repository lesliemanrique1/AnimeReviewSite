
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
			include('db_config.php');
			$db_link = new mysqli($db_server, $db_user, $db_password, $db_name);

			$valid_user = 0; 
			$password_match = 0; 
			$valid_rate = 0; 
			$valid = 0; 

			date_default_timezone_set("America/New_York");

			//echo "Today is " . date("m/d/y") . "<br>";
			
			if (isset($_POST["submit-review"])) 
			{
				$anime = $_POST['title'];
				$username = $_POST['usr'];
				$password = $_POST['pwd'];
				$rating = intval($_POST['rate']);
				$review = $_POST['review'];
				$date = date("m/d/y"); 
				$date = date("m/d/y", strtotime($date));


				$user_query = "SELECT username, password from users";
				$response = mysqli_query($db_link,$user_query) or die("Query failed : " . mysql_error());
				while($line = mysqli_fetch_array($response, MYSQL_ASSOC))
				{
					$user = $line['username'];
					$pass = $line['password'];
					if($username == $user)
					{
						$valid_user = 1; 
						if ($pass == $password)
						{ 
							print("<p id = 'error' > Password matches username!</p>\n"); 
							$password_match = 1; 
						}
						else
						{
							print("<p id = 'error'> Sorry, Your Password and Username Do Not Match! </p> \n"); 

						}
					}
				}

				if(!is_numeric($rating))
				{
					print("<p id = 'error'> Your Rating Must be a Numerical Value From 1-5 </p> \n"); 
				}
				else
				{
					if(($rating>5 ) or ($rating < 1))
					{
						print("<p id = 'error'> Your Rating Must be a Value From 1-5 </p> \n"); 	
					}
					else
					{
						$valid_rate = 1; 
					}
				}

				if($valid_user == 0)
				{
					print("<p id = 'error'> Your Review Could Not Be Processed! </p> \n");
					print("<p id = 'error' > You have entered an incorrect username. </p> \n");
					print("<h3 align = center> Create an Account: </h3> \n");
					print("<form class='form-horizontal' role='form' method='post' action='add_user.php'>\n"); 
						print("\t<div class='form-group'>\n"); 
			        		print("\t\t<label for='first' class='col-sm-2 control-label'>First Name: </label>\n"); 
			        		print("\t\t<div class='col-sm-8'>\n"); 
			            		print("\t\t\t<input type='text' class='form-control' id='first' name='first'  value=' ' required> \n"); 
			       			print("\t\t</div>\n"); 
			   			print("\t</div>\n"); 

			   			print("\t<div class='form-group'>\n"); 
			        		print("\t\t<label for='last' class='col-sm-2 control-label'>Last Name: </label>\n"); 
			        		print("\t\t<div class='col-sm-8'>\n"); 
			            		print("\t\t\t<input type='text' class='form-control' id='last' name='last'  value=' ' required> \n"); 
			       			print("\t\t</div>\n"); 
			   			print("\t</div>\n"); 

						print("\t<div class='form-group'>\n"); 
			        		print("\t\t<label for='usr' class='col-sm-2 control-label'>Username: </label>\n"); 
			        		print("\t\t<div class='col-sm-8'>\n"); 
			            		print("\t\t\t<input type='text' class='form-control' id='usr' name='usr'  value=' ' required> \n"); 
			       			print("\t\t</div>\n"); 
			   			print("\t</div>\n"); 

			   			print("\t<div class='form-group'>\n"); 
			        		print("\t\t<label for='email' class='col-sm-2 control-label'>Email: </label>\n"); 
			        		print("\t\t<div class='col-sm-8'>\n"); 
			            		print("\t\t\t<input type='email' class='form-control' id='email' name='email'  value=' ' required> \n"); 
			       			print("\t\t</div>\n"); 
			   			print("\t</div>\n"); 


			   			print("\t<div class='form-group'>\n"); 
			        		print("\t\t<label for='pwd' class='col-sm-2 control-label'>Password: </label>\n"); 
			        		print("\t\t<div class='col-sm-8'>\n"); 
			            		print("\t\t\t<input type='password' class='form-control' id='pwd' name='pwd'  value='' required> \n"); 
			       			print("\t\t</div>\n"); 
			   			print("\t</div>\n"); 


			   			print("\t<div class='form-group'>\n");
				        print("\t\t<div class='col-sm-8 col-sm-offset-2'>\n"); 
				            print("\t\t\t<input id='submit-user' name='submit-user' type='submit' value='Send' class='btn btn-primary'>\n"); 
				        print("\t\t</div>\n"); 
				    print("\t</div>\n");  
		    	print("</form>\n");


				}

				
				if(($valid_user  == 1 ) && ($password_match==1) && ($valid_rate == 1))
				{
					$valid =1; 
				}
				if($valid ==1)
				{
					print("<h1 align = 'Center'>  Your Review Has Been Processed!</h1> \n"); 	
					$sql = "INSERT INTO reviews VALUES( '$anime' , '$username' , '$review', '$rating' , '$date' )" ; 
					$result = mysqli_query($db_link,$sql) or die("Query failed : " . mysql_error()); 

					


				}
			}

			

			


			 

			//echo $anime;
		?>
	</body> 
</html> 
