
<html>
    <head>
        <meta charset="UTF-8">
        <title>Menu d'intercanvi</title>
    </head>
    <body>
        <?php
        // put your code here
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "tac-1";
        $intercanvi = $_GET["id"];


        if ($intercanvi) {

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM intercanvis WHERE id=" . $intercanvi;
            $result = $conn->query($sql);
            $mostrarIntercanvis = "";

            if ($result->num_rows > 0) {
                // output data of each row
                $mostrarIntercanvis .= "<table>";
                $mostrarIntercanvis .= "<tr>";
                $mostrarIntercanvis .= "<th colspan='2'>Informacio d'intercanvi:</th>";
                $mostrarIntercanvis .= "</tr>";





                while ($row = $result->fetch_assoc()) {
                    $mostrarIntercanvis .= "<tr>";
                    $mostrarIntercanvis .= "<td>Nom</td>";
                    $mostrarIntercanvis .= "<td>" . $row["nom"] . "</td>";
                    $mostrarIntercanvis .= "</tr>";
                    $mostrarIntercanvis .= "<tr>";
                    $mostrarIntercanvis .= "<td>Data del curs</td>";
                    $mostrarIntercanvis .= "<td>" . $row["data_curs"] . "</td>";
                    $mostrarIntercanvis .= "</tr>";
                    $mostrarIntercanvis .= "<tr>";
                    $mostrarIntercanvis .= "<td>Descripcio</td>";
                    $mostrarIntercanvis .= "<td>" . $row["descripcio"] . "</td>";
                    $mostrarIntercanvis .= "</tr>";
                    $mostrarIntercanvis .= "<tr>";
                    $mostrarIntercanvis .= "<td><input type='button' value='Modificar' onclick='modificarIntercanvi(" . $row["id"] . ")'></td>";
                    $mostrarIntercanvis .= "<td><input type='button' value='Eliminar' onclick='eliminarIntercanvi(" . $row["id"] . ")'></td>";
                    $mostrarIntercanvis .= "</tr>";
                }

                $mostrarIntercanvis .= "</table>";

                $sql = "SELECT * FROM alumnes WHERE id_intercanvi=" . $intercanvi;
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $mostrarIntercanvis .= "<table>";
                    $mostrarIntercanvis .= "<tr>";
                    $mostrarIntercanvis .= "<th colspan='5'>Llistat d'alumnes:</th>";
                    $mostrarIntercanvis .= "</tr>";
                    $mostrarIntercanvis .= "<tr>";
                    $mostrarIntercanvis .= "<td>Cognoms, Nom</td>";
                    $mostrarIntercanvis .= "<td>Correu</td>";
                    $mostrarIntercanvis .= "<td>Residencia</td>";
                    $mostrarIntercanvis .= "<td>Formulari omplert</td>";
                    $mostrarIntercanvis .= "<td>Reenviar missatge</td>";
                    $mostrarIntercanvis .= "</tr>";

                    while ($row = $result->fetch_assoc()) {
                        $mostrarIntercanvis .= "<tr>";
                        $mostrarIntercanvis .= "<td>" . $row["cognoms"] . ", " . $row["nom"] . "</td>";
                        $mostrarIntercanvis .= "<td>" . $row["correu"] . "</td>";
                        if ($row["local"]) {
                            $mostrarIntercanvis .= "<td>Local</td>";
                        } else {
                            $mostrarIntercanvis .= "<td>Forani</td>";
                        }
                        $sql = "SELECT * FROM respostes WHERE id_alumne=" . $row["id"] . ", id_intercanvi=" . $intercanvi;


                        if ($result_complet = $conn->query($sql)) {
                            if ($result_complet->num_rows < 16) {
                                $mostrarIntercanvis .= "<td>No</td>";
                            } else {
                                $mostrarIntercanvis .= "<td>Si</td>";
                            }
                        } else {
                            $mostrarIntercanvis .= "<td>No</td>";
                        }


                        $mostrarIntercanvis .= "</tr>";
                    }
                } else {
                    $mostrarIntercanvis .= "0 Alumnes";
                }
            } else {
                $mostrarIntercanvis = "Cap intercanvi";
            }


            $conn->close();
        }
        ?>
        <input type="button" value="Tornar enradera" onclick="window.location.href = 'http://localhost/tac-1/index.php'"> <br>
        <div id="informacio"><?php echo $mostrarIntercanvis ?></div>
        <div id="res"></div>
    </body>
    <script type="text/javascript">
        function eliminarIntercanvi(id) {
            var conf = confirm("Estas segur que vols borrar aquest intercanvi?");
            if (conf) {

                //CRIDAR AJAX
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        console.log(this.responseText);
                        var resposta = JSON.parse(this.responseText);

                        if (resposta.error) {

                            document.getElementById("res").innerHTML = resposta.msg;
                        } else {
                            document.getElementById("informacio").innerHTML = resposta.msg;
                            window.setTimeout(function () {
                                window.location = 'index.php';
                            }, 2000);

                        }

                    }

                };
                xmlhttp.open("GET", "deleteIntercanvi.php?id=" + id, true);
                xmlhttp.send();
            }


        }

        function modificarIntercanvi(id) {
            newwindow = window.open("modificarIntercanvi.php?id="+id, 'name', 'height=500,width=500');
            if (window.focus) {
                newwindow.focus()
            }
            return false;
        }

    </script>
</html>