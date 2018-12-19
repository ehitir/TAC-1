<?php
//DB PARAMETERS
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tac-1";
$conn = new mysqli($servername, $username, $password, $dbname);



$id_intercanvi = $_GET["id_intercanvi"];
$nom = $_GET["nom"];
$cognom = $_GET["cognom"];
$correu = $_GET["correu"];
$opc = $_GET["local"];
$local = false;
if ($opc == 0) {
    $local = true;
}


$sql = "INSERT INTO `alumnes`(`id_intercanvi`, `nom`, `cognoms`, `correu`,`local`) VALUES ('" . $id_intercanvi . "', '" . $nom . "', '" . $cognom . "', '" . $correu . "', '" . $local . "')";
        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
