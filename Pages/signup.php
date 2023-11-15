<?php
    include_once('../routeHandler.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Singup</title>
</head>
<body>
    <!-- TODO: MOVE RESET BUTTON TO NAV BAR -->
    <h2>Reset</h2>
        <p>If you wish to reset the table press on the reset button. If this is the first time you're running this page, you MUST use reset</p>

        <form method="POST" action="signup.php">
            <input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
            <p><input type="submit" value="Reset" name="reset"></p>
        </form>

    <h2>Sign up as a new manager below:</h2>
        <p>ID's are in the format 'MXXX' where X are numbers.</p>
        <form method="POST" action="signup.php">
            <input type="hidden" id="insertSignupRequest" name="insertSignupRequest">
            Id: <input type="text" name="manID" pattern="M\d{3}" title="Invalid entry. Please follow the format above." required> <br /><br />
            Password: <input type="text" name="manPassword" maxlength="12" required> <br /><br />
        <input type="submit" value="Signup" name="signupSubmit"></p>
    </form>

    <h1>List of Managers</h1>

    <!-- TODO: ADD FILTERING FOR CURRENT SHELTER. MAKE IT SO THE USER CAN SEE THE RATING OF THE CURRENT SHELTER GIVEN BY THAT INSPECTOR -->
    <?php
        connectToDB();
        $sql = 'SELECT * FROM Manager
                ORDER BY manID DESC';
        $result = executePlainSQL($sql);
    ?>

    <table border="1">
        <thead>
            <tr>
                <th>ManagerID</th>
                <th>Password</th>
                <th>ManName</th>
                <th>kpi</th>
            </tr>
        </thead>
        <tbody>

        <?php
            while ($row = oci_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['MANID'] . '</td>';
                echo '<td>' . $row['MANPASSWORD'] . '</td>';
                echo '<td>' . $row['MANNAME'] . '</td>';
                echo '<td>' . $row['KPI'] . '</td>';
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