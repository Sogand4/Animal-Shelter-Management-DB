<?php
    include_once('../routeHandler.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Events</title>
</head>
<body>
    <!-- TODO: MOVE RESET BUTTON TO NAV BAR -->
    <h2>Reset</h2>
        <p>If you wish to reset the table press on the reset button. If this is the first time you're running this page, you MUST use reset</p>

        <form method="POST" action="events_ws.php">
            <input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
            <p><input type="submit" value="Reset" name="reset"></p>
        </form>

  
        <div style="display: flex; justify-content: center;">
    <form method="POST" action="events_ws.php" style="border: 1px solid #ccc; padding: 15px; border-radius: 10px; background-color: #cccccc;">
        <h2 style="margin: 0; padding-bottom: 10px;">Add a new Event below:</h2>
        <input type="hidden" id="insertEventRequest" name="insertEventRequest">
        Event Name: <input type="text" name="eventName" maxlength="255" required> <br /><br />
        Description: <input type="text" name="eventDescription" maxlength="255" required> <br /><br />
        Cost: <input type="text" name="cost" maxlength="255" required> <br /><br />
        Event Date: <input type="text" name="eventDate" maxlength="10" required pattern="\d{4}-\d{2}-\d{2}" title="Please enter a date in the format YYYY-MM-DD"> <br /><br />
        Shelter Location: <input type="text" name="shelterLocation" maxlength="255" required> <br /><br />
        Shelter Name: <input type="text" name="shelterName" maxlength="255" required> <br /><br />
        <input type="submit" value="Insert" name="insertSubmit">
    </form>

    <form method="POST" action="events_ws.php" style="border: 1px solid #ccc; padding: 15px; border-radius: 10px; background-color: #cccccc; margin-left: 10px;">
        <h2 style="margin: 0; padding-bottom: 10px;">Update Event Information:</h2>
        <input type="hidden" id="updateEventRequest" name="updateEventRequest">
        Event Name: <input type="text" name="eventName" maxlength="255" required> <br /><br />
        Shelter Name: <input type="text" name="shelterName" maxlength="255" required> <br /><br />
        Shelter Location: <input type="text" name="shelterLocation" maxlength="255" required> <br /><br />
        Description: <input type="text" name="eventDescription" maxlength="255" required> <br /><br />
        Cost: <input type="text" name="cost" maxlength="255" required> <br /><br />
        Event Date: <input type="text" name="eventDate" maxlength="10" required pattern="\d{4}-\d{2}-\d{2}" title="Please enter a date in the format YYYY-MM-DD"> <br /><br />
        <input type="submit" value="Update" name="updateSubmit">
    </form>

    <form method="POST" action="events_ws.php" style="border: 1px solid #ccc; padding: 15px; border-radius: 10px; background-color: #cccccc; margin-left: 10px;">
        <h2 style="margin: 0; padding-bottom: 10px;">Specify the event you want to delete below:</h2>
        <input type="hidden" id="deleteEventRequest" name="deleteEventRequest">
        Event Name: <input type="text" name="eventName" maxlength="255" required> <br /><br />
        Shelter Location: <input type="text" name="shelterLocation" maxlength="255" required> <br /><br />
        Shelter Name: <input type="text" name="shelterName" maxlength="255" required> <br /><br />
        <input type="submit" value="Delete" name="deleteSubmit">
    </form>
    

</div>

    <h1 style="text-align: center;">List of Events and Workshops</h1>

    <?php
        connectToDB();
        $sql = 'SELECT * FROM EventsHosted';
        $result = executePlainSQL($sql);
    ?>

    <table border="1" style="margin: auto;">
        <thead>
            <tr>
                <th>Event Name</th>
                <th>Description</th>
                <th>Cost</th>
                <th>Event Date</th>
                <th>Shelter Location</th>
                <th>Shelter Name</th>
            </tr>
        </thead>
        <tbody>

        <?php
            while ($row = oci_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['EVENTNAME'] . '</td>';
                echo '<td>' . $row['EVENTDESCRIPTION'] . '</td>';
                echo '<td>' . $row['COST'] . '</td>';
                echo '<td>' . $row['EVENTDATE'] . '</td>';
                echo '<td>' . $row['SHELTERLOCATION'] . '</td>';
                echo '<td>' . $row['SHELTERNAME'] . '</td>';
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