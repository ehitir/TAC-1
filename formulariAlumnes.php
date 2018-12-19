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
    //DB PARAMETERS
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tac-1";
    $conn = new mysqli($servername, $username, $password, $dbname);

    $id_alumne = "";
    if (isset($_GET["id_alumne"])) {
        

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {

            $sql = "SELECT COUNT(1) as total FROM alumnes WHERE id=" . $_GET["id_alumne"];
            $result = $conn->query($sql);
            $data=mysqli_fetch_assoc($result);
            if ($data['total'] > 0) {
                $id_alumne = $_GET["id_alumne"];
            } else {
                $id_alumne = "";
            }
        }
    } else {
        $id_alumne = "";
    }
    ?>
    <body onload="showForm(<?php echo $id_alumne; ?>)">
        <div id="txtHint"><b>Person info will be listed here...</b></div>
    </body>
    <script>
        function showForm(id) {
            console.log("RES" + id);
            if (id == null || id == "") {
                document.getElementById("txtHint").innerHTML = "No es un usuari valid.";
                return;
            } else {
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("txtHint").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "getAlumnesForm.php?id_alumne=" + id, true);
                xmlhttp.send();
            }
        }
    </script>
</html>
