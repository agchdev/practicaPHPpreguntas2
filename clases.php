<?php

require_once("inc/conexion.php");

class pregunta{
    // Atributos de la pregunta
    private $bd;
    private $codPregunta;
    private $textPregunta;
    private $respuestaPregunta;
    private $numRespuestas;

    //Constructor de la clase de pregunta
    public function __construct ($db){
        $this->bd=$db; // La conexion
    }

    public function muestraPregunta($user){
        $strPreguntas = "";
        $consultUsu = "SELECT arrayPreg FROM usuarios WHERE usuario = '".$user."'"; // La consulta para extraer el array de preguntas del usuario
        $sentenciaUsu = $this->bd->prepare($consultUsu); // preparo la consulta
        $this->bd->set_charset("utf8"); // Para que muestre tildes
        $sentenciaUsu->bind_result($strPreguntas); // Donde voy a guardar el resultado
        $sentenciaUsu->execute(); // Ejecuto la consulta
        if(!$sentenciaUsu){
            throw new Exception("Error al preparar la consulta: ".$this->bd->error);
        }
        while($sentenciaUsu->fetch()){
            if (strlen($strPreguntas)>0) {
                $strPreguntas = explode(",",$strPreguntas);
                array_shift($strPreguntas);
                $cod = $strPreguntas[0]; // Quitar la primera pregunta
                $cod = trim($strPreguntas[0]); // Obtener el siguiente código
                $this->codPregunta = (int)$cod; // Convertirlo a entero
            }else{
                header("Location:ranking.php?user=\"$user\"");
            }
            
        }
        $sentenciaUsu->close(); // Cerrar el statement de la consulta de usuario

        // PREPARO LA PREGUNTA ALMACENANDO LA RESPUESTA
        $consulta = "SELECT textPregunta,respuestaPregunta,numRespuestas FROM preguntas WHERE idPregunta=".$this->codPregunta."";
        $sentencia = $this->bd->prepare($consulta);
        $this->bd->set_charset("utf8"); // Para que muestre tildes
        $sentencia->bind_result($this->textPregunta, $this->respuestaPregunta,$this->numRespuestas); // Donde voy a guardar el resultado
        $sentencia->execute(); // Ejecuto la consulta
        if(!$sentencia){ //Comprobando consulta
            throw new Exception("Error al preparar la consulta: ".$this->bd->error);
        }
        while($sentencia->fetch()){
            echo "<h2 class=\"pregunta\">".$this->textPregunta."</h2>";
            // Linea 54 eres la responsable en un futuro de uno de los mayores dolores de cabeza de la historia :)
            echo "<form action=\"preguntas.php?user=".$user."\" method=\"POST\" enctype=\"multipart/form-data\">"; // Me paso el codigo de la pregunta de esta manera para poder ir eliminandola del string
            $this->numRespuestas = (int)$this->numRespuestas;
            for ($i=0; $i < $this->numRespuestas; $i++) { 
                echo "<input type=\"text\" name=\"respuesta".$i."\" id=\"inputext\" placeholder=\"Introdude la respuesta\" required>";
                echo "<input type=\"hidden\" name=\"solucion\" value=\"$this->respuestaPregunta\">";
            }
            echo "<input type=\"submit\" id=\"enter\" name=\"enviar\" value=\"enviar\">";
            echo "</form>";
        }
    }

    public function corregirRespuesta($solucion, $res){
        $cont=0;
        $acierto = false;
        if (count($res)>1) {
            $solucion = explode(",",$solucion);
            for ($i=0; $i < count($res); $i++) { 
                if ($solucion[$i] == $res[$i]) {
                    $cont++;
                }
            }
        }else{
            if($solucion == $res[0]) $cont++;
        }
        
        if(count($res) == $cont){ 
            return $acierto = true;
        }
    }

    public function eliminarPreg($user){
        $strPreguntas = "";
        $consultUsu = "SELECT arrayPreg FROM usuarios WHERE usuario = '".$user."'"; // La consulta para extraer el array de preguntas del usuario
        $sentenciaUsu = $this->bd->prepare($consultUsu); // preparo la consulta
        $this->bd->set_charset("utf8"); // Para que muestre tildes
        $sentenciaUsu->bind_result($strPreguntas); // Donde voy a guardar el resultado
        $sentenciaUsu->execute(); // Ejecuto la consulta
        if(!$sentenciaUsu){
            throw new Exception("Error al preparar la consulta: ".$this->bd->error);
        }
        while($sentenciaUsu->fetch()){
            $arrayPreguntas = explode(",",$strPreguntas);
            array_shift($arrayPreguntas);
            array_shift($arrayPreguntas);
            $strPreguntas = "";
            foreach ($arrayPreguntas as $pregunta) {
                $strPreguntas .= ",".$pregunta;
            }
        }
        $sentenciaUsu->close();

        $elimConsulta = "UPDATE usuarios SET arrayPreg = '".$strPreguntas."' WHERE usuario = '".$user."'";
        $elimSentencia = $this->bd->prepare($elimConsulta);
        $this->bd->set_charset("utf8");
        $elimSentencia->execute(); // Ejecuto la consulta
    }
}

class usuario{

    //Atributos de la clase usuario
    private $bd; // Para conectarse con la base de datos
    private $username; // Nombre de usuario
    private $tmp_inicio; // Tiempo inicial
    private $tmp_final; // Tiempo final
    private $tmp_total; // Tiempo total
    private $preguntas; // Preguntas

    public function __construct($db, String $u=""){
        $this->bd=$db; // La conexion
        $this->username=$u; // El nombre de usuario
        $this->preguntas=$this->generarCodPreguntas();
    }

    //Esta funcion se encarga de generar las preguntas aleatorias que tendrá que hacer ese usuario
    public function generarCodPreguntas(){
        $cont = 0; //Se encargará de controlar que solo haya 5 preguntas
        $codPreg = []; //Se encarga de controlar que no se repitan los números
        $str = ""; // Aqui almacenaré como texto los codigos de las preguntas

        // Saca 5 numeros de manera aleatoria
        while($cont < 5){
            $nrandom = rand(1, 10); // Selecciona un numero de manera aleatoria
            if(!in_array($nrandom, $codPreg)){ // Comprueba que no esté en el array 
                $str .= ",".$nrandom; // Lo añade al string
                $codPreg[] = $nrandom; // Lo añade al array para que no vuelva a salir
                $cont++; // Suma uno el contador
            }
        }
        return $str;
    }

    // Funcion para añadir usuarios a la base de datos
    public function insertarUsuario() {
        $error = true; // Inicializamos con true (éxito)
        try {
            $consulta = "INSERT INTO usuarios(usuario, arrayPreg) VALUES (?,?);"; // La consulta
            $stmt = $this->bd->prepare($consulta); // Preparamos la consulta
            if (!$stmt) {
                $error = false; // Error en la preparación de la consulta
            } else {
                $stmt->bind_param("ss", $this->username, $this->preguntas); // Vinculamos los parámetros
                if (!$stmt->execute()) {
                    $error = false; // Error en la ejecución de la consulta
                }
                $stmt->close(); // Cerramos el statement
            }
        } catch (Exception $e) {
            $error = false; // Error en la excepción
        }
        return $error;
    }

    public function ranking(){
        $consultUsu = "SELECT usuario, tmpTotal FROM usuarios WHERE tmpTotal IS NOT NULL ORDER BY tmpTotal ASC"; // La consulta para extraer los tiempos
        $sentenciaUsu = $this->bd->prepare($consultUsu); // preparo la consulta
        $this->bd->set_charset("utf8"); // Para que muestre tildes
        $sentenciaUsu->bind_result($this->username, $this->tmp_total); // Donde voy a guardar el resultado
        $sentenciaUsu->execute(); // Ejecuto la consulta
        if(!$sentenciaUsu){
            throw new Exception("Error al preparar la consulta: ".$this->bd->error);
        }
        $cont=1;
        echo "<table class=\"container\">
                <tr>
                    <th>USUARIOS</th>
                    <th>TIEMPO</th>
                </tr>";
        while($sentenciaUsu->fetch()){
            echo "<tr>";
            echo "<td class=\"user\">".$cont."º ".$this->username."</td><td class=\"time\">".$this->tmp_total." Segundos </td>";
            echo "</tr>";
            $cont++;
        }
        echo "</table>";
        $sentenciaUsu->close();
    }

    public function addTmpTotal($user){
        $consulta = "SELECT tmpInicio, tmpFinal FROM usuarios WHERE usuario = ".$user."";
        $sentencia = $this->bd->prepare($consulta);
        $sentencia->execute(); // Ejecutar la consulta
        $sentencia->bind_result($this->tmp_inicio, $this->tmp_final); // Vincular los resultados
        $sentencia->fetch();
        $sentencia->close();

        // Convertir a objetos DateTime
        $datetimeInicio = new DateTime($this->tmp_inicio);
        $datetimeFinal = new DateTime($this->tmp_final);

        // Calcular la diferencia
        $diferencia = $datetimeFinal->diff($datetimeInicio);

        // Mostrar la diferencia
        // echo "Diferencia: " . $diferencia->format('%H horas, %I minutos, %S segundos') . "<br>";

        // Calcular la diferencia total en segundos
        $segundosTotales = strtotime($this->tmp_final) - strtotime($this->tmp_inicio);

        // Actualizar en la base de datos
        $updateConsulta = "UPDATE usuarios SET tmpTotal = ? WHERE usuario = ".$user."";
        $stmt = $this->bd->prepare($updateConsulta);
        $stmt->bind_param("i", $segundosTotales);
        $stmt->execute();

        if ($stmt->affected_rows < 0) {
            echo "No se actualizó ningún registro.";
        }
        $stmt->close();
    }
}
?>