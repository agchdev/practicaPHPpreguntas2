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

    public function muestraPregunta($user, $numPreg){
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
            explode(",",$strPreguntas);
            $cod = $strPreguntas[$numPreg];
            $cod = trim($cod);
            $cod = (int)$cod;
            $this->codPregunta = $cod;
        }
        echo "<p>$this->codPregunta</p>";
        echo "<h1>".gettype($this->codPregunta)."</h1>";
        $sentenciaUsu->close();

        // PREPARO LA PREGUNTA ALMACENANDO LA RESPUESTA
        $consulta = "SELECT textPregunta,respuestaPregunta,numRespuestas FROM preguntas WHERE idPregunta=".$this->codPregunta."";
        $sentencia = $this->bd->prepare($consulta);
        $this->bd->set_charset("utf8"); // Para que muestre tildes
        $sentencia->bind_result($this->textPregunta, $this->respuestaPregunta,$this->numRespuestas); // Donde voy a guardar el resultado
        $sentencia->execute(); // Ejecuto la consulta
        if(!$sentencia){
            throw new Exception("Error al preparar la consulta: ".$this->bd->error);
        }
        while($sentencia->fetch()){
            echo "<form action=\"preguntas.php?usu=".$user."&numPreg=".$this->codPregunta."\" method=\"post\" enctype=\"multipart/form-data\">"; // Me paso el codigo de la pregunta de esta manera para poder ir eliminandola del string
            echo $this->textPregunta;
            echo $this->respuestaPregunta;
            echo $this->numRespuestas;
        }
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
    
}

?>