<?php
    include_once('../routeHandler.php');
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vets</title>
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
            <li>
                <form method="POST" action="vets.php">
                <input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
                <p><input type="submit" value="Reset" name="reset"></p>
                </form>
            </li>
		</ul>
	</nav>

    <main>
        <p>If you wish to reset the table press on the reset button on the navigation bar above. If this is the first time you're running this page, you MUST use reset</p>

    <h2>Add a new Vet below:</h2>
        <p>ID's are in the format 'VXXX' where V are numbers.</p>
        <form method="POST" action="vets.php">
            <input type="hidden" id="insertVetRequest" name="insertVetRequest">
            Id: <input type="text" name="vetID" pattern="V\d{3}" title="Invalid entry. Please follow the format above." required> <br /><br />
            Name: <input type="text" name="vetName" maxlength="255" required> <br /><br />
            Specialty: <input type="text" name="specialty" maxlength="255" required> <br /><br />
            Years of Experience: <input type="number" name="yearsOfExperience" maxlength="255" required> <br /><br />
            Vet Location: <input type="text" name="vetLocation" maxlength="255" required> <br /><br />

        <input type="submit" value="Insert" name="insertSubmit"></p>
    </form>

    <h1>List of vets</h1>

    <?php
        connectToDB();

        $currShelterName = $_SESSION["shelterName"];
        $currShelterLoc = $_SESSION["shelterLocation"];
        
        $sql = "SELECT *
                FROM VetWorksAtShelter s
                INNER JOIN Vet v ON s.vetID = v.vetID
                WHERE s.shelterName = '$currShelterName' AND s.shelterLocation = '$currShelterLoc'
                ORDER BY v.vetID DESC";
        $result = executePlainSQL($sql);

    ?>

    <table border="1">
        <thead>
            <tr>
                <th>Vet ID</th>
                <th>Name</th>
                <th>Specialty</th>
                <th>Years of Experience</th>
                <th>Vet Location</th>
            </tr>
        </thead>
        <tbody>

        <?php
            while ($row = oci_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['VETID'] . '</td>';
                echo '<td>' . $row['VETNAME'] . '</td>';
                echo '<td>' . $row['SPECIALTY'] . '</td>';
                echo '<td>' . $row['YEARSOFEXPERIENCE'] . '</td>';
                echo '<td>' . $row['VETLOCATION'] . '</td>';
                echo '</tr>';
            }
        ?>

        </tbody>
    </table>

    </main>

    <?php
        oci_free_statement($result);
        disconnectFromDB();
    ?>

</body>
</html>