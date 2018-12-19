<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tac-1";
$alumne = $_GET["id"];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {

    $sql = "DELETE FROM alumnes WHERE id=" . $alumne;

    if ($conn->query($sql) === TRUE) {
        echo true;
    } else {
        echo false;
    }

    $conn->close();
}