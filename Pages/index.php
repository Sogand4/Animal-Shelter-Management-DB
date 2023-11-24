<?php 
	include("../connection.php");
	include("../routeHandler.php");
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

	<h4>Below is some useful information about the shelter you manage: </h4>

	<?php
        connectToDB();
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
    ?>

	<p>Shelter Name: <?php echo $currShelterName; ?></p>
	<p>Shelter Location: <?php echo $currShelterLoc; ?></p>
	<p>Shelter Capacity: <?php echo $countExisting1; ?></p>
	<p>Number of Volunteers: <?php echo $countExisting2; ?></p>
	<p>Number of Adopters: <?php echo "SOGAND TODO. need animal table first"; ?></p>
	<p>Upcoming Events: <?php echo "SOGAND TODO. need events table first"; ?></p>

	<?php
        oci_free_statement($result);
        disconnectFromDB();
    ?>
</body>
</html>