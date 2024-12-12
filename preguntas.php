<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AGCHTEST-PREGUNTAS</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body id="bodyPreguntas">
    <?php
        require("inc/conexion.php");
        require("clases.php");

        if(isset($_GET["user"]))$usu = $_GET["user"];
        if(isset($_GET["numPreg"]))$numPreg = $_GET["numPreg"];
        $pregunta = new pregunta($conexion);
        $pregunta->muestraPregunta($usu, $numPreg);

        if (isset($_POST["enviar"])) {
            $_POST["respuesta1"]
        }else{  
    ?>
    <?php
        }
    ?>
</body>
</html>