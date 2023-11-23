<?php
    include_once('../routeHandler.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Adopters</title>
</head>
<body>
    <!-- TODO: MOVE RESET BUTTON TO NAV BAR -->
    <h2>Reset</h2>
        <p>If you wish to reset the table press on the reset button. If this is the first time you're running this page, you MUST use reset</p>

        <form method="POST" action="adopters.php">
            <input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
            <p><input type="submit" value="Reset" name="reset"></p>
        </form>

    <h2>Add new Adopter below:</h2>
        <p>ID's are in the format 'AXXX' where X are numbers. National ID must be 10 characters.</p>
        <form method="POST" action="adopters.php">
            <input type="hidden" id="insertAdopterRequest" name="insertAdopterRequest">
            Id: <input type="text" name="adptID" pattern="A\d{3}" title="Invalid entry. Please follow the format above." required> <br /><br />
            National Id: <input type="text" name="natID" pattern=".{10}" title="Invalid entry. Please follow the format above."> <br /><br />
            Name: <input type="text" name="adptName" maxlength="255"> <br /><br />
            Phone Number: <input type="number" name="adptNum"> <br /><br />
            Email: <input type="text" name="adptEmail" maxlength="225"> <br /><br />
            House number: <input type="text" name="adptHouseNum" maxlength="225"> <br /><br />
            Postal Code: <input type="text" name="adptPostalCode" maxlength="225"> <br /><br />
            City: <input type="text" name="adptCity" maxlength="225"> <br /><br />
            Steet name: <input type="text" name="adptStreetName" maxlength="225"> <br /><br />
            Province: <input type="text" name="adptProvince" maxlength="225"> <br /><br />
        <input type="submit" value="Insert" name="insertSubmit"></p>
    </form>

    <h2>Update Adopter info below:</h2>
        <p>ID entered must match with an already existing ID. ID cannot be changed.</p>
        <form method="POST" action="adopters.php">
            <input type="hidden" id="updateAdopterRequest" name="updateAdopterRequest">
            Id: <input type="text" name="adptID" pattern="A\d{3}" title="Invalid entry. Please follow the format above." required> <br /><br />
            Name: <input type="text" name="adptName" maxlength="255"> <br /><br />
            Email: <input type="text" name="adptEmail" maxlength="225"> <br /><br />
        <input type="submit" value="Update" name="updateSubmit"></p>
    </form>

    <h1>List of adopters</h1>

    <form method="GET">
    <label for="view">Select View:</label>
    <select name="view" id="view" onchange="this.form.submit()">
        <option value=""></option>
        <option value="with_address">View with Address</option>
        <option value="without_address">View without Address</option>
    </select>
    </form>

    <br></br>

    <!-- TODO: ADD FILTERING FOR CURRENT SHELTER -->
    <?php
        $view = isset($_GET['view']) ? $_GET['view'] : 'with_address';
        connectToDB();
        $sql = '';
        if ($view === 'with_address') {
            // Include the address columns in the query
            $sql = 'SELECT *
                    FROM AdoptersInfo i NATURAL LEFT OUTER JOIN AdoptersLocation
                    ORDER BY i.adopterID DESC';
        } elseif ($view === 'without_address') {
            // Exclude the address columns in the query
            $sql = 'SELECT ADOPTERID, NATIONALID, NAME, PHONENUMBER, EMAIL
                    FROM AdoptersInfo
                    ORDER BY ADOPTERID DESC';
        }
        $result = executePlainSQL($sql);
    ?>

    <table border="1">
        <thead>
            <tr>
                <th>Adopter ID</th>
                <th>National ID</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Email</th>
                <?php if ($view === 'with_address') { ?>
                    <th>House Number</th>
                    <th>Postal Code</th>
                    <th>City</th>
                    <th>Street Name</th>
                    <th>Province</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>

        <?php
            while ($row = oci_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['ADOPTERID'] . '</td>';
                echo '<td>' . $row['NATIONALID'] . '</td>';
                echo '<td>' . $row['NAME'] . '</td>';
                echo '<td>' . $row['PHONENUMBER'] . '</td>';
                echo '<td>' . $row['EMAIL'] . '</td>';

                if ($view === 'with_address') {
                    echo '<td>' . $row['HOUSENUMBER'] . '</td>';
                    echo '<td>' . $row['POSTALCODE'] . '</td>';
                    echo '<td>' . $row['CITY'] . '</td>';
                    echo '<td>' . $row['STREETNAME'] . '</td>';
                    echo '<td>' . $row['PROVINCE'] . '</td>';
                }
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