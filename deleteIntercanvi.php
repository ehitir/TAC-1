<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tac-1";
$resposta = new \stdClass();
$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "DELETE FROM alumnes WHERE id_intercanvi=" . $_REQUEST["id"];

if ($conn->query($sql) === TRUE) {
    $sql = "DELETE FROM intercanvis WHERE id=" . $_REQUEST["id"];
    if ($conn->query($sql) === TRUE) {
    $resposta->error = false;
    $resposta->msg = "Intercanvi eliminat correctament. Redirigint...";
    } else {
        $msg = "Error deleting intercanvi: " . $conn->error;
        $resposta->error = true;
        $resposta->msg = "";
    }
} else{
    $msg = "Error deleting alumnes: " . $conn->error;
    $resposta->error = true;
    $resposta->msg = "";
}

$conn->close();
$myJSON = json_encode($resposta);
echo $myJSON;
