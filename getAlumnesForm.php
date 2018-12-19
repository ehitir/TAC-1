<!DOCTYPE html>
<html>
    <head>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
            }

            table, td, th {
                border: 1px solid black;
                padding: 5px;
            }

            th {text-align: left;}
        </style>
    </head>
    <body>

        <?php
        $id_alumne = $_GET["id_alumne"];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {


            if (empty($_POST["questio_3"])) {
                $nomError = "S'ha d'introduir una data de naixement.";
                $errors = true;
            } else {
                $data_naixement = $_POST["questio_3"];
            }
            if (empty($_POST["questio_4"])) {
                $nomError = "S'ha d'introduir una ciutat de residencia.";
                $errors = true;
            } else {
                $ciutat = $_POST["questio_4"];
            }
            if (empty($_POST["questio_5"])) {
                $nomError = "S'ha d'introduir un numero de telefon";
                $errors = true;
            } else {
                $telefon = $_POST["questio_5"];
            }
            if (empty($_POST["questio_6"])) {
                $nomError = "S'ha d'introduir una clase.";
                $errors = true;
            } else {
                $grup = $_POST["questio_6"];
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


                $sql = "INSERT INTO `respostes`(`id_questio`, `id_alumne`, `valor`) VALUES (3," . $id_alumne . "," . $data_naixement . ")";
                if ($conn->query($sql) === TRUE) {
                    $id_intercanvi = $conn->insert_id;
                    $cons->error = false;
                    $cons->msg = "New resposta inserted successfully";
                    console_log($cons);
                } else {
                    $error_sql = true;
                    $cons->error = true;
                    $cons->msg = "Error: " . $sql . "<br>" . $conn->error;
                    console_log($cons);
                }

                $sql = "INSERT INTO `respostes`(`id_questio`, `id_alumne`, `valor`) VALUES (4," . $id_alumne . "," . $ciutat . ")";
                if ($conn->query($sql) === TRUE) {
                    $id_intercanvi = $conn->insert_id;
                    $cons->error = false;
                    $cons->msg = "New resposta inserted successfully";
                    console_log($cons);
                } else {
                    $error_sql = true;
                    $cons->error = true;
                    $cons->msg = "Error: " . $sql . "<br>" . $conn->error;
                    console_log($cons);
                }

                $sql = "INSERT INTO `respostes`(`id_questio`, `id_alumne`, `valor`) VALUES (5," . $id_alumne . "," . $telefon . ")";
                if ($conn->query($sql) === TRUE) {
                    $id_intercanvi = $conn->insert_id;
                    $cons->error = false;
                    $cons->msg = "New resposta inserted successfully";
                    console_log($cons);
                } else {
                    $error_sql = true;
                    $cons->error = true;
                    $cons->msg = "Error: " . $sql . "<br>" . $conn->error;
                    console_log($cons);
                }

                $sql = "INSERT INTO `respostes`(`id_questio`, `id_alumne`, `valor`) VALUES (6," . $id_alumne . "," . $grup . ")";
                if ($conn->query($sql) === TRUE) {
                    $id_intercanvi = $conn->insert_id;
                    $cons->error = false;
                    $cons->msg = "New resposta inserted successfully";
                    console_log($cons);
                } else {
                    $error_sql = true;
                    $cons->error = true;
                    $cons->msg = "Error: " . $sql . "<br>" . $conn->error;
                    console_log($cons);
                }
                $sql = "SELECT COUNT(DISTINCT id) as `total` FROM `questions`";
                $questions = mysqli_query($conn, $sql);
                $contador = mysqli_fetch_assoc($questions);
                for($j = 7; $j <= $contador['total']; $j++){
                    
                    if ($j == 10 || $j == 11 || $j == 11 || $j == 14 || $j == 16 ||$j == 17) {
                        
                    }else{
                        
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















        //DB PARAMETERS
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "tac-1";
        $conn = new mysqli($servername, $username, $password, $dbname);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error($conn));
        }





        $sql = "SELECT COUNT(DISTINCT id) as `total` FROM `questions`";
        $questions = mysqli_query($conn, $sql);
        $contador = mysqli_fetch_assoc($questions);
        if ($contador['total'] != null) {

            $dades_alumne = mysqli_fetch_assoc(mysqli_query($conn, "SELECT `id_intercanvi`, `nom`, `cognoms`, `correu`, `data_naixement`, `ciutat`, `telefon`, `grup` FROM `alumnes` WHERE id =" . $id_alumne . ";"));
            echo "Formulari per alumnes";
            echo "<form method='POST'  onsubmit='' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' name='formIntercanvi''>";

            for ($i = 0; $i <= $contador['total']; $i++) {

                $enunciat_n = mysqli_fetch_assoc(mysqli_query($conn, "SELECT `enunciat` as `total` FROM `questions` WHERE id =" . $i . ";"));
                echo "<br>" . $enunciat_n['total'] . "<br>";

                $codi_n = mysqli_fetch_assoc(mysqli_query($conn, "SELECT `codi` as `total`FROM `questions` WHERE id =" . $i . ";"));

                if ($i >= 1 && $i <= 6) {
                    switch ($i) {
                        case 1:
                            echo "<input type='text' id='questio_" . $i . "' name='questio_" . $i . "' value='" . $dades_alumne['nom'] . "'><br>";
                            break;
                        case 2:
                            echo "<input type='text' id='questio_" . $i . "' name='questio_" . $i . "' value='" . $dades_alumne['cognoms'] . "'><br>";
                            break;
                        case 3:
                            echo "<input type='date' id='questio_" . $i . "' name='questio_" . $i . "' value='" . $dades_alumne['data_naixement'] . "'><br>";
                            break;
                        case 4:
                            echo "<input type='text' id='questio_" . $i . "' name='questio_" . $i . "' value='" . $dades_alumne['ciutat'] . "'><br>";
                            break;
                        case 5:
                            echo "<input type='text' id='questio_" . $i . "' name='questio_" . $i . "' value='" . $dades_alumne['telefon'] . "'><br>";
                            break;
                        case 6:
                            echo "<input type='text' id='questio_" . $i . "' name='questio_" . $i . "' value='" . $dades_alumne['grup'] . "'><br>";
                            break;
                    }
                } else {
                    switch ($codi_n['total']) {
                        case 'text':
                            echo "<input type='text' id='questio_" . $i . "' name='questio_" . $i . "'><br>";

                            break;
                        case 'select':
                            echo "<select id='questio_" . $i . "' name='questio_" . $i . "'>";

                            $opcions = mysqli_query($conn, "SELECT `opcio`, `valor` FROM `opcions` WHERE id_questio=" . $i . ";");
                            while ($row = mysqli_fetch_array($opcions)) {
                                echo "<option value='" . $row['valor'] . "'>" . $row['opcio'] . "</option>";
                            }
                            echo "</select><br>";
                            break;
                        case 'checkbox':
                            $opcions = mysqli_query($conn, "SELECT `opcio`, `valor` FROM `opcions` WHERE id_questio=" . $i . ";");
                            while ($row = mysqli_fetch_array($opcions)) {
                                if ($row['opcio'] == "Specify wich / Especificar quin") {
                                    echo $row['opcio'] . ": <input id='questio_" . $i . "_" . $row['valor'] . "' name='questio_" . $i . "[]' type='text' ><br>";
                                } else {
                                    echo "<input type='checkbox' id='questio_" . $i . "_" . $row['valor'] . "' name='questio_" . $i . "[]' value='questio_" . $i . "_" . $row['valor'] . "'>" . $row['opcio'] . "<br>";
                                }
                            }
                            break;
                        case 'date':
                            echo "<input type='date' id='questio_" . $i . "' name='questio_" . $i . "'><br>";
                            break;
                        default:
                    }
                }
            }
            echo "</form>";
        }




        mysqli_close($conn);
        ?>
    </body>
</html>

