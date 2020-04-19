<?php

//using Docker service name as mysql connection
$conn = new mysqli("mysql", "admin", "pa**w0rd", "my_db");
//check connection
if ($conn->connect_error) {
    die("Connected failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo $row['firstName'] . " " . $row['lastName'] . "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
