<?php

    require_once('connection.php');

    if (isset($_POST['reset']) || isset($_POST['insertSubmit'])) {
        handlePOSTRequest();
    }

    if (isset($_POST['reset']) || isset($_POST['signupSubmit'])) {
        handlePOSTRequest();
    }

    // HANDLE ALL POST ROUTES
    function handlePOSTRequest() {
        if (connectToDB()) {
            if (array_key_exists('insertVolunteerRequest', $_POST)) {
                handleInsertVolunteerRequest();
            }
            else if (array_key_exists('resetTablesRequest', $_POST)) {
                handleResetRequest();
            }
            else if (array_key_exists('insertInspectorRequest', $_POST)) {
                handleInsertInspectorRequest();
            }
            else if (array_key_exists('insertSignupRequest', $_POST)) {
                handleInsertSignupRequest();
            }

            disconnectFromDB();
        }
    }

    function handleInsertSignupRequest() {
        global $db_conn;

        // Only run the insert manager query if the primary key is not already being used
        $manID = $_POST['manID'];
        
        $checkExistingMan = "SELECT COUNT(*) AS count FROM Manager WHERE manID = '$manID'";
        $numExistingMan = executePlainSQL($checkExistingMan);
        $rowExistingMan = oci_fetch_assoc($numExistingMan);
        $countExistingMan = $rowExistingMan['COUNT'];

        if ($countExistingMan == 0) {
            // Add new manager
            $tuple = array (
                ":bind1" => $_POST['manID'],
                ":bind2" => $_POST['manPassword'],
                ":bind3" => $_POST['manName'],  
                ":bind4" => $_POST['kpi']
            );

            $alltuples = array (
                $tuple
            );

            executeBoundSQL("insert into Manager values (:bind1, :bind2, :bind3, :bind4)", $alltuples);
            OCICommit($db_conn);
        } else {
            echo '<p style="color: red;">Invalid ID inserted. Please use an ID that is not already in use.</p>';
        }
    }

    // TODO: ADD FILTERING FOR THE SHELTER WE ARE CURRENTLY WORKING IN
    function handleInsertInspectorRequest() {
        global $db_conn;

        // Only run the insert inspector query if the primary key is not already being used
        $insID = $_POST['insID'];
        
        $checkExistingIns = "SELECT COUNT(*) AS count FROM Inspector WHERE insID = '$insID'";
        $numExistingIns = executePlainSQL($checkExistingIns);
        $rowExistingIns = oci_fetch_assoc($numExistingIns);
        $countExistingIns = $rowExistingIns['COUNT'];

        if ($countExistingIns == 0) {
            // Add new inspector
            $tuple = array (
                ":bind1" => $_POST['insID'],
                ":bind2" => $_POST['insName']
            );

            $alltuples = array (
                $tuple
            );

            executeBoundSQL("insert into Inspector values (:bind2, :bind1)", $alltuples);
            OCICommit($db_conn);
        } else {
            echo '<p style="color: red;">Invalid ID inserted. Please use an ID that is not already in use.</p>';
        }
    }

    // TODO: ADD FILTERING FOR THE SHELTER WE ARE CURRENTLY WORKING IN
    function handleInsertVolunteerRequest() {
        global $db_conn;

        // Only run the insert volunteer query if the primary key is not already being used
        $volunteerID = $_POST['volID'];
        
        $checkExistingVol = "SELECT COUNT(*) AS count FROM Volunteer WHERE volunteerID = '$volunteerID'";
        $numExistingVol = executePlainSQL($checkExistingVol);
        $rowExistingVol = oci_fetch_assoc($numExistingVol);
        $countExistingVol = $rowExistingVol['COUNT'];

        if ($countExistingVol == 0) {
            // Volunteer's available days is a foreign key so, if volunteer's availabilities
            // is not already in AvailableDaysRegularVolunteer table, then add it to the table first
            $volAvailabilities = $_POST['volDays'];
            
            if ($volAvailabilities != NULL) {
                $checkExistingDays = "SELECT COUNT(*) AS count FROM AvailableDaysRegularVolunteer WHERE availableDays = '$volAvailabilities'";
                $numExistingDays = executePlainSQL($checkExistingDays);
                $rowExistingDays = oci_fetch_assoc($numExistingDays);
                $countExistingDays = $rowExistingDays['COUNT'];

                if ($countExistingDays == 0) {
                    $regularVol = 1;
                    if ($volAvailabilities == 'FFFFFFF') {
                        $regularVol = 0;
                    }

                    $tuple = array (
                        ":bind1" => $volAvailabilities,
                        ":bind2" => $regularVol
                    );
        
                    $alltuples = array (
                        $tuple
                    );
        
                    executeBoundSQL("insert into AvailableDaysRegularVolunteer values (:bind1, :bind2)", $alltuples);
                }
            }

            // Add new volunteer
            $tuple = array (
                ":bind1" => $_POST['volID'],
                ":bind2" => $_POST['volName'],
                ":bind3" => $_POST['volDays'],
                ":bind4" => $_POST['volNum']
            );

            $alltuples = array (
                $tuple
            );

            executeBoundSQL("insert into Volunteer values (:bind1, :bind2, :bind3, :bind4)", $alltuples);
            OCICommit($db_conn);
        } else {
            echo '<p style="color: red;">Invalid ID inserted. Please use an ID that is not already in use.</p>';
        }
    }

    // TODO: Maybe have this reset button on the navigation bar? next to logout?
    function handleResetRequest() {        
        global $db_conn;

        // Drop all tables
        $sqlScript = file_get_contents(__DIR__ . '/DB/ddl/DropTableStatements.sql');
        $sqlStatements = explode(';', $sqlScript);
        $sqlStatements = array_filter(array_map('trim', $sqlStatements));
        foreach ($sqlStatements as $sqlStatement) {
            executePlainSQL($sqlStatement);
        }

        // Create all tables
        $sqlScript = file_get_contents(__DIR__ . '/DB/ddl/CreateTableStatements.sql');
        $sqlStatements = explode(';', $sqlScript);
        $sqlStatements = array_filter(array_map('trim', $sqlStatements));
        foreach ($sqlStatements as $sqlStatement) {
            executePlainSQL($sqlStatement);
        }

        // Populate all tables
        $sqlScript = file_get_contents(__DIR__ . '/DB/dml/PopulateTable.sql');
        $sqlStatements = explode(';', $sqlScript);
        $sqlStatements = array_filter(array_map('trim', $sqlStatements));
        foreach ($sqlStatements as $sqlStatement) {
            executePlainSQL($sqlStatement);
        }

        OCICommit($db_conn);
    }

    function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
        //echo "<br>running ".$cmdstr."<br>";
        global $db_conn, $success;

        $statement = OCIParse($db_conn, $cmdstr);
        //There are a set of comments at the end of the file that describe some of the OCI specific functions and how they work

        if (!$statement) {
            echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
            $e = OCI_Error($db_conn); // For OCIParse errors pass the connection handle
            echo htmlentities($e['message']);
            $success = False;
        }

        $r = OCIExecute($statement, OCI_DEFAULT);
        if (!$r) {
            echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
            $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
            echo htmlentities($e['message']);
            $success = False;
        }

        return $statement;
    }

    function executeBoundSQL($cmdstr, $list) {
        /* Sometimes the same statement will be executed several times with different values for the variables involved in the query.
    In this case you don't need to create the statement several times. Bound variables cause a statement to only be
    parsed once and you can reuse the statement. This is also very useful in protecting against SQL injection.
    See the sample code below for how this function is used */

        global $db_conn, $success;
        $statement = OCIParse($db_conn, $cmdstr);

        if (!$statement) {
            echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
            $e = OCI_Error($db_conn);
            echo htmlentities($e['message']);
            $success = False;
        }

        foreach ($list as $tuple) {
            foreach ($tuple as $bind => $val) {
                //echo $val;
                //echo "<br>".$bind."<br>";
                OCIBindByName($statement, $bind, $val);
                unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
            }

            $r = OCIExecute($statement, OCI_DEFAULT);
            if (!$r) {
                echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($statement); // For OCIExecute errors, pass the statementhandle
                echo htmlentities($e['message']);
                echo "<br>";
                $success = False;
            }
        }
    }

?>