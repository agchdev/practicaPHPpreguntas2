<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AGCHTEST-PREGUNTAS</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body id="kahoot">
    <?php
        require("inc/conexion.php");
        require("clases.php");

        if(isset($_GET["user"]))$usu = $_GET["user"];
        // if(isset($_GET["numPreg"]))$numPreg = $_GET["numPreg"];
        $pregunta = new pregunta($conexion);
        if (isset($_POST["enviar"])) {
            $res = [];
            $solPreg = "";
            if(isset($_POST["respuesta0"])){
                $res[] = $_POST["respuesta0"];
            }
            if(isset($_POST["respuesta1"])){
                $res[] = $_POST["respuesta1"];
            }
            if(isset($_POST["respuesta2"])){
                $res[] = $_POST["respuesta2"];
            }
            echo "<p>".count($res)."</p>";
            if(isset($_POST["solucion"]))$solPreg = $_POST["solucion"];
            if($pregunta->corregirRespuesta($solPreg, $res)){
                $pregunta->eliminarPreg($usu);
                $pregunta->muestraPregunta($usu);
            }else{
                $pregunta->muestraPregunta($usu);
            }
        }else{  
            $pregunta->muestraPregunta($usu);
        }
    ?>
</body>
</html>