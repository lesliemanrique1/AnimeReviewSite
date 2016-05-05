<html lang = "en">
<head> 
	<title> ANIME BATTOSAI </title> 
	<meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
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
	        <li class="active"><a href="lamp.html">Home</a></li>
	        <li><a href="about.html">About Us</a></li> 
	        <li><a href="list.php">Anime List</a></li> 
	        <li><a href="contact.php">Contact Us</a></li> 
	      </ul>
	    </div>
	  </div>
	</nav>
	<h2 align = 'center' > ADD USER </h2> 
	<?php
		include('db_config.php');
		$db_link = new mysqli($db_server, $db_user, $db_password, $db_name);

		$valid = 1; 

		date_default_timezone_set("America/New_York");
		
		if (isset($_POST["submit-user"])) 
		{
			$first = $_POST['first'];
			$first = preg_replace('/\s+/', '', $first);
			$last= $_POST['last'];
			$last = preg_replace('/\s+/', '', $last);
			$username = $_POST['usr'];
			$username = preg_replace('/\s+/', '', $username);
			$email = $_POST['email'];
			$email = preg_replace('/\s+/', '', $email);
			$password  = $_POST['pwd'];
			$password = preg_replace('/\s+/', '', $password);
			$date = date("m/d/y"); 
			$date = date("m/d/Y", strtotime($date));

			$user_query = "SELECT username, email from users";
			
			$response = mysqli_query($db_link,$user_query) or die("Query failed : " . mysql_error());
			
			while($line = mysqli_fetch_array($response, MYSQL_ASSOC))
			{
				$user = $line['username'];
				$em = $line['email'];
				if($username == $user)
				{
					$valid = 0; 
					print("<p> Sorry, Username is already in use. </p> \n"); 
				}
				if($email == $em )
				{
					print("<p> Sorry, Email is already in use. </p> \n");
				}
			}


			if($valid == 1)
			{	
				$sql = "INSERT INTO users VALUES( '$username' , '$password' , '$first', '$last' , '$email' , '$date' )" ; 
				$result = mysqli_query($db_link,$sql) or die("Query failed : " . mysql_error()); 
				print("<h1 align = 'center'> You are now a registered user! </h2> \n");	


			}
		}
	?>
</body>
</html> 

