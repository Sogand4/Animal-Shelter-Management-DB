<?php
    include_once('../routeHandler.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inspectors</title>
</head>
<body>
    <!-- TODO: MOVE RESET BUTTON TO NAV BAR -->
    <h2>Reset</h2>
        <p>If you wish to reset the table press on the reset button. If this is the first time you're running this page, you MUST use reset</p>

        <form method="POST" action="inspectors.php">
            <input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
            <p><input type="submit" value="Reset" name="reset"></p>
        </form>

    <h2>Add new inspector below:</h2>
        <p>ID's are in the format 'IXXX' where X are numbers.</p>
        <form method="POST" action="inspectors.php">
            <input type="hidden" id="insertInspectorRequest" name="insertInspectorRequest">
            Id: <input type="text" name="insID" pattern="I\d{3}" title="Invalid entry. Please follow the format above." required> <br /><br />
            Name: <input type="text" name="insName" maxlength="255" required> <br /><br />
        <input type="submit" value="Insert" name="insertSubmit"></p>
    </form>

    <h1>List of inspectors</h1>

    <!-- TODO: ADD FILTERING FOR CURRENT SHELTER. MAKE IT SO THE USER CAN SEE THE RATING OF THE CURRENT SHELTER GIVEN BY THAT INSPECTOR -->
    <?php
        connectToDB();
        $sql = 'SELECT * FROM Inspector
                ORDER BY insID DESC';
        $result = executePlainSQL($sql);
    ?>

    <table border="1">
        <thead>
            <tr>
                <th>Inspector ID</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>

        <?php
            while ($row = oci_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['INSID'] . '</td>';
                echo '<td>' . $row['INSNAME'] . '</td>';
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