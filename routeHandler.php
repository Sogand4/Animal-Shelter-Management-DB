<?php
    require_once('connection.php');

    global $findVolRequestResult;
    $findVolRequestResult = null;

    session_start();

    if (isset($_POST['reset']) || isset($_POST['insertSubmit']) || isset($_POST['signupSubmit']) || isset($_POST['loginSubmit'])
        || isset($_POST['updateSubmit']) || isset($_POST['deleteSubmit'])) {
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
            else if (array_key_exists('findVolunteerRequest', $_POST)) {
                handleFindVolunteerRequest();
            } 
            else if (array_key_exists('selecetAnimalRequest', $_POST)) {
                handleSelectAnimalRequest();
            } 
            else if (array_key_exists('insertAnimalRequest', $_POST)) {
                handleInsertAnimalRequest();
            } 
            else if (array_key_exists('updateAnimalRequest', $_POST)) {
                handleUpdateAnimalRequest();
            } 
            else if (array_key_exists('calculateAvgRequest', $_POST)) {
                handleCalculateAvgRequest();
            }
    
            disconnectFromDB();
        }
    }
    
    
    function handleCalculateAvgRequest()
    {
        global $db_conn;
        global $calculateAvgRequestResult;
    
        $sql = "SELECT a.breed,AVG(a.weight) AS AverageWeight
                FROM RegisteredAnimal a
                GROUP BY a.breed
                ORDER BY AverageWeight";
    
        $calculateAvgRequestResult = executePlainSQL($sql);
    }
    
    function handleInsertAnimalRequest()
    {
        global $db_conn;
    
        $tuple = array(
            ":bind1" => $_POST['animalID']
        );
    
        $alltuples = array(
            $tuple
        );
    
        $numExistingAnimal = executeBoundSQL("SELECT COUNT(*) AS count FROM RegisteredAnimal WHERE animalID = :bind1", $alltuples);
        $rowExistingAnimal = oci_fetch_assoc($numExistingAnimal);
        $countExistingAnimal = $rowExistingAnimal['COUNT'];
    
        //check if there exists the same animal
        if ($countExistingAnimal == 0) {
            $tuple = array(
                ":bind1" => $_POST['animalID'],
                ":bind2" => $_POST['name'],
                ":bind3" => $_POST['adopted'],
                ":bind4" => $_POST['description'],
                ":bind5" => $_POST['age'],
                ":bind6" => $_POST['weight'],
                ":bind7" => $_POST['breed'],
                ":bind8" => $_SESSION["shelterLocation"],
                ":bind9" => $_SESSION["shelterName"]
            );
    
            $alltuples = array(
                $tuple
            );
    
            executeBoundSQL("insert into RegisterdAnimal values (:bind1, :bind2, :bind3, :bind4, :bind5, :bind6, :bind7, :bind8, :bind9 )", $alltuples);
            OCICommit($db_conn);
            echo '<p style="color: green;">Successfully inserted into registerdAnimals</p>';
        } else {
            echo '<p style="color: red;">Invalid Animal inserted. Please use an animalID that is not already in use.</p>';
        }
    }
    
    function handleUpdateAnimalRequest()
    {
        global $db_conn;
    
        $tuple = array(
            ":bind1" => $_POST['animalID']
        );
    
        $alltuples = array(
            $tuple
        );
    
        $numExistingAnimal = executeBoundSQL("SELECT COUNT(*) AS count FROM RegisteredAnimal WHERE animalID = :bind1", $alltuples);
        $rowExistingAnimal = oci_fetch_assoc($numExistingAnimal);
        $countExistingAnimal = $rowExistingAnimal['COUNT'];
    
    
        if ($countExistingAnimal == 1) {
            // Update Animal
            $tuple1 = array(
                ":bind1" => $_POST['animalID'],
                ":bind2" => $_POST['name'],
                ":bind3" => $_POST['adopted'],
                ":bind4" => $_POST['description'],
                ":bind5" => $_POST['age'],
                ":bind6" => $_POST['weight'],
                ":bind7" => $_POST['breed'],
                ":bind8" => $_SESSION["shelterLocation"],
                ":bind9" => $_SESSION["shelterName"]
            );
    
            $alltuples1 = array(
                $tuple1
            );
    
            executeBoundSQL("UPDATE RegisteredAnimal SET  name = :bind2, adopted = :bind3, description = :bind4, age = :bind5, weight= :bind6, breed = :bind7, shelterLocation = :bind8, shelterName = :bind9 WHERE animalID = :bind1", $alltuples1);
            OCICommit($db_conn);
            echo '<p style="color: green;">Successfully updated animal</p>';
        } else {
            echo '<p style="color: red;">Invalid info inserted. Please use an already existing animalID.</p>';
        }
    }
    
    
    
    
    
    function handleSelectAnimalRequest()
    {
        global $db_conn;
        global $selectAnimalRequestResult;
    
        $breed = $_POST['breed'];
        $age = $_POST['age'];
        $operator = $_POST['operator'];
    
        //check if the input value is NULl
        if ($breed != NULL && $age != NULL) {
    
            $tuple = array(
                ":bind1" => $_POST['breed']
            );
    
            $alltuples = array(
                $tuple
            );
    
            // check if animals with breed 1 and breed 2 exists in our database
            $numExistingAnimals1 = executeBoundSQL("SELECT COUNT(*) AS count FROM RegisteredAnimal WHERE breed = :bind1", $alltuples);
            $rowExistingAnimals1 = oci_fetch_assoc($numExistingAnimals1);
            $countExistingAnimals1 = $rowExistingAnimals1['COUNT'];
    
            $tuple0 = array(
                ":bind1" => $_POST['age']
            );
    
            $alltuples0 = array(
                $tuple0
            );
    
            $numExistingAnimals2 = executeBoundSQL("SELECT COUNT(*) AS count FROM RegisteredAnimal WHERE age = :bind1", $alltuples0);
            $rowExistingAnimals2 = oci_fetch_assoc($numExistingAnimals2);
            $countExistingAnimals2 = $rowExistingAnimals2['COUNT'];
    
            if ($countExistingAnimals1 == 0 && $countExistingAnimals2 == 0) {
                echo '<p style="color: red;">No animal has those breeds</p>';
            } else {
                $tuple1 = array(
                    ":bind1" => $_POST['breed'],
                    ":bind2" => $_POST['age'],
                    ":bind3" => $_SESSION["shelterName"],
                    ":bind4" => $_SESSION["shelterLocation"]
                );
    
                $alltuples1 = array(
                    $tuple1
                );
    
                if ($operator == "And") {
                    $selectAnimalRequestResult = executeBoundSQL(
                        "SELECT * FROM RegisteredAnimal a
                    WHERE a.breed = :bind1 AND a.age = :bind2 AND a.shelterName = :bind3 AND a.shelterLocation = :bind4",
                        $alltuples1
                    );
                } else if ($operator == "Or") {
                    $selectAnimalRequestResult = executeBoundSQL("SELECT * FROM RegisteredAnimal a
            WHERE a.breed = :bind1 OR a.age = :bind2 AND a.shelterName = :bind3 AND a.shelterLocation = :bind4", $alltuples1);
                }
                ;
                echo '<p style="color: green;">Successfully select required animals.</p>';
            }
        } else {
            echo '<p style="color: red;">Cannot select null value.</p>';
        }
    }


    function handleFindVolunteerRequest() {
        global $db_conn;
        global $findVolRequestResult;

        // Only run the find query if the ID exists
        $volAvailabilities = $_POST['findVolDays'];
            
        if ($volAvailabilities != NULL) {
            $tuple = array (
                ":bind1" => $_POST['findVolDays']
            );
    
            $alltuples = array (
                $tuple
            );
    
            $numExistingDays = executeBoundSQL("SELECT COUNT(*) AS count FROM AvailableDaysRegularVolunteer WHERE availableDays = :bind1", $alltuples);
            $rowExistingDays = oci_fetch_assoc($numExistingDays);
            $countExistingDays = $rowExistingDays['COUNT'];

            if ($countExistingDays == 1) {
                $tuple1 = array (
                    ":bind1" => $_POST['findVolDays'],
                    ":bind2" => $_SESSION["shelterName"],
                    ":bind3" => $_SESSION["shelterLocation"]
                );
        
                $alltuples1 = array (
                    $tuple1
                );

                $findVolRequestResult = executeBoundSQL("SELECT v.volunteerID FROM VolunteersAtShelter s
                                INNER JOIN Volunteer v ON s.volunteerID = v.volunteerID
                                INNER JOIN AvailableDaysRegularVolunteer a ON v.availableDays = a.availableDays
                                WHERE s.shelterName = :bind2 AND s.shelterLocation = :bind3 AND a.availableDays = :bind1", $alltuples1);

                echo '<p style="color: green;">Successfully recieved all volunteers with given availabilities</p>';
            } else {
                echo '<p style="color: red;">No volunteer has those availabilities</p>';
            }
        } else {
            echo '<p style="color: red;">Cannot insert null value.</p>';
        }
    }

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
                ":bind3" => $_POST['adptEmail'],
                ":bind4" => $_POST['adptNum']
            );

            $alltuples = array (
                $tuple
            );

            executeBoundSQL("UPDATE AdoptersInfo SET adopterName = :bind2, email = :bind3, phoneNumber = :bind4 WHERE adopterID = :bind1", $alltuples);
            OCICommit($db_conn);
            echo '<p style="color: green;">Successfully updated adopter</p>';
        } else {
            echo '<p style="color: red;">Invalid info inserted. Please use an already existing adopter ID and a unique email.</p>';
        }
    }
    
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

        // only insert if the animal they are adopting exists in this shelter

        $tuple = array (
            ":bind1" => $_POST['adptAnimalID'],
            ":bind2" => $_SESSION["shelterName"],
            ":bind3" => $_SESSION["shelterLocation"]
        );

        $alltuples4 = array (
            $tuple
        );

        $numExisting = executeBoundSQL("SELECT COUNT(*) AS count FROM RegisteredAnimal WHERE animalID = :bind1 AND shelterName = :bind2 AND shelterLocation = :bind3", $alltuples4);
        $rowExisting = oci_fetch_assoc($numExisting);
        $countExisting4 = $rowExisting['COUNT'];

        if ($countExisting1 == 0 && $countExisting2 == 0 && $countExisting3 == 0 && $countExisting4 == 1) {
            // Adopter's postal code is a foreign key, so if it does not already exist in AdoptersLocation table, then add it to the table first
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

            // Insert into adopt relation
            // We insert into adopt relation first to meet total participation constraint on adopters and adopt. We can achieve this through deferring:
            executePlainSQL("SET CONSTRAINTS ALL DEFERRED");

            $currentDate = date('Y-m-d');
            
            $tuple1 = array (
                ":bind1" => $_POST['adptAnimalID'],
                ":bind2" => $_POST['adptID'],
                ":bind3" => $currentDate
            );

            $alltuples1 = array (
                $tuple1
            );

            executeBoundSQL("insert into Adopt values (:bind2, :bind1, TO_DATE(:bind3, 'YYYY-MM-DD'))", $alltuples1);

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

            // Set animal to adopted
            $tuple2 = array (
                ":bind1" => $_POST['adptAnimalID']
            );

            $alltuples2 = array (
                $tuple2
            );

            executeBoundSQL("Update RegisteredAnimal SET adopted = 1 where animalID = :bind1", $alltuples2);


            OCICommit($db_conn);
            echo '<p style="color: green;">Successfully inserted adopter</p>';
        } else {
            echo '<p style="color: red;">Invalid info inserted. Please use an adopter ID, national ID, and email that is not already in use. Please make sure to use an animal ID that exists in this shelter.</p>';
        }
    }

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
                $result_shel_name = executeBoundSQL("SELECT shelterName AS shelterName FROM Manager WHERE manID = :bind1", $alltuples);
                $shelName  = oci_fetch_assoc($result_shel_name);
                $currShelterName = $shelName['SHELTERNAME'];

                $result_shel_loc = executeBoundSQL("SELECT shelterLocation AS shelterLocation FROM Manager WHERE manID = :bind1", $alltuples);
                $shelLoc  = oci_fetch_assoc($result_shel_loc);
                $currShelterLoc = $shelLoc['SHELTERLOCATION'];
                
                $_SESSION["shelterName"] = $currShelterName;
                $_SESSION["shelterLocation"] = $currShelterLoc;

                header("Location: index.php");
                die;
            }
                
        echo " wrong username or password NO RESULT";
        } else{
        echo " wrong username or password!";
        }
}

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
            // Check if shelterName + shelterLocation exists in shelter

            // if exists yay
                // (i added more sample inserts for shelter that is not in manager table yet so you can use those to check this)
            // if not exists -> add it to shelter first

            // then also make sure that the COMBINATION of sheltername and shelterlocation is unique
            // if not -> send error message and do not add
            // else continue

            // Add new manager
            $tuple = array (
                ":bind1" => $_POST['manID'],
                ":bind2" => $_POST['manPassword'],
                ":bind3" => $_POST['shelterLocation'], 
                ":bind4" => $_POST['shelterName'], 
                ":bind5" => $_POST['manName'], 
                ":bind6" => $_POST['kpi'],  
                ":bind7" => $_POST['since']
            );

            $alltuples = array (
                $tuple
            );

            executeBoundSQL("insert into Manager values (:bind1, :bind2, :bind3, :bind4, :bind5, :bind6, :bind7)", $alltuples);
            OCICommit($db_conn);
            echo '<p style="color: green;">Signup successfull</p>';
        } else {
            echo '<p style="color: red;">Invalid ID inserted. Please use an ID that is not already in use.</p>';
        }
    }

    // ECE TODO: add logic to keep track of shelter name of the manager who logged in works at
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
            echo '<p style="color: green;">Successfully inserted into vets</p>';
        } else {
            echo '<p style="color: red;">Invalid ID inserted. Please use an ID that is not already in use.</p>';
        }
    }

    function handleInsertEventRequest() {
        global $db_conn;

        // Only run the insert event query if the primary key is not already being used
        $tuple = array (
            ":bind1" => $_POST['eventName'],
            ":bind5" => $_SESSION["shelterLocation"],
            ":bind6" => $_SESSION["shelterName"]
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
                ":bind5" => $_SESSION["shelterLocation"],
                ":bind6" => $_SESSION["shelterName"]
            );

            $alltuples = array (
                $tuple
            );

            executeBoundSQL("insert into EventsHosted values (:bind1, :bind2, :bind3, TO_DATE(:bind4, 'YYYY-MM-DD'), :bind5, :bind6)", $alltuples);
            OCICommit($db_conn);
            echo '<p style="color: green;">Successfully inserted into events</p>';
        } else {
            echo '<p style="color: red;">Invalid Event inserted. Please use event name, shelter name and location that is not already in use.</p>';
        }
    }

    function handleUpdateEventRequest() {
        global $db_conn;

        // Only run the update query if these exist
        $tuple = array (
            ":bind1" => $_POST['eventName'],
            ":bind5" => $_SESSION["shelterLocation"],
            ":bind6" => $_SESSION["shelterName"]
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
                ":bind5" => $_SESSION["shelterLocation"],
                ":bind6" => $_SESSION["shelterName"],
            );

            $alltuples1 = array (
                $tuple1
            );

            executeBoundSQL("UPDATE EventsHosted SET eventDescription = :bind2, cost = :bind3, eventDate = TO_DATE(:bind4, 'YYYY-MM-DD') WHERE eventName = :bind1 AND shelterLocation = :bind5 AND shelterName = :bind6", $alltuples1);
            OCICommit($db_conn);
            echo '<p style="color: green;">Successfully updated event</p>';
        } else {
            echo '<p style="color: red;">Invalid info inserted. Please use an already existing event name, shelter location and shelter name.</p>';
        }
    }

    function handleDeleteEventRequest() {
        global $db_conn;

        // Only run the insert event query if the primary key is not already being used
        $tuple = array (
            ":bind1" => $_POST['eventName'],
            ":bind5" => $_SESSION["shelterLocation"],
            ":bind6" => $_SESSION["shelterName"]
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
                ":bind5" => $_SESSION["shelterLocation"],
                ":bind6" => $_SESSION["shelterName"]
            );

            $alltuples = array (
                $tuple
            );

            executeBoundSQL("DELETE FROM EventsHosted WHERE eventName = :bind1 AND shelterLocation = :bind5 AND shelterName = :bind6", $alltuples);
            OCICommit($db_conn);
            echo '<p style="color: green;">Successfully deleted event</p>';
        } else {
            echo '<p style="color: red;">This event does not exist. Please use an event name, shelter name and location that is already in use.</p>';
        }
    }

    function handleInsertInspectorRequest() {
        global $db_conn;

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
                ":bind2" => $_SESSION["shelterName"],
                ":bind3" => $_SESSION["shelterLocation"],
                ":bind4" => $_POST['standardsMet']
            );

            $alltuples1 = array (
                $tuple1
            );

            executeBoundSQL("insert into Inspect values (:bind1, :bind3, :bind2, :bind4)", $alltuples1);
            OCICommit($db_conn);
            echo '<p style="color: green;">Successfully inserted inspector</p>';
        } else {
            echo '<p style="color: red;">Invalid ID inserted. Please use an ID that is not already in use.</p>';
        }
    }

    function handleInsertVolunteerRequest() {
        global $db_conn;

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
                ":bind2" => $_SESSION["shelterLocation"],
                ":bind3" => $_SESSION["shelterName"],
                ":bind4" => $currentDate
            );

            $alltuples = array (
                $tuple
            );

            executeBoundSQL("insert into VolunteersAtShelter values (:bind1, :bind2, :bind3, TO_DATE(:bind4, 'YYYY-MM-DD'))", $alltuples);
            OCICommit($db_conn);
            echo '<p style="color: green;">Successfully inserted new volunteer</p>';
        } else {
            echo '<p style="color: red;">Invalid ID inserted. Please use an ID that is not already in use.</p>';
        }
    }

    function handleResetRequest() {        
        global $db_conn;

        // Drop, Create, and Populate all tables
        $sqlScript = file_get_contents(__DIR__ . '/DDL/InitializeTableStatements.sql');
        $sqlStatements = explode(';', $sqlScript);
        $sqlStatements = array_filter(array_map('trim', $sqlStatements));
        foreach ($sqlStatements as $sqlStatement) {
            executePlainSQL($sqlStatement);
        }

        $sqlScriptAssertions = file_get_contents(__DIR__ . '/DDL/Triggers.sql');
        executePlainSQL($sqlScriptAssertions);
        
        OCICommit($db_conn);
    }

    /* SELINA TODO:
        - because we only have "on delete CASCADE" in animals tables, we need to implement ability for user to delete a cat/dog/bird to meet the ruric requirement
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