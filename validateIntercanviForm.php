<?php
 // put your code here
        // https://www.w3schools.com/php/showphp.asp?filename=demo_form_validation_complete
        //Variables 
        
        $descripcio = "";
        $llistaALocal = "";
        $llistaAForanis = "";


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["name_intercanvi"])) {
                $nomError = "S'ha d'introduir un nom per l'intercanvi.";
                exit('Invalid Integer');
            } else {
                $nom_intercanvi = $_POST["name_intercanvi"];
                // Comprovem que tingui caracters valids.
                if (!preg_match("/^[a-zA-Z ]*$/", $nom_intercanvi)) {
                    $nomError = "Has introduit caracters no valids.";
                    exit('Invalid Integer');
                }
            }

            if (empty($_POST["curs_intercanvi"])) {
                $cursError = "S'ha d'introduir un curs.";
                exit('Invalid Integer');
            } else {
                $curs = $_POST["curs_intercanvi"];
                // Comprovem que tingui caracters valids.
                if (!preg_match("/^[0-9]{3,4}(-[0-9]{3,4})?$/", $curs)) {
                    $cursError = "Nomes es pot escriure numeros i guions.";
                    exit('Invalid Integer');
                }
            }
        }

?>
