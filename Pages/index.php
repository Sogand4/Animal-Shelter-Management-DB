<?php 


include("../connection.php");
include("functions.php");

$user_data = check_login($db_conn);

?>

<!DOCTYPE html>
<html>
<head>
	<title>My website</title>
</head>
<body>

	<h1>This is the index page</h1>

	<br>
	Hello, Username
</body>
</html>