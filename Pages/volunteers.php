<?php
    include_once('../routeHandler.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Insert Data Page</title>
</head>
<body>
    <h2>Reset</h2>
        <p>If you wish to reset the table press on the reset button. If this is the first time you're running this page, you MUST use reset</p>

        <form method="POST" action="volunteers.php">
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
            <p><input type="submit" value="Reset" name="reset"></p>
        </form>

    <h2>Insert Values into Test1 table</h2>
        <form method="POST" action="volunteers.php"> <!--refresh page when submitted-->
            <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
            Number: <input type="text" name="insNo"> <br /><br />
            Name: <input type="text" name="insName"> <br /><br />

        <input type="submit" value="Insert" name="insertSubmit"></p>
    </form>

    <h1>Volunteer Information</h1>

    <?php
        connectToDB();
        $sql = 'SELECT * FROM test1 ORDER BY id DESC';
        $result = executePlainSQL($sql);
    ?>

    <table border="1">
        <thead>
            <tr>
                <th>id</th>
                <th>name</th>
            </tr>
        </thead>
        <tbody>

        <?php
            while ($row = oci_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['ID'] . '</td>';
                echo '<td>' . $row['NAME'] . '</td>';
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