<?php

    require_once('connection.php');

    if (isset($_POST['reset']) || isset($_POST['insertSubmit'])) {
        handlePOSTRequest();
    }

    // HANDLE ALL POST ROUTES
    function handlePOSTRequest() {
        if (connectToDB()) {
            if (array_key_exists('insertQueryRequest', $_POST)) {
                handleInsertVolunteerRequest();
            }
            else if (array_key_exists('resetTablesRequest', $_POST)) {
                handleResetRequest();
            }

            disconnectFromDB();
        }
    }

    // SOGAND TODO: ADD ERROR HANDLING FOR INCORRECT INPUT TYPE. DISPLAY ERROR TO USER.
    function handleInsertVolunteerRequest() {
        global $db_conn;

        //Getting the values from user and insert data into the table
        $tuple = array (
            ":bind1" => $_POST['insNo'],
            ":bind2" => $_POST['insName']
        );

        $alltuples = array (
            $tuple
        );

        executeBoundSQL("insert into Test1 values (:bind1, :bind2)", $alltuples);
        OCICommit($db_conn);
    }

    // TODO: Maybe have this reset button on the navigation bar? next to logout?
    // TODO: we should also have the basic populate tables run after the tables are created as well
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