<?php
    include_once('../routeHandler.php');
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Cats</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
		<!-- Navbar -->
		<nav class="navbar">
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="volunteers.php">Volunteers</a></li>
			<li><a href="adopters.php">Adopters</a></li>
			<li><a href="vets.php">Vets</a></li>
			<li><a href="inspectors.php">Inspectors</a></li>
			<li><a href="events_ws.php">Events and Workshops</a></li>
			<li><a href="animals.php">Animals</a></li>
			<li><a href="animals.php">Cats</a></li>
			<li><a href="animals.php">Dogs</a></li>
			<li><a href="animals.php">Birds</a></li>
			<li><a href="login.php">Logout</a></li>
			<li>
				<form method="POST" action="cats.php">
					<input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
					<p><input type="submit" value="Reset" name="reset"></p>
				</form>
			</li>
		</ul>
	   </nav>

	   <main>
	   <p>If you wish to reset the table press on the reset button on the navigation bar above. If this is the first
			time you're running this page, you MUST use reset</p>
			








	   </main>







	
</body>
</html>