<?php
    $db_conn = NULL;

    function connectToDB() {
        global $db_conn;

        $db_conn = OCILogon("USER", "PASSWORD", "dbhost.students.cs.ubc.ca:1522/stu");

        if ($db_conn) {
            //debugAlertMessage("Database is Connected");
            return true;
        } else {
            //debugAlertMessage("Cannot connect to Database");
            $e = OCI_Error(); // For OCILogon errors pass no handle
            echo htmlentities($e['message']);
            echo "failed connection to db";
            return false;
        }
    }

    function disconnectFromDB() {
        global $db_conn;

        //debugAlertMessage("Disconnect from Database");
        OCILogoff($db_conn);
    }    
?>