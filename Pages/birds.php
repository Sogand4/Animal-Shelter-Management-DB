<?php
include_once('../routeHandler.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Birds</title>
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
			<li><a href="dogs.php">Dogs</a></li>
			<li><a href="cats.php">Cats</a></li>
			<li><a href="birds.php">Birds</a></li>
			<li><a href="login.php">Logout</a></li>
			<li>
				<form method="POST" action="birds.php">
					<input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
					<p><input type="submit" value="Reset" name="reset"></p>
				</form>
			</li>
		</ul>
	</nav>

	<main>
		<p>If you wish to reset the table press on the reset button on the navigation bar above. If this is the first
			time you're running this page, you MUST use reset</p>

	<!-- Birds-->
	<h1>Beautiful Birds</h1>

<h2>List of Birds with Health Records</h2>

<?php
connectToDB();

$currShelterName = $_SESSION["shelterName"];
$currShelterLoc = $_SESSION["shelterLocation"];

$sql5 = "SELECT * FROM Birds b
		INNER JOIN RegisteredAnimal a ON b.animalID = a.animalID
		INNER JOIN HealthRecord h ON b.animalID = h.animalID
		WHERE a.shelterName = '$currShelterName' AND a.shelterLocation = '$currShelterLoc'";

$result5 = executePlainSQL($sql5);
?>

<table border="1" style="margin: auto;">
	<thead>
		<tr>
			<th>AnimalID</th>
			<th>Name</th>
			<th>Adopted</th>
			<th>Description</th>
			<th>Age</th>
			<th>Weight</th>
			<th>Breed</th>
			<th>beakSize</th>
			<th>wingSpan</th>
			<th>color</th>
		</tr>
	</thead>
	<tbody>

		<?php
		while ($row = oci_fetch_assoc($result5)) {
			echo '<tr>';
			echo '<td>' . $row['ANIMALID'] . '</td>';
			echo '<td>' . $row['NAME'] . '</td>';
			echo '<td>' . ($row['ADOPTED'] ? 'Yes' : 'No') . '</td>';
			echo '<td>' . $row['DESCRIPTION'] . '</td>';
			echo '<td>' . $row['AGE'] . '</td>';
			echo '<td>' . $row['WEIGHT'] . '</td>';
			echo '<td>' . $row['BREED'] . '</td>';
			echo '<td>' . $row['BEAKSIZE'] . '</td>';
			echo '<td>' . $row['WINGSPAN'] . '</td>';
			echo '<td>' . $row['COLOR'] . '</td>';
			echo '</tr>';
		}
		?>

	</tbody>
</table>


<h2>List of Overweight Birds</h2>

<?php
connectToDB();

$currShelterName = $_SESSION["shelterName"];
$currShelterLoc = $_SESSION["shelterLocation"];

$sql6 = "SELECT b.animalID,a.weight,a.breed
				FROM Birds b
				INNER JOIN RegisteredAnimal a ON b.animalID = a.animalID
				WHERE a.shelterName = '$currShelterName' AND a.shelterLocation = '$currShelterLoc'
				GROUP BY a.breed,b.animalID,a.weight
				HAVING a.weight > (SELECT AVG(m.weight) FROM RegisteredAnimal m
				INNER JOIN Birds n ON m.animalID = n.animalID)";

$result6 = executePlainSQL($sql6);
?>

<table border="1" style="margin: auto;">
	<thead>
		<tr>
			<th>AnimalID</th>
			<th>Weight</th>
			<th>Breed</th>
		</tr>
	</thead>
	<tbody>

		<?php
		while ($row = oci_fetch_assoc($result6)) {
			echo '<tr>';
			echo '<td>' . $row['ANIMALID'] . '</td>';
			echo '<td>' . $row['WEIGHT'] . '</td>';
			echo '<td>' . $row['BREED'] . '</td>';
			echo '</tr>';
		}
		?>

	</tbody>
</table>


<?php
	oci_free_statement($result5);
	oci_free_statement($result6);
	disconnectFromDB();
	?>


</body>

</html>