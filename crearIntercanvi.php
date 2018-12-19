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
    <body>

        <?php
        // put your code here
        // https://www.w3schools.com/php/showphp.asp?filename=demo_form_validation_complete
        //Variables 
        $nom_intercanvi = "";
        $curs = "";
        $descripcio = "";
        $llistaALocal = "";
        $llistaAForanis = "";

        //Variables d'errors
        $nomError = "";
        $cursError = "";
        $descripcioError = "";
        $alumneFError = "";
        $alumneLError = "";

        $errors = false;
        $error_sql = false;
        $cons = new \stdClass();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {


            if (empty($_POST["name_intercanvi"])) {
                $nomError = "S'ha d'introduir un nom per l'intercanvi.";
                $errors = true;
            } else {
                $nom_intercanvi = $_POST["name_intercanvi"];
                // Comprovem que tingui caracters valids.
                if (!preg_match("/^[a-zA-Z ]*$/", $nom_intercanvi)) {
                    $nomError = "Has introduit caracters no valids.";
                    $errors = true;
                }
            }

            if (empty($_POST["curs_intercanvi"])) {
                $cursError = "S'ha d'introduir un curs.";
                $errors = true;
            } else {
                $curs = $_POST["curs_intercanvi"];
                // Comprovem que tingui caracters valids.
                if (!preg_match("/^[0-9]{2}(-[0-9]{2})?$/", $curs)) {
                    $cursError = "Nomes es pot escriure numeros i guions.";
                    $errors = true;
                }
            }
            if (empty($_POST["descripcio_intercanvi"])) {
                $descripcioError = "S'ha d'introduir una descripcio per l'intercanvi.";
                $errors = true;
            } else {
                $descripcio = str_replace("'", "''", $_POST["descripcio_intercanvi"]);
            }
            if (!$errors) {
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "tac-1";
                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "INSERT INTO `intercanvis`(`nom`, `data_curs`, `descripcio`) VALUES ('" . $nom_intercanvi . "', '" . $curs . "','" . $descripcio . "')";
                $id_intercanvi = "";
                if ($conn->query($sql) === TRUE) {
                    $id_intercanvi = $conn->insert_id;
                    $cons->error = false;
                    $cons->msg = "New 'Intercanvi' created successfully";
                    console_log($cons);
                } else {
                    $error_sql = true;
                    $cons->error = true;
                    $cons->msg = "Error: " . $sql . "<br>" . $conn->error;
                    console_log($cons);
                }

                $alumnes_locals = $_POST["locals_intercanvi"];
                if ($alumnes_locals) {
                    if (insertAlumnes($conn, $alumnes_locals, 0, $id_intercanvi)) {
                        $error_sql = true;
                    }
                    
                }

                $alumnes_foranis = $_POST["foranis_intercanvi"];
                if ($alumnes_foranis) {
                    if (insertAlumnes($conn, $alumnes_foranis, 1, $id_intercanvi)) {
                        $error_sql = true;
                    }
                }
            }
            if (!$error_sql) {
                sleep(2);
                $msg = "Intercanvi creat correctament.";
                echo "<script type='text/javascript'>alert('$msg');</script>";
                header("Location: index.php"); /* Redirect browser */
            exit();
            }
            
        }

        function insertAlumnes($conn, $stringAlumnes, $opc, $id_intercanvi) {
            $cons = new \stdClass();
            $stringAlumnes = str_replace("\r\n", "", $stringAlumnes);
            $arrayAlumnes = explode(";", $stringAlumnes);
            foreach ($arrayAlumnes as $alumne) {



                $alumneSplit = preg_split("/[,<>]+/", $alumne);
                $checkAlumne = trim($alumneSplit[0]);
                if ($checkAlumne != "" || $checkAlumne != null) {
                    if ($opc == 0) {
                        $local = true;
                    } else {
                        $local = false;
                    }
                    $sql = "INSERT INTO `alumnes`(`id_intercanvi`, `nom`, `cognoms`, `correu`,`local`) VALUES ('" . $id_intercanvi . "', '" . $alumneSplit[1] . "', '" . $alumneSplit[0] . "', '" . $alumneSplit[2] . "', '" . $local . "')";
                    if ($conn->query($sql) === TRUE) {
                        $cons->error = false;
                        $cons->msg = "New 'Alumne' created successfully";
                        console_log($cons);
                        return false;
                    } else {
                        $cons->error = true;
                        $cons->msg = "Error: " . $sql . "<br>" . $conn->error;
                        console_log($cons);
                        return true;
                    }
                }
            }
        }

        function console_log($data) {
            echo '<script>';
            echo 'console.log(' . json_encode($data) . ')';
            echo '</script>';
        }
        ?>

        <input type="button" value="Tornar enradera" onclick="window.location.href = 'http://localhost/tac-1/index.php'"> <br>

        <h2>Nou intercanvi: </h2> <br>

        <form method="POST"  onsubmit="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="formIntercanvi">
            Nom: <input type="text" name="name_intercanvi" value="<?php if (isset($_POST["name_intercanvi"])) echo $_POST["name_intercanvi"]; ?>" required><span class="error"> <?php echo $nomError; ?></span><br>
            Curs: <input type="text" name="curs_intercanvi" value="<?php if (isset($_POST["curs_intercanvi"])) echo $_POST["curs_intercanvi"]; ?>" required><span class="error"> <?php echo $cursError; ?></span><br>
            Descripcio <span class="error"> <?php echo $descripcioError; ?></span><br><textarea required style="resize:none" cols="58" rows="5" name="descripcio_intercanvi"><?php if (isset($_POST["descripcio_intercanvi"])) echo $_POST["descripcio_intercanvi"]; ?></textarea><br>
            <table style="border: 1px solid black;">
                <tr>
                    <th colspan="3">Afegir alumnes:</th>
                </tr>
                <tr>
                    <td>Nom <span id="nom_error"></span></td>
                    <td>Cognoms <span id="cognom_error"></span></td>
                    <td>Correu <span id="mail_error"></span></td>
                </tr>
                <tr>
                    <td><input type="text" id="nom_alumne" ></td>
                    <td><input type="text" id="cognom_alumne" ></td>
                    <td><input type="text" id="correu" ></td>

                </tr>
                <tr>
                    <td>L'alumne es local o forani?</td>
                    <td><input type="button" onclick="afegirAlumne(0)" value="local" style='width: 148px'></td>
                    <td><input type="button" onclick="afegirAlumne(1)" value="forani" style='width: 148px'></td>
                </tr>

            </table>

            <table style="border: 1px solid black;">
                <tr>
                    <th colspan="2">Llistat d'alumnes</th>
                </tr>
                <tr>
                    <td>Locals</td>
                    <td>Foranis</td>
                </tr>
                <tr>
                    <td><textarea readonly cols="50" rows="10" id="locals_intercanvi" name="locals_intercanvi"><?php if (isset($_POST["locals_intercanvi"])) echo $_POST["locals_intercanvi"]; ?></textarea></td>
                    <td><textarea readonly cols="50" rows="10" id="foranis_intercanvi" name="foranis_intercanvi"><?php if (isset($_POST["foranis_intercanvi"])) echo $_POST["foranis_intercanvi"]; ?></textarea></td>
                </tr>
            </table>




            <input type="submit" value="Crear intercanvi">
            <input type="reset">

        </form>
        <div id='resultat'></div>

    </body>
    <script type="text/javascript">
        function afegirAlumne(opc) {
            var nom = document.getElementById("nom_alumne").value;
            var cognom = document.getElementById("cognom_alumne").value;
            var mail = document.getElementById("correu").value;
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

                switch (opc) {
                    case 0:
                        var content = document.getElementById("locals_intercanvi").value;
                        document.getElementById("locals_intercanvi").value = content + cognom + ", " + nom + " <" + mail + ">;\n";
                        break;
                    case 1:
                        var content = document.getElementById("foranis_intercanvi").value;
                        document.getElementById("foranis_intercanvi").value = content + cognom + ", " + nom + " <" + mail + ">;\n";
                        break;
                    default:
                }
                document.getElementById("nom_alumne").value = "";
                document.getElementById("cognom_alumne").value = "";
                document.getElementById("correu").value = "";
            }


        }
    </script>
</html>
