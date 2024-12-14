<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
    <?php
    require("inc/conexion.php");
    require("clases.php");

    $conexion->autocommit(TRUE); // Realmente esto no creo que haga ni falta, pero stackoverflow asi lo sugiere, asi que ahí se queda. Imagino que esto vendrá por defecto en true, pero me ha funcionado teniendo esto activado y no pienso cambiarlo

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    if(isset($_GET["user"])){
        $user = trim($_GET["user"]);

        // Verificar si el usuario existe (Esto de abajo es una pequeña muestra de desesperacion porque la parte abajo no funcionaba de ninguna manera)
        // $check_sql = "SELECT usuario FROM usuarios WHERE usuario = ".$user."";
        // $check_stmt = $conexion->prepare($check_sql);
        // $check_stmt->execute();
        // $check_stmt->store_result();
        // if ($check_stmt->num_rows === 0) {
        //     die("<p>El usuario '$user' no existe. No se puede actualizar tmpFinal.</p>");
        // }else{
        //     echo "<p>El usuario existe</p>";
        // }
        // $check_stmt->close();

        // Obtener el tiempo final (hora actual)
        $tmpFinal = date("Y-m-d H:i:s"); // Formato para MySQL
        // Query para actualizar el tiempo final
        $sql = "UPDATE usuarios SET tmpFinal = ? WHERE usuario = ".$user.""; //No me deja hacer bind_param de user sin que me explote el programa, he probado poniendo comillas simples, sin ponerlas y un sin fin de pruebas, nada ha dado resultado salvo esto
        //Acabo de descubrir que se me está almacenando con comillas el nombre de usuario JAJAJAJAJA
        // Tarde para cambiarlo, pero ya lo sé para un futuro, el problema está en la linea 54 de clases.php, ya no lo voy a cambiar
        // Pero está ahí, menuda rabieta he pegado JAJAJAJAJAJA
        // Preparar la consulta
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $tmpFinal); // Asignar parámetros
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta de actualización: " . $conexion->error); //Vivo con miedo en toda esta parte la verdad
        }
        // Ejecutar la consulta
        if ($stmt->execute()) {
            $conexion->commit(); // Esto tambien lo sugería stackoverflow y no creo que haga falta, pero a estas alturas ya nada importa, solo quiero ser feliz y empezar las vacaciones de navidad
            if ($stmt->affected_rows == 0) echo "<p>No se actualizó ningún registro. Verifica si el usuario existe.</p>"; // Como me curro los mensajes por no volverme loco
        } else {
            echo "Error al guardar el tiempo final: " . $stmt->error; // Ahí mas posibles fallos que aciertos :(
        }
        // Cerrar la conexión
        $stmt->close(); // Cerrar el statement de actualización

        // Vale hasta aquí todo correcto, ahora toca traerme el tiempo final y el inicial, hacer la resta y tirar para adelante va!!!!
        // Para esto si voy a usar la clase que para algo las tengo hjajajajaja
        // Estaba cansado de usar la clase y por rellenar la parte de ranking.php que al final este código no se va a usar nada mas que aquí una vez
        // para mi gusto es lo mismo de eficiente
        $usu = new usuario($conexion);
        $usu->addTmpTotal($user);
    }
    ?>
    <main id="kahoot">
        <h1 class="logoText">RANKING</h1>
        <?php
            $ranking = new usuario($conexion);
            $ranking->ranking();
        ?>
        <a class="footer enlace" href="./index.php">INICIAR SESION</a>
    </main>
</body>
</html>