<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AGCHTEST</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php
        if(isset($_POST["enviar"])){
            require_once("inc/conexion.php");
            require_once "clases.php";

            $usuario = $_POST["username"];
            if($usuario==""||$usuario==null){
                header("Location:index.php?errIni=1");
            }
            $usu = new usuario($conexion, $usuario);
            $error = $usu->insertarUsuario();
            echo "Resultado: " . ($error ? "Éxito" : "Error");
            if ($error) {
                header("Location:preguntas.php?user=".$usuario."&numPreg=1");
            } else {
                header("Location:index.php?errIni=1");
            }
        }else{
    ?>
    <main>
        <section id="kahoot">
        <?php
        if(isset($_GET["errIni"])){
            if($_GET["errIni"] == 1){
                ?>
                <div class="frame">
                    <div class="modal">
                    <img src="https://100dayscss.com/codepen/alert.png" width="44" height="38" />
                        <span class="title">ERROR!</span>
                        <p>Este nombre de usuario ya está en uso.</p>
                        <div class="button">Cerrar</div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
        <h1 class="logoText roboto-bold">AGCH TEST!</h1> 
        <div>
            <form action="index.php" method="post" enctype="multipart/form-data">
                <input type="text" name="username" id="username" placeholder="Nombre de usuario...">
                <input type="submit" name="enviar" id="enviar" value="enviar">
            </form>
        </div>
        <p class="footer">Mira el <a href="">ranking</a> directamente pinchando en este enlace <a href="">RANKING</a></p>
        </section>
    </main>
    <?php
        }
    ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/app.js"></script>
</body>
</html>