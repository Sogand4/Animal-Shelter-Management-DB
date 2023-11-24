<?php 

include("../connection.php");

?>

<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
</head>
<body>
	
	<h1>Welcome to your Animal Shelter Management System!</h1>

	<h3>If you wish to reset the system press on the reset button on the navigation bar.
		If this is the first time you're running this page, you MUST use reset button.</h3>

	<h5>Below is some useful information about the shelter you manage: </h5>

	<p>Shelter Name: <?php echo $currShelterName; ?></p>
	<p>Shelter Location: <?php echo $currShelterLoc; ?></p>

	<br>
	Hello, welcome.
</body>
</html>