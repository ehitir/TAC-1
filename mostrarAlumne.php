<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tac-1";
$intercanvi = $_GET["id"];
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    $sql = "SELECT * FROM alumnes WHERE id_intercanvi=" . $intercanvi;
    $result = $conn->query($sql);
    $mostrarAlumnes = "";
    if ($result->num_rows > 0) {
        
        $mostrarAlumnes .= "<table>";
        $mostrarAlumnes .= "<tr>";
        $mostrarAlumnes .= "<th colspan='5'>Llistat d'alumnes:</th>";
        $mostrarAlumnes .= "</tr>";
        $mostrarAlumnes .= "<tr>";
        $mostrarAlumnes .= "<td>Cognoms, Nom</td>";
        $mostrarAlumnes .= "<td>Correu</td>";
        $mostrarAlumnes .= "<td>Residencia</td>";
        $mostrarAlumnes .= "<td>Formulari omplert</td>";
        $mostrarAlumnes .= "<td>Eliminar Alumne</td>";
        $mostrarAlumnes .= "</tr>";

        while ($row = $result->fetch_assoc()) {
            $id_alumne = $row["id"];
            $mostrarAlumnes .= "<tr>";
            $mostrarAlumnes .= "<td>" . $row["cognoms"] . ", " . $row["nom"] . "</td>";
            $mostrarAlumnes .= "<td>" . $row["correu"] . "</td>";
            if ($row["local"]) {
                $mostrarAlumnes .= "<td>Local</td>";
            } else {
                $mostrarAlumnes .= "<td>Forani</td>";
            }
            $sql = "SELECT * FROM respostes WHERE id_alumne=" . $row["id"] . ", id_intercanvi=" . $intercanvi;


            if ($result_complet = $conn->query($sql)) {
                if ($result_complet->num_rows < 16) {
                    $mostrarAlumnes .= "<td>No</td>";
                } else {
                    $mostrarAlumnes .= "<td>Si</td>";
                }
            } else {
                $mostrarAlumnes .= "<td>No</td>";
            }
            $mostrarAlumnes .= "<td><input type='button' onclick='eliminarAlumne(".$id_alumne.", ".$intercanvi.")' value='X'><td>";

            $mostrarAlumnes .= "</tr>";
            
        }
        $mostrarAlumnes .= "</table>";
    } else {
        $mostrarAlumnes .= "0 Alumnes";
    }
    echo $mostrarAlumnes;
}
