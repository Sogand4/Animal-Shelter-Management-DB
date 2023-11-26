<?php
    require_once('connection.php');

    if (isset($_POST['reset']) || isset($_POST['insertSubmit']) || isset($_POST['signupSubmit']) || isset($_POST['loginSubmit']) || isset($_POST['updateSubmit']) || isset($_POST['deleteSubmit'])) {
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
            else if (array_key_exists('insertLoginRequest', $_POST)) {
                handleInsertLoginRequest();
            }
            else if (array_key_exists('insertVetRequest', $_POST)) {
                handleInsertVetRequest();
            }
            else if (array_key_exists('insertAdopterRequest', $_POST)) {
                handleInsertAdopterRequest();
            }
            else if (array_key_exists('updateAdopterRequest', $_POST)) {
                handleupdateAdopterRequest();
            }
            else if (array_key_exists('insertEventRequest', $_POST)) {
                handleInsertEventRequest();
            }
            else if (array_key_exists('updateEventRequest', $_POST)) {
                handleUpdateEventRequest();
            }
            else if (array_key_exists('deleteEventRequest', $_POST)) {
                handleDeleteEventRequest();
            }

            disconnectFromDB();
        }
    }

    // SOGAND TODO: ADD FILTERING FOR THE SHELTER WE ARE CURRENTLY WORKING + ANIMALS
    // add more options to meet rubric for update
    // in adopter.php change filtering so user chooses what shows up in WHERE clause
    function handleUpdateAdopterRequest() {
        global $db_conn;

        // Only run the update adopter query if the ID exists and unique keys are not being used
        $tuple = array (
            ":bind1" => $_POST['adptID']
        );

        $alltuples = array (
            $tuple
        );

        $numExisting = executeBoundSQL("SELECT COUNT(*) AS count FROM AdoptersInfo WHERE adopterID = :bind1", $alltuples);
        $rowExisting = oci_fetch_assoc($numExisting);
        $countExisting1 = $rowExisting['COUNT'];

        $tuple = array (
            ":bind1" => $_POST['adptEmail']
        );

        $alltuples3 = array (
            $tuple
        );

        $numExisting = executeBoundSQL("SELECT COUNT(*) AS count FROM AdoptersInfo WHERE email = :bind1", $alltuples3);
        $rowExisting = oci_fetch_assoc($numExisting);
        $countExisting2 = $rowExisting['COUNT'];

        if ($countExisting1 == 1 && $countExisting2 == 0) {
            // Add new adopter
            $tuple = array (
                ":bind1" => $_POST['adptID'],
                ":bind2" => $_POST['adptName'],
                ":bind3" => $_POST['adptEmail']
            );

            $alltuples = array (
                $tuple
            );

            executeBoundSQL("UPDATE AdoptersInfo SET name = :bind2, email = :bind3 WHERE adopterID = :bind1", $alltuples);
            OCICommit($db_conn);
        } else {
            echo '<p style="color: red;">Invalid info inserted. Please use an already existing adopter ID and a unique email.</p>';
        }
    }
    

    // SOGAND TODO: ADD FILTERING FOR THE SHELTER WE ARE CURRENTLY WORKING IN + ANIMALS
    // - adopt table
    function handleInsertAdopterRequest() {
        global $db_conn;

        // Only run the insert adopter query if the unique keys are not being used
        $tuple = array (
            ":bind1" => $_POST['adptID']
        );

        $alltuples = array (
            $tuple
        );

        $numExisting = executeBoundSQL("SELECT COUNT(*) AS count FROM AdoptersInfo WHERE adopterID = :bind1", $alltuples);
        $rowExisting = oci_fetch_assoc($numExisting);
        $countExisting1 = $rowExisting['COUNT'];

        $tuple = array (
            ":bind1" => $_POST['natID']
        );

        $alltuples2 = array (
            $tuple
        );

        $numExisting = executeBoundSQL("SELECT COUNT(*) AS count FROM AdoptersInfo WHERE nationalID = :bind1", $alltuples2);
        $rowExisting = oci_fetch_assoc($numExisting);
        $countExisting2 = $rowExisting['COUNT'];

        $tuple = array (
            ":bind1" => $_POST['adptEmail']
        );

        $alltuples3 = array (
            $tuple
        );

        $numExisting = executeBoundSQL("SELECT COUNT(*) AS count FROM AdoptersInfo WHERE email = :bind1", $alltuples3);
        $rowExisting = oci_fetch_assoc($numExisting);
        $countExisting3 = $rowExisting['COUNT'];

        if ($countExisting1 == 0 && $countExisting2 == 0 && $countExisting3 == 0) {
            // Adopter's postal code is a foreign key, so if it does not already exsit in AdoptersLocation table, then add it to the table first
            $postalCode = $_POST['adptPostalCode'];
            if ($postalCode != NULL) {
                $tuple = array (
                    ":bind1" => $_POST['adptPostalCode']
                );
        
                $alltuples = array (
                    $tuple
                );

                $numExisting = executeBoundSQL("SELECT COUNT(*) AS count FROM AdoptersLocation WHERE postalCode = :bind1", $alltuples);
                $rowExisting = oci_fetch_assoc($numExisting);
                $countExisting = $rowExisting['COUNT'];

                if ($countExisting == 0) {
                    $tuple = array (
                        ":bind1" => $_POST['adptPostalCode'],
                        ":bind2" => $_POST['adptCity'],
                        ":bind3" => $_POST['adptStreetName'],
                        ":bind4" => $_POST['adptProvince']
                    );
        
                    $alltuples = array (
                        $tuple
                    );
        
                    executeBoundSQL("insert into AdoptersLocation values (:bind1, :bind2, :bind3, :bind4)", $alltuples);
                }
            }

            // Add new adopter
            $tuple = array (
                ":bind1" => $_POST['adptID'],
                ":bind2" => $_POST['natID'],
                ":bind3" => $_POST['adptName'],
                ":bind4" => $_POST['adptNum'],
                ":bind5" => $_POST['adptEmail'],
                ":bind6" => $_POST['adptPostalCode'],
                ":bind7" => $_POST['adptHouseNum']
            );

            $alltuples = array (
                $tuple
            );

            executeBoundSQL("insert into AdoptersInfo values (:bind1, :bind2, :bind3, :bind4, :bind5, :bind6, :bind7)", $alltuples);
            OCICommit($db_conn);
        } else {
            echo '<p style="color: red;">Invalid info inserted. Please use an adopter ID, national ID, and email that is not already in use.</p>';
        }
    }

    // ECE TODO: add logic to keep track of shelter name of the manager who logged in works at
    function handleInsertLoginRequest() {
        global $db_conn;

        // Only run the insert manager query if the primary key is not already being used
        $manID = $_POST['manID'];
		$manPassword = $_POST['manPassword'];

        $tuple = array (
            ":bind1" => $_POST['manID']
        );

        $alltuples = array (
            $tuple
        );

        $numExistingMan = executeBoundSQL("SELECT COUNT(*) AS count FROM Manager WHERE manID = :bind1", $alltuples);
        $rowExistingMan = oci_fetch_assoc($numExistingMan);
        $countExistingMan = $rowExistingMan['COUNT'];

        //if both manID and manPassword not empty
        if($countExistingMan == 1)
		{
            $tuple = array (
                ":bind1" => $_POST['manID']
            );
    
            $alltuples = array (
                $tuple
            );
    
            $result = executeBoundSQL("SELECT * FROM Manager WHERE manID = :bind1", $alltuples);
            $user_data = oci_fetch_assoc($result);
            $passInDB = trim($user_data['MANPASSWORD']);
            
            if($passInDB === $manPassword)
            {
                // login successful. Keep track of current shelter
                // $currShelterName, $currShelterLoc = (do query to set this value)
                header("Location: index.php");
                die;
            }
                
        echo " wrong username or password NO RESULT";
        } else{
        echo " wrong username or password!";
        }
}

    // ECE TODO: manager signs up name and location of shelter too 
    // add all attributes to sheltermanagerinfo
    // ShelterManagerPerformance table
    function handleInsertSignupRequest() {
        global $db_conn;

        // Only run the insert manager query if the primary key is not already being used
        $tuple = array (
            ":bind1" => $_POST['manID']
        );

        $alltuples = array (
            $tuple
        );

        $numExistingMan = executeBoundSQL("SELECT COUNT(*) AS count FROM Manager WHERE manID = :bind1", $alltuples);
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

    // ECE TODO: ADD FILTERING FOR THE SHELTER WE ARE CURRENTLY WORKING IN
    // add all attributes
    // - vet works at shelter table
    function handleInsertVetRequest() {
        global $db_conn;

        // Only run the insert vet query if the primary key is not already being used
        $tuple = array (
            ":bind1" => $_POST['vetID']
        );

        $alltuples = array (
            $tuple
        );

        $numExistingVet = executeBoundSQL("SELECT COUNT(*) AS count FROM Vet WHERE vetID = :bind1", $alltuples);
        $rowExistingVet = oci_fetch_assoc($numExistingVet);
        $countExistingVet = $rowExistingVet['COUNT'];

        if ($countExistingVet == 0) {
            // Add new vet
            $tuple = array (
                ":bind1" => $_POST['vetID'],
                ":bind2" => $_POST['vetName']
            );

            $alltuples = array (
                $tuple
            );

            executeBoundSQL("insert into Vet values (:bind1, :bind2)", $alltuples);
            OCICommit($db_conn);
        } else {
            echo '<p style="color: red;">Invalid ID inserted. Please use an ID that is not already in use.</p>';
        }
    }

    function handleInsertEventRequest() {
        global $db_conn;

        // Only run the insert event query if the primary key is not already being used
        $tuple = array (
            ":bind1" => $_POST['eventName'],
            ":bind5" => $_POST['shelterLocation'],
            ":bind6" => $_POST['shelterName']
        );

        $alltuples = array (
            $tuple
        );

        $numExistingEvent = executeBoundSQL("SELECT COUNT(*) AS count FROM EventsHosted WHERE eventName = :bind1 AND shelterLocation = :bind5 AND shelterName = :bind6", $alltuples);
        $rowExistingEvent = oci_fetch_assoc($numExistingEvent);
        $countExistingEvent = $rowExistingEvent['COUNT'];

        $eventDateFormatted = date('Y-m-d', strtotime($_POST['eventDate']));

        if ($countExistingEvent == 0) {
            // Add new event
            $tuple = array (
                ":bind1" => $_POST['eventName'],
                ":bind2" => $_POST['eventDescription'],
                ":bind3" => $_POST['cost'],
                ":bind4" => $eventDateFormatted,
                ":bind5" => $_POST['shelterLocation'],
                ":bind6" => $_POST['shelterName']
            );

            $alltuples = array (
                $tuple
            );

            executeBoundSQL("insert into EventsHosted values (:bind1, :bind2, :bind3, TO_DATE(:bind4, 'YYYY-MM-DD'), :bind5, :bind6)", $alltuples);
            OCICommit($db_conn);
        } else {
            echo '<p style="color: red;">Invalid Event inserted. Please use event name, shelter name and location that is not already in use.</p>';
        }
    }


    function handleUpdateEventRequest() {
        global $db_conn;

        // Only run the update query if these exist
        $tuple = array (
            ":bind1" => $_POST['eventName'],
            ":bind5" => $_POST['shelterLocation'],
            ":bind6" => $_POST['shelterName']
        );


        $alltuples = array (
            $tuple
        );

        $numExisting = executeBoundSQL("SELECT COUNT(*) AS count FROM EventsHosted WHERE eventName = :bind1 AND shelterLocation = :bind5 AND shelterName = :bind6", $alltuples);
        $rowExisting = oci_fetch_assoc($numExisting);
        $countExisting = $rowExisting['COUNT'];

        $eventDateFormatted = date('Y-m-d', strtotime($_POST['eventDate']));

        if ($countExisting == 1) {
            // Update Event
            $tuple1 = array (
                ":bind1" => $_POST['eventName'],
                ":bind2" => $_POST['eventDescription'],
                ":bind3" => $_POST['cost'],
                ":bind4" => $eventDateFormatted,
                ":bind5" => $_POST['shelterLocation'],
                ":bind6" => $_POST['shelterName'],
            );

            $alltuples1 = array (
                $tuple1
            );

            executeBoundSQL("UPDATE EventsHosted SET eventDescription = :bind2, cost = :bind3, eventDate = TO_DATE(:bind4, 'YYYY-MM-DD') WHERE eventName = :bind1 AND shelterLocation = :bind5 AND shelterName = :bind6", $alltuples1);
            OCICommit($db_conn);
        } else {
            echo '<p style="color: red;">Invalid info inserted. Please use an already existing event name, shelter location and shelter name.</p>';
        }
    }

    function handleDeleteEventRequest() {
        global $db_conn;

        // Only run the insert event query if the primary key is not already being used
        $tuple = array (
            ":bind1" => $_POST['eventName'],
            ":bind5" => $_POST['shelterLocation'],
            ":bind6" => $_POST['shelterName']
        );

        $alltuples = array (
            $tuple
        );

        $numExistingEvent = executeBoundSQL("SELECT COUNT(*) AS count FROM EventsHosted WHERE eventName = :bind1 AND shelterLocation = :bind5 AND shelterName = :bind6", $alltuples);
        $rowExistingEvent = oci_fetch_assoc($numExistingEvent);
        $countExistingEvent = $rowExistingEvent['COUNT'];

        $eventDateFormatted = date('Y-m-d', strtotime($_POST['eventDate']));

        if ($countExistingEvent == 1) {
            // Delete event
            $tuple = array (
                ":bind1" => $_POST['eventName'],
                ":bind2" => $_POST['eventDescription'],
                ":bind3" => $_POST['cost'],
                ":bind4" => $eventDateFormatted,
                ":bind5" => $_POST['shelterLocation'],
                ":bind6" => $_POST['shelterName']
            );

            $alltuples = array (
                $tuple
            );

            executeBoundSQL("DELETE FROM EventsHosted WHERE eventName = :bind1 AND shelterLocation = :bind5 AND shelterName = :bind6", $alltuples);
            OCICommit($db_conn);
        } else {
            echo '<p style="color: red;">This event does not exist. Please use an event name, shelter name and location that is already in use.</p>';
        }
    }





    function handleInsertInspectorRequest() {
        global $db_conn;
        global $currShelterName;
        global $currShelterLoc;

        // Only run the insert inspector query if the primary key is not already being used
        $tuple = array (
            ":bind1" => $_POST['insID']
        );

        $alltuples = array (
            $tuple
        );

        $numExistingIns = executeBoundSQL("SELECT COUNT(*) AS count FROM Inspector WHERE insID = :bind1", $alltuples);
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

            $tuple1 = array (
                ":bind1" => $_POST['insID'],
                ":bind2" => $currShelterName,
                ":bind3" => $currShelterLoc,
                ":bind4" => $_POST['standardsMet']
            );

            $alltuples1 = array (
                $tuple1
            );

            executeBoundSQL("insert into Inspect values (:bind1, :bind3, :bind2, :bind4)", $alltuples1);
            OCICommit($db_conn);
        } else {
            echo '<p style="color: red;">Invalid ID inserted. Please use an ID that is not already in use.</p>';
        }
    }

    function handleInsertVolunteerRequest() {
        global $db_conn;
        global $currShelterName;
        global $currShelterLoc;

        // Only run the insert volunteer query if the primary key is not already being used
        $tuple = array (
            ":bind1" => $_POST['volID']
        );

        $alltuples = array (
            $tuple
        );

        $numExistingVol = executeBoundSQL("SELECT COUNT(*) AS count FROM Volunteer WHERE volunteerID = :bind1", $alltuples);
        $rowExistingVol = oci_fetch_assoc($numExistingVol);
        $countExistingVol = $rowExistingVol['COUNT'];

        if ($countExistingVol == 0) {
            // Volunteer's available days is a foreign key so, if volunteer's availabilities
            // is not already in AvailableDaysRegularVolunteer table, then add it to the table first
            $volAvailabilities = $_POST['volDays'];
            
            if ($volAvailabilities != NULL) {
                $tuple = array (
                    ":bind1" => $_POST['volDays']
                );
        
                $alltuples = array (
                    $tuple
                );
        
                $numExistingDays = executeBoundSQL("SELECT COUNT(*) AS count FROM AvailableDaysRegularVolunteer WHERE availableDays = :bind1", $alltuples);
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

            $currentDate = date('Y-m-d');

            $tuple = array (
                ":bind1" => $_POST['volID'],
                ":bind2" => $currShelterLoc,
                ":bind3" => $currShelterName,
                ":bind4" => $currentDate
            );

            $alltuples = array (
                $tuple
            );

            executeBoundSQL("insert into VolunteersAtShelter values (:bind1, :bind2, :bind3, TO_DATE(:bind4, 'YYYY-MM-DD'))", $alltuples);
            OCICommit($db_conn);
        } else {
            echo '<p style="color: red;">Invalid ID inserted. Please use an ID that is not already in use.</p>';
        }
    }

    // SELINA TODO: Maybe have this reset button on the navigation bar? next to logout?
    function handleResetRequest() {        
        global $db_conn;

        // Drop, Create, and Populate all tables
        $sqlScript = file_get_contents(__DIR__ . '/DDL/InitializeTableStatements.sql');
        $sqlStatements = explode(';', $sqlScript);
        $sqlStatements = array_filter(array_map('trim', $sqlStatements));
        foreach ($sqlStatements as $sqlStatement) {
            executePlainSQL($sqlStatement);
        }

        OCICommit($db_conn);
    }

    /* SELINA TODO:
        - because we only have "on delete CASCADE" in animals tables, we need to implement ability for user to delete a cat/dog/bird to meet the ruric requirement
        - TABLES:
            -registered animal table
            - cats
            - dogs
            - birds
            - getvaccination
            - vaccination
            - health record
    */

    // Function from: https://www.students.cs.ubc.ca/~cs-304/resources/php-oracle-resources/php-setup.html
    // takes a plain (no bound variables) SQL command and executes it
    function executePlainSQL($cmdstr) {
        global $db_conn, $success;

        $statement = OCIParse($db_conn, $cmdstr);

        if (!$statement) {
            echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
            $e = OCI_Error($db_conn);
            echo htmlentities($e['message']);
            $success = False;
        }

        $r = OCIExecute($statement, OCI_DEFAULT);
        if (!$r) {
            echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
            $e = oci_error($statement);
            echo htmlentities($e['message']);
            $success = False;
        }

        return $statement;
    }


    // Function adapted from: https://www.students.cs.ubc.ca/~cs-304/resources/php-oracle-resources/php-setup.html
    function executeBoundSQL($cmdstr, $list) {
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
                OCIBindByName($statement, $bind, $val);
                unset ($val);
            }

            $r = OCIExecute($statement, OCI_DEFAULT);
            if (!$r) {
                echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($statement);
                echo htmlentities($e['message']);
                echo "<br>";
                $success = False;
            }
        }

        return $statement;
    }

?>