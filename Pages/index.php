<?php 
	include("../connection.php");
	include("../routeHandler.php");
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	
	<nav class="navbar">
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="volunteers.php">Volunteers</a></li>
			<li><a href="adopters.php">Adopters</a></li>
			<li><a href="vets.php">Vets</a></li>
			<li><a href="inspectors.php">Inspectors</a></li>
			<li><a href="events_ws.php">Events and Workshops</a></li>
			<li><a href="login.php">Logout</a></li>
		</ul>
	</nav>

	<main>

	<h1>Welcome to your Animal Shelter Management System!</h1>

	<h3>If you wish to reset the system press on the reset button on the navigation bar.
		If this is the first time you're running this page, you MUST use reset button.</h3>

	<h4>Below is some useful information about the shelter you manage: </h4>

	<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');

        connectToDB();

		$currShelterName = $_SESSION["shelterName"];
        $currShelterLoc = $_SESSION["shelterLocation"];

        $sql1 = "SELECT capacity
                FROM Shelter
                WHERE shelterName = '$currShelterName' AND shelterLocation = '$currShelterLoc'";
        $result1 = executePlainSQL($sql1);

		$sql2 = "SELECT COUNT(*) AS count
				FROM VolunteersAtShelter s
				INNER JOIN Volunteer v ON s.volunteerID = v.volunteerID
				WHERE s.shelterName = '$currShelterName' AND s.shelterLocation = '$currShelterLoc'
				ORDER BY v.volunteerID DESC";
		$result2 = executePlainSQL($sql2);

		$rowExisting1 = oci_fetch_assoc($result1);
        $countExisting1 = $rowExisting1['CAPACITY'];

		$rowExisting2 = oci_fetch_assoc($result2);
        $countExisting2 = $rowExisting2['COUNT'];

		try {
			// Projection
			$tables = array();
			$attributes = array();
		
			$allTablesSql = "SELECT table_name FROM user_tables";
			$allTables = executePlainSQL($allTablesSql);
		
			while ($row = oci_fetch_assoc($allTables)) {
				$tableName = $row['TABLE_NAME'];
				$tables[] = $tableName;
		
				$attributes[$tableName] = array();
		
				$attrSql = "SELECT column_name FROM user_tab_cols WHERE table_name = '$tableName'";
				$attrResult = executePlainSQL($attrSql);
		
				while ($attrRow = oci_fetch_assoc($attrResult)) {
					$attributes[$tableName][] = $attrRow['COLUMN_NAME'];
				}
			}
		} catch (Exception $e) {
			// Log or display the error message
			echo "Error: " . $e->getMessage();
		}
    ?>

	<p>Shelter Name: <?php echo $_SESSION["shelterName"]; ?></p>
	<p>Shelter Location: <?php echo $_SESSION["shelterLocation"]; ?></p>
	<p>Shelter Capacity: <?php echo $countExisting1; ?></p>
	<p>Number of Volunteers: <?php echo $countExisting2; ?></p>

	</main>

	<?php
        disconnectFromDB();
    ?>
</body>
</html>