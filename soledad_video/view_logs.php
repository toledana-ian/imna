<?php
function dbConnect(){
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

    return $conn;
}

function dbDisconnect($conn){
    $conn->close();
}

function pr($data){
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

$conn = dbConnect();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Logs</title>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

    <script>
        $(function(){
            let dataset = [
                <?php
                $sql = "SELECT * FROM visit_logs";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo '['.
                            '"'.$row['client_ip'].'",'.
                            '"'.$row['referer'].'",'.
                            '"'.$row['user_agent'].'",'.
                            '"'.$row['created'].'"'.
                            '],';
                    }
                }
                ?>
            ];

            $('#example').DataTable({
                data: dataset,
                columns: [
                    { title: "IP" },
                    { title: "Referer" },
                    { title: "User Agent" },
                    { title: "Created" },
                ]
            });
        });
    </script>
</head>
<body>
<table id="example" class="display" style="width:100%"></table>
</body>
</html>

<?php dbDisconnect($conn); ?>