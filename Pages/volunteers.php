<?php
    include_once('../routeHandler.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Volunteer</title>
</head>
<body>
    <!-- TODO: MOVE RESET BUTTON TO NAV BAR -->
    <h2>Reset</h2>
        <p>If you wish to reset the table press on the reset button. If this is the first time you're running this page, you MUST use reset</p>

        <form method="POST" action="volunteers.php">
            <input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
            <p><input type="submit" value="Reset" name="reset"></p>
        </form>

    <h2>Add new volunteer below:</h2>
        <p>ID's are in the format 'VXXX' where X are numbers.
            Available days are in the format 'XXXXXXX', where each X corresponds to each day of the week.
            X is represented with T (true) or F (false) values to indicate whether volunteer is available that day</p>
        <form method="POST" action="volunteers.php">
            <input type="hidden" id="insertVolunteerRequest" name="insertVolunteerRequest">
            Id: <input type="text" name="volID" pattern="V\d{3}" title="Invalid entry. Please follow the format above." required> <br /><br />
            Name: <input type="text" name="volName" maxlength="255" required> <br /><br />
            Days Available: <input type="text" name="volDays" pattern="[TF]{7}" title="Invalid entry. Please follow the format above."> <br /><br />
            Phone Number: <input type="number" name="volNum"> <br /><br />
        <input type="submit" value="Insert" name="insertSubmit"></p>
    </form>

    <h1>List of volunteers</h1>

    <!-- TODO: ADD FILTERING FOR CURRENT SHELTER -->
    <?php
        connectToDB();
        $sql = 'SELECT * FROM Volunteer ORDER BY volunteerID DESC';
        $result = executePlainSQL($sql);
    ?>

    <table border="1">
        <thead>
            <tr>
                <th>Volunteer ID</th>
                <th>Name</th>
                <th>Days Available</th>
                <th>Phone Number</th>
            </tr>
        </thead>
        <tbody>

        <?php
            while ($row = oci_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['VOLUNTEERID'] . '</td>';
                echo '<td>' . $row['NAME'] . '</td>';
                echo '<td>' . $row['AVAILABLEDAYS'] . '</td>';
                echo '<td>' . $row['PHONENUMBER'] . '</td>';
                echo '</tr>';
            }
        ?>

        </tbody>
    </table>

    <?php
        oci_free_statement($result);
        disconnectFromDB();
    ?>

</body>
</html>