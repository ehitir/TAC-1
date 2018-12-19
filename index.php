<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <?php
        // put your code here
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "tac-1";


// Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM intercanvis";
        $result = $conn->query($sql);
        $mostrarIntercanvis = "";
        
        if ($result->num_rows > 0) {
            // output data of each row
            $mostrarIntercanvis .= "<table>";
            $mostrarIntercanvis .= "<tr>";
            $mostrarIntercanvis .= "<th>Llista d'intercanvis</th>";
            $mostrarIntercanvis .= "</tr>";
            while ($row = $result->fetch_assoc()) {
                $mostrarIntercanvis .= "<tr>";
                $mostrarIntercanvis .= "<td><a href='showIntercanvis.php?id=".$row["id"]."'>".$row["nom"]." ".$row["data_curs"]."</a></td>";
                $mostrarIntercanvis .= "</tr>";
                
            }
            $mostrarIntercanvis .= "</table>";
        } else {
            $mostrarIntercanvis = "1 results";
        }
        $conn->close();
        
        ?>
    <body>
        <div id="titol"><h1>Admin:</h1> </div>
        <input type="button" value="Afegir Intercanvi" onclick="window.location.href='http://localhost/tac-1/crearIntercanvi.php'"> 
        
        <div>
        <?php echo $mostrarIntercanvis ?>
        </div>
    </body>
</html>
