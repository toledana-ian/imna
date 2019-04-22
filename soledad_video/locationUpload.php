<?php

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $servername = "localhost";
    $username = "toledana";
    $password = "09092666456";
    $dbname = "logging";

// Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO location_logs (client_ip, altitude, heading, latitude, longitude, speed, accuracy) ".
            "VALUES (".
                "'".$_SERVER['REMOTE_ADDR']."', ".
                "'".$_REQUEST['altitude']."', ".
                "'".$_REQUEST['heading']."', ".
                "'".$_REQUEST['latitude']."', ".
                "'".$_REQUEST['longitude']."', ".
                "'".$_REQUEST['speed']."', ".
                "'".$_REQUEST['accuracy']."' ".
            ")";


    if ($conn->query($sql) === TRUE) {
        //echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

}
?>