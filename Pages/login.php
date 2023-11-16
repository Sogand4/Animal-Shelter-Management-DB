<?php 

	include("connection.php");
	include("functions.php");

	if(isset($_POST["submit"])){
		$manID = $_POST['manID'];
		$manPassword = $_POST['manPassword'];
		$query = "select * from Manager where manID = '$manID'";
		$result = executePlainSQL($query);

        $query_nrow = "SELECT COUNT(*) FROM Manager";
		$result2 = executePlainSQL($query_nrow);

		$row = oci_fetch_assoc($result);

		if($result2 > 0){
			if($manPassword == $row["manPassword"]){
				header("Location: index.php");
			}

			else{
				echo "wrong username or password!";
			}

		}
		else{
			echo "Please enter some valid information!";
		}
		
	}








	

?>


<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body>

	<style type="text/css">
	
	#text{

		height: 25px;
		border-radius: 5px;
		padding: 4px;
		border: solid thin #aaa;
		width: 100%;
	}

	#button{

		padding: 10px;
		width: 100px;
		color: white;
		background-color: lightblue;
		border: none;
	}

	#box{

		background-color: grey;
		margin: auto;
		width: 300px;
		padding: 20px;
	}

	</style>

	<div id="box">
		
		<form method="post">
			<div style="font-size: 20px; margin: 10px;color: white;">Login</div>

			Manager ID: <input id="text" type="text" name="manID"><br><br>
			Password: <input id="text" type="text" name="manPassword"><br><br>

			<input id="button" type="submit" value="Login"><br><br>

			<a href="signup.php">Click to Signup</a><br><br>
		</form>
	</div>
</body>
</html>