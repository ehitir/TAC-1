
<html>
    <head>
        <meta charset="UTF-8">
        <title>Menu d'intercanvi</title>
    </head>
    <body onload="mostrarAlumnes(<?php echo $_GET["id"]; ?>)">
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
            } else {

                $sql = "SELECT * FROM intercanvis WHERE id=" . $intercanvi;
                $result = $conn->query($sql);
                $mostrarIntercanvis = "";

                if ($result->num_rows > 0) {
                    // output data of each row
                    $mostrarIntercanvis .= "<form method='POST'  onsubmit='' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' name='formIntercanvi'>";
                    $mostrarIntercanvis .= "<table>";
                    $mostrarIntercanvis .= "<tr>";
                    $mostrarIntercanvis .= "<th colspan='2'>Informacio d'intercanvi:</th>";





                    while ($row = $result->fetch_assoc()) {
                        $mostrarIntercanvis .= "<tr>";
                        $mostrarIntercanvis .= "<td>Nom</td>";
                        $mostrarIntercanvis .= "<td><input type='text' value='" . $row["nom"] . "' name='name_intercanvi'> </td>";
                        $mostrarIntercanvis .= "</tr>";
                        $mostrarIntercanvis .= "<tr>";
                        $mostrarIntercanvis .= "<td>Data del curs</td>";
                        $mostrarIntercanvis .= "<td><input type='text' value='" . $row["data_curs"] . "' name='curs_intercanvi'></td>";
                        $mostrarIntercanvis .= "</tr>";
                        $mostrarIntercanvis .= "<tr>";
                        $mostrarIntercanvis .= "<td>Descripcio</td>";
                        $mostrarIntercanvis .= "<td><textarea required style='resize:none' cols='40' rows='5' name='descripcio_intercanvi'>" . $row["descripcio"] . "</textarea></td>";
                        $mostrarIntercanvis .= "</tr>";
                        $mostrarIntercanvis .= "<tr>";
                        $mostrarIntercanvis .= "</tr>";
                    }

                    $mostrarIntercanvis .= "</table>";


                    $mostrarIntercanvis .= "<table style='border: 1px solid black;'>";
                    $mostrarIntercanvis .= "<tr>";
                    $mostrarIntercanvis .= "<th colspan='3'>Afegir alumnes:</th>";
                    $mostrarIntercanvis .= "</tr>";
                    $mostrarIntercanvis .= "<tr>";
                    $mostrarIntercanvis .= "<td>Nom <span id='nom_error'></span></td>";
                    $mostrarIntercanvis .= "<td>Cognoms <span id='cognom_error'></span></td>";
                    $mostrarIntercanvis .= "<td>Correu <span id='mail_error'></span></td>";
                    $mostrarIntercanvis .= "</tr>";
                    $mostrarIntercanvis .= "<tr>";
                    $mostrarIntercanvis .= "<td><input type='text' id='nom_alumne' ></td>";
                    $mostrarIntercanvis .= "<td><input type='text' id='cognom_alumne' ></td>";
                    $mostrarIntercanvis .= "<td><input type='text' id='correu' ></td>";
                    $mostrarIntercanvis .= "</tr>";
                    $mostrarIntercanvis .= "<tr>";
                    $mostrarIntercanvis .= "<td>L'alumne es local o forani?</td>";
                    $mostrarIntercanvis .= "<td><input type='button' onclick='afegirAlumne(0, " . $intercanvi . ")' value='local' style='width: 148px'></td>";
                    $mostrarIntercanvis .= "<td><input type='button' onclick='afegirAlumne(1, " . $intercanvi . ")' value='forani' style='width: 148px'></td>";
                    $mostrarIntercanvis .= "</tr>";
                    $mostrarIntercanvis .= "</table>";
                } else {
                    $mostrarIntercanvis = "Cap intercanvi";
                }
            }



            $conn->close();
        }
        ?>
        <input type="button" value="Guardar canvis" onclick="window.opener.location.reload(); window.close();window.opener = self; window.close();"> <br>
        <div id="informacio"><?php echo $mostrarIntercanvis ?></div>
        <div id="taulaAlumnes"></div>
    </body>
    <script type="text/javascript">

        function mostrarAlumnes(id) {


            //CRIDAR AJAX
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                    if (this.responseText) {
                        document.getElementById("taulaAlumnes").innerHTML = this.responseText;
                    }


                }

            };
            xmlhttp.open("GET", "mostrarAlumne.php?id=" + id, true);
            xmlhttp.send();
        }

        function eliminarAlumne(id_alumne, id_intercanvi) {

            //CRIDAR AJAX
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                    if (this.responseText) {
                        mostrarAlumnes(id_intercanvi);
                    }


                }

            };
            xmlhttp.open("GET", "eliminarAlumne.php?id=" + id_alumne, true);
            xmlhttp.send();

        }

        function afegirAlumne(opc, id_intercanvi) {

            var nom = document.getElementById("nom_alumne").value;
            var cognom = document.getElementById("cognom_alumne").value;
            var mail = document.getElementById("correu").value;
            var local = false;
            var error = false;
            var format_nom = /^[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/g;
            var format_cognom = /^[a-zA-ZÀ-ÿ\u00f1\u00d1]+( [a-zA-ZÀ-ÿ\u00f1\u00d1]+)*$/g;
            var format_mail = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
            if (format_nom.test(nom)) {
                document.getElementById("nom_error").innerHTML = "";
            } else {
                document.getElementById("nom_error").style.color = "red";
                document.getElementById("nom_error").innerHTML = "*";
                error = true;
            }
            if (format_cognom.test(cognom)) {
                document.getElementById("cognom_error").innerHTML = "";

            } else {
                document.getElementById("cognom_error").style.color = "red";
                document.getElementById("cognom_error").innerHTML = "*";
                error = true;
            }
            if (format_mail.test(mail)) {
                document.getElementById("mail_error").innerHTML = "";
            } else {
                document.getElementById("mail_error").style.color = "red";
                document.getElementById("mail_error").innerHTML = "*";
                error = true;
            }

            if (!error) {


                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        console.log("Resposta: " + this.responseText);
                        if (!this.responseText) {
                            mostrarAlumnes(id_intercanvi);
                        }


                    }

                };
                xmlhttp.open("GET", "afegirAlumne.php?id_intercanvi=" + id_intercanvi + "&nom=" + nom + "&cognom=" + cognom + "&correu=" + mail + "&local=" + opc, true);
                xmlhttp.send();

                document.getElementById("nom_alumne").value = "";
                document.getElementById("cognom_alumne").value = "";
                document.getElementById("correu").value = "";
            }


        }




    </script>
</html>