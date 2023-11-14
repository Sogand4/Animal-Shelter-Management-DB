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

    <table border="1" method="GET" action="volunteers.php">
        <thead>
            <tr>
                <th>Volunteer ID</th>
                <th>Name</th>
                <th>Available Days</th>
                <th>Phone Number</th>
            </tr>
        </thead>
        <tbody id="volunteer-table">
            <!-- Data will be inserted here -->
        </tbody>
    </table>
</body>
</html>