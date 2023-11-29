<?php
include_once('../routeHandler.php');
session_start();
?>

<!DOCTYPE html>
<html>

<head>
	<title>Animals</title>
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
				<form method="POST" action="animals.php">
					<input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
					<p><input type="submit" value="Reset" name="reset"></p>
				</form>
			</li>
		</ul>
	</nav>

	<main>
		<p>If you wish to reset the table press on the reset button on the navigation bar above. If this is the first
			time you're running this page, you MUST use reset</p>

		<div style="display:flex; justify-content:space-around;">

			<!-- Add new animals -->
			<form method="POST" action="animals.php"
				style="border: 1px solid #ccc; padding: 15px; border-radius: 10px;margin: 20px;background-color: #cccccc;">
				<h2 style="margin: 0; padding-bottom: 10px;">Add a new Animal below:</h2>
				<p>AnmialID's are in the format 'CXXX or BXXX or DXXX' where X are numbers.
					Enter 1 if the animal is adopted, 0 otherwise.
					You cannot insert existing animals into our database.
				</p>
				<input type="hidden" id="insertAnimalRequest" name="insertAnimalRequest">
				AnimalID: <input type="text" name="animalID" maxlength="255" pattern="C\d{3} || D\d{3} || B\d{3}"
					title="Please enter the animal ID in the required format" required> <br /><br />
				Name: <input type="text" name="name" maxlength="255" required> <br /><br />
				Adopted: <input type="text" name="adopted" maxlength="255" required
					title="Please follow the required format above"> <br /><br />
				Description: <input type="text" name="description" required> <br /><br />
				Age: <input type="number" name="age" required> <br /><br />
				Weight: <input type="number" name="weight" required> <br /><br />
				Breed: <input type="text" name="breed" required> <br /><br />
				<input type="submit" value="Insert" name="insertSubmit">
			</form>


			<!-- Update Animal Information -->
			<form method="POST" action="animals.php"
				style="border: 1px solid #ccc; padding: 15px; border-radius: 10px;margin: 20px;background-color: #cccccc;">
				<h2 style="margin: 0; padding-bottom: 10px;">Update Animal Info:</h2>
				<p>AnmialID's are in the format 'CXXX or BXXX or DXXX' where X are integers between 0-9.
					Enter 1 if the animal is adopted, 0 otherwise.
					You can only update existing animals in our database.
				</p>
				<input type="hidden" id="upateAnimalRequest" name="updateAnimalRequest">
				AnimalID: <input type="text" name="animalID" maxlength="255" pattern="C\d{3} | D\d{3} | B\d{3}"
					title="Please enter the animal ID in the required format" required> <br /><br />
				Name: <input type="text" name="name" maxlength="255" required> <br /><br />
				Adopted: <input type="text" name="adopted" maxlength="255" required
					title="Please follow the required format above"> <br /><br />
				Description: <input type="text" name="description" required> <br /><br />
				Age: <input type="number" name="age" required> <br /><br />
				Weight: <input type="number" name="weight" required> <br /><br />
				Breed: <input type="text" name="breed" required> <br /><br />
				<input type="submit" value="Update" name="updateSubmit">
			</form>

			<!-- Delete Animals -->
			<form method="POST" action="animals.php"
				style="border: 1px solid #ccc; padding: 15px; border-radius: 10px;margin: 20px;background-color: #cccccc;">
				<h2 style="margin: 0; padding-bottom: 10px;">Delete Animal:</h2>
				<p>AnmialID's are in the format 'CXXX or BXXX or DXXX' where X are integers between 0-9.
					Enter 1 if the animal is adopted, 0 otherwise.
					You can only delete existing animals in our database.
				</p>
				<input type="hidden" id="deleteAnimalRequest" name="deleteAnimalRequest">
				AnimalID: <input type="text" name="animalID" maxlength="255" pattern="C\d{3} | D\d{3} | B\d{3}"
					title="Please enter the animal ID in the required format" required> <br /><br />
				<input type="submit" value="Delete" name="deleteSubmit">
			</form>

		</div>

		<!-- Meet the selection requirement: users can select the breed and age of animals with and/or clause-->
		<h2>Select animals by breed:</h2>
		<form method="POST" action="animals.php">
			<input type="hidden" id="selectAnimalRequest" name="selectAnimalRequest">
			Breed = <input type="text" name="breed" required>
			<select name="operator">
				<option value="And"> AND </option>
				<option value="Or"> OR </option>
			</select>
			Age = <input type="text" name="age" required>
			<input type="submit" value="Submit" name="insertSubmit">
		</form>
		<br>


		<?php
		global $selectAnimalRequestResult;
		if ($selectAnimalRequestResult) { ?>

			<table border="1">
				<thead>
					<tr>
						<th>AnimalID</th>
						<th>Name</th>
						<th>Adopted</th>
						<th>Description</th>
						<th>Age</th>
						<th>Weight</th>
						<th>Breed</th>
					</tr>
				</thead>
				<tbody>
				<?php } ?>
				<?php
				global $selectAnimalRequestResult;
				while ($row = oci_fetch_assoc($selectAnimalRequestResult)) {
					echo '<tr>';
					echo '<td>' . $row['ANIMALID'] . '</td>';
					echo '<td>' . $row['NAME'] . '</td>';
					echo '<td>' . ($row['ADOPTED'] ? 'Yes' : 'No') . '</td>';
					echo '<td>' . $row['DESCRIPTION'] . '</td>';
					echo '<td>' . $row['AGE'] . '</td>';
					echo '<td>' . $row['WEIGHT'] . '</td>';
					echo '<td>' . $row['BREED'] . '</td>';
					echo '</tr>';
				} ?>
			</tbody>
		</table>
		<hr />


		<!-- list of Unvaccinated Animals -->
		<h2>View list of unvaccinated animals</h2>
		<form method="POST" action="animals.php">
			<input type="hidden" id="getUnvaccinatedRequest" name="getUnvaccinatedRequest">
			<input type="submit" value="View Result" name="insertSubmit">
		</form>
		<br>

		<?php
		global $getUnvaccinatedRequestResult;
		if ($getUnvaccinatedRequestResult) { ?>

			<table border="1">
				<thead>
					<tr>
						<th>AnimalID</th>
						<th>Name</th>
					</tr>
				</thead>
				<tbody>

				<?php } ?>

				<?php
				while ($row = oci_fetch_assoc($getUnvaccinatedRequestResult)) {
					echo '<tr>';
					echo '<td>' . $row['ANIMALID'] . '</td>';
					echo '<td>' . $row['NAME'] . '</td>';
					echo '</tr>';
				}
				?>
			</tbody>
		</table>
		<hr />


		<!-- Calculate average age of each breed-->
		<h2>Average age of each breed:</h2>
		<form method="POST" action="animals.php">
			<input type="hidden" id="calculateAvgRequest" name="calculateAvgRequest">
			<input type="submit" value="Calculate Average" name="insertSubmit">
		</form>

		<?php
		global $calculateAvgRequestResult;
		if ($calculateAvgRequestResult) { ?>
			<table border="1">
				<thead>
					<tr>
						<th>Breed</th>
						<th>Average Age</th>
					</tr>
				</thead>
				<tbody>

				<?php } ?>

				<?php
				while ($row = oci_fetch_assoc($calculateAvgRequestResult)) {
					echo '<tr>';
					echo '<td>' . $row['BREED'] . '</td>';
					echo '<td>' . $row['AVERAGEAGE'] . '</td>';
					echo '</tr>';
				}
				?>
			</tbody>
		</table>


	</main>


	<?php
	disconnectFromDB();
	?>

</body>

</html>