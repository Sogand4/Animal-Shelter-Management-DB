<?php
    // establish DB connection
    include 'DB/connection.php';
    $conn = OpenCon();
    echo "Connected Successfully";


    // When this button is pressed, insert the user inputted values of (id, name) into the db table named "test"
    // this assumes test table already exists
    
    // Check if the form is submitted
    if(isset($_POST['submit'])) {
        // Get user input
        $id = $_POST['id'];
        $name = $_POST['name'];
        
        // Insert the user input into the "test" table
        $sql = "INSERT INTO test (id, name) VALUES ('$id', '$name')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Record inserted successfully\n";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    CloseCon($conn);

    echo 'Welcome to PHP <br/>';
    echo date('Y-m-d H:i:s');
?>



<!DOCTYPE html>
<html>
<head>
    <title>Insert Data</title>
</head>
<body>
    <!-- Create a simple form with fields for id and name -->
    <form method="POST">
        ID: <input type="text" name="id"><br>
        Name: <input type="text" name="name"><br>
        <input type="submit" name="submit" value="Insert">
    </form>
</body>
</html>