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
            echo "<p>JIJIJA</p>";
            if(isset($_POST["respuesta0"])){
                $res[] = $_POST["respuesta0"];
                echo "<p>".$res[0]."</p>";
            }
            if(isset($_POST["respuesta1"])){
                $res[] = $_POST["respuesta1"];
                echo "<p>".$res[1]."</p>";
            }
            if(isset($_POST["respuesta2"])){
                $res[] = $_POST["respuesta2"];
                echo "<p>".$res[2]."</p>";
            }
            if(isset($_POST["solucion"]))$solPreg = $_POST["solucion"];
            if($pregunta->corregirRespuesta($solPreg, $res)){
                echo "<p>GG</p>";
                $pregunta->eliminarPreg($usu);
                $pregunta->muestraPregunta($usu);
            }else{
                $pregunta->muestraPregunta($usu);
            }
        }else{  
            $pregunta->muestraPregunta($usu);
            echo "holllaaa";
        }
    ?>
</body>
</html>