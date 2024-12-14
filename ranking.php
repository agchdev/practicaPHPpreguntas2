<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

    if(isset($_GET["user"]))$user = trim($_GET["user"]);;
    echo "Usuario: $user";
    echo "<br>Base de datos activa: " . $conexion->query("SELECT DATABASE()")->fetch_row()[0];

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
    // Preparar la consulta
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $tmpFinal); // Asignar parámetros
    if (!$stmt) {
        throw new Exception("Error al preparar la consulta de actualización: " . $conexion->error); //Vivo con miedo en toda esta parte la verdad
    }
    // $stmt->bind_param("ss", $tmpFinal, $user); // "s" para string (fecha) y "i" para entero (id)
    // Ejecutar la consulta
    if ($stmt->execute()) {
        $conexion->commit(); // Esto tambien lo sugería stackoverflow y no creo que haga falta, pero a estas alturas ya nada importa, solo quiero ser feliz y empezar las vacaciones de navidad
        if ($stmt->affected_rows == 0) echo "<p>No se actualizó ningún registro. Verifica si el usuario existe.</p>"; // Como me curro los mensajes por no volverme loco
    } else {
        echo "Error al guardar el tiempo final: " . $stmt->error; // Ahí mas posibles fallos que aciertos :(
    }
    // Cerrar la conexión
    $stmt->close(); // Cerrar el statement de actualización

    ?>
</body>
</html>