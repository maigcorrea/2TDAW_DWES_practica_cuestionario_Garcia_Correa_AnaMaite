 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./estilos/style.css">
</head>
<body>
    <?php

        class preguntas{
            private $bd;
            private $cod;
            private $enunciado;
            private $respuesta;
            private $preguntas_mostradas="";//Donde se van a almacenar las preguntas que ya se han mostrado, para que no se repitan
            private $nom;

            public function __construct($db,$cod="", $pm="", $enun="", $res="",$n=""){
                $this->bd=$db;
                $this->cod=$cod;
                $this->enunciado=$enun;
                $this->respuesta=$res;
                $this->preguntas_mostradas = $pm;
                $this->nom=$n;
            }


            public function get_cod(){
                return $this->cod;
            }


            //Función para obtener las preguntas
            public function get_pregunta($n){ //Le paso el nombre del usuario para asignarlo como una propiedad más del objeto, y así poder pasarselo luego al método toString
                //Generar un número random
                $sent="SELECT MAX(cod) from preguntas;";//Consultar cuantas preguntas hay en la bd para saber el límite máximo del num random
                $cons=$this->bd->prepare($sent);
                $cons->execute();
                $cons->bind_result($codMax);
                $cons->fetch();
                $cons->close();

                
                $this->nom=$n;
                if($codMax<1){//Comprobar que haya preguntas en la bd
                    echo "No hay preguntas en la base de datos";
                }else{
                    $array = explode(",", $this->preguntas_mostradas);
                    
                    //El número se sigue generando hasta que no esté incluido dentro del array de las preguntas que ya se han mostrado
                    do{
                        $codRandom=random_int(1,$codMax);//Generar el número random
                    }while(in_array($codRandom,$array));//Se comprueba si el número generado está dentro del array con las preguntas mostradas, si devuelve true es que ya existe y por lo tanto se tiene qie generar otro número
                    
                    $this->preguntas_mostradas .= ",".$codRandom;


                    //Generar la consulta del enunciado a partir del num random
                    $sent="SELECT cod,enunciado FROM preguntas WHERE cod=?;";//El código es dinámico

                    $cons=$this->bd->prepare($sent);
                    $cons->bind_param("i",$codRandom);
                    $cons->execute();
                    $cons->bind_result($this->cod, $this->enunciado);

                    $cons->fetch();

                    $cons->close(); 
                    // Retornar el objeto con echo para mostrarlo con __toString()
                    echo $this;
                }
  
            }


            //Función para repetir la pregunta si el usuario falla
            function repetir_pregunta($cod){
                $sent="SELECT enunciado FROM preguntas WHERE cod=?;";//El código es dinámico

                $cons=$this->bd->prepare($sent);
                $cons->bind_param("i",$cod);
                $cons->execute();
                $cons->bind_result($this->enunciado);

                $cons->fetch();
                

                $cons->close(); 
                // Retornar el objeto con echo para mostrarlo con __toString()
                echo $this;
            }



            //Función para redirigir al ranking cuando se hayan contestado 5 preguntas
            function llegar_tope(){
                $array = explode(",", $this->preguntas_mostradas);
                if(count($array)==6){
                    echo "Fin. Se redirige a la página de ranking";
                    header("Location:ranking.php");
                }
            }


            //Función para comprobar la respuesta del usuario
            public function comprobarRespuesta($resUsuario){
                $sent = "SELECT respuesta FROM preguntas WHERE cod = ?;";
                $comprobar;
                try{
                    $cons=$this->bd->prepare($sent);
                    $cons->bind_param("i",$this->cod);
                    $cons->execute();
                    $cons->bind_result($resBd);
                    $cons->fetch();

                    $array = explode(",", $this->preguntas_mostradas);
                    
                    if(strtolower(trim($resBd))==strtolower(trim($resUsuario))){
                        echo "<p class='msj'>Correcto, se pasa a la siguiente pregunta</p>";
                        $comprobar=true;

                    }else{
                        echo "<p class='msj'>Ooops! Has fallado</p>";
                        $comprobar=false;
                    }

                    return $comprobar;
                }catch(Exception $e){
                    echo "Error al comprobar las respuestas";
                }
                
            }


            //Función para mostrar las preguntas
            public function __toString(){//El campo oculto del nombre es para luego en cuestionario.php, en cada pregunta poder generarme un nuevo usuario cuyo nombre sea igual al introducido en el registro, e ir actualizando el tiempo de finalización
                $str = '
                        <div id="registro-container">
                            <div class="form-registro">
                                <form class="registro" action="#" method="post" enctype="multipart/form-data">
                                    <p>'. $this->enunciado.'</p>
                                    <input type="hidden" name="codPA" value="'.$this->cod . '">
                                    <input type="hidden" name="nom" value="'.$this->nom.'">
                                    <input type="hidden" name="pMostradas" value="' . $this->preguntas_mostradas . '">
                                    <input type="text" name="res"><br>
                                    <input type="submit" value="Enviar" name="env1">
                                </form>
                            </div>
                        </div>
                        ';
                return $str;
            }
        }


        class usuarios{
            private $bd;
            private $nombre;
            private $tEmpieza;
            private $tFinal;

            public function __construct($db,$nom="", $tEmp="", $tFin=""){
                $this->bd=$db;
                $this->nombre=$nom;
                $this->tEmpieza=$tEmp;
                $this->tFinal=$tFin;
            }


            //Función para insertar usuario y tiempo de inicio, que se inserta automáticamente
            public function insertarUsuarioTiempo(){
                if($this->check_usuario($this->nombre)){
                    $sent="INSERT INTO usuarios(nombre) VALUES (?);";//No hay que pasarle dos parámetros ?,? haciendo referencia la nombre y al tiempo en el que empieza, porque el tiempo, al estar predeterminado en la bd como current_timesptamp(), va a manejarlo automáticamente MySQL, es decir, lo va a insertar automáticamente

                    $cons=$this->bd->prepare($sent);
                    $cons->bind_param("s",$this->nombre);
                    $cons->execute();


                    $cons->close();

                }else{
                    header("Location:cuestionario.php?mensaje=2");
                    exit();
                }
            }    


            //Función para insertar el tiempo final
            public function insertarTFinal($time){;
                $sent="UPDATE usuarios SET tFinal=? WHERE nombre=?;";
                $cons=$this->bd->prepare($sent);
                $cons->bind_param("ss",$time,$this->nombre);
                $cons->execute();


                $cons->close();
                
            }



            //Función para comprobar si el usuario existe en la base de datos
            public function check_usuario($inputNom){
                $sent="SELECT count(nombre) FROM usuarios WHERE nombre=?;"; //? indica que es un paraámetro dinámico, es decir, que será introducido más tarde y que puede ser un nombre diferente cada vez que se ejecute la consulta

                try{
                    $cons=$this->bd->prepare($sent);//Crea un objeto preparado basado en la consulta(sent)
                    $cons->bind_param("s",$inputNom);//Reemplaza ? en la consulta por el valor real del nombre, en este caso, el parámetro pasado al método($inputNom)
                    try{
                        $cons->execute();//Se ejecuta la consulta preparada
                    }catch(Exception $e){
                        echo "Error al ejecutar la consulta para comprobar si el usuario ya existe en la bd";
                    }

                    $cons->bind_result($cont);//Asocia el resultado de la ejecución de la consulta con la variable $cont, es decir, en esa variable se va almacenar el resultado (El resultado será una fila)

                    $cons->fetch(); //Como el o los resultados siempre se devuelven en una o varias filas, fetch recupera esa fila y la coloca en la variable vinculada, en este caso $cont. En el caso de devolver varias filas, habría que hacer un bucle while (mientras que saque resultados, estos se van almacenando)
                    
                    
                    //Lo que devuelva el método lo utilizaremos a su vez en otro método (Llamando a esta función) para saber si tenemos que insertar o no el usuario
                    //Si el nombre no existe en la bd, significa que se podrá insertar al usuario, y por eso devuelve true, si devuelve 1, significará que el usuario no existe y por tanto no se puede insertar
                    if($cont==0){
                        return true;
                    }else{
                        return false;
                    }
                
                }catch(Exception $e){
                    echo "Error al comprobar si el usuario ya existe en la bd";
                }finally{
                    if(isset($cons)){
                        $cons->close(); //Se cierra la consulta para liberar los recursos
                    }
                }              
            }


            //Función para mostrar el nombre de los usuarios
            public function __toString(){
                $str = " <br>".$this->nombre;
                return $str;
            }


            //Función para obtener los datos de la tabla del ranking
            public function obtener_ranking(){
                $sent="SELECT nombre,tEmpieza,tFinal from usuarios";

                $cons=$this->bd->prepare($sent);
                $cons->bind_result($this->nombre,$this->tEmpieza,$this->tFinal);
                $cons->execute();


                $datos=[];//Array donde almacenar el nombre del usuario y los segundos que ha tardado
                while($cons->fetch()){
                    //Pasar tiempo a segundos
                    $segInicio=strtotime($this->tEmpieza);
                    $segFinal=strtotime($this->tFinal);
                    $segTotales;

                    // Controlar por si alguna fecha está a null o no se ha establecido
                    if ($segInicio && $segFinal) {
                        $segTotales = $segFinal - $segInicio;
                    } else {
                        $segTotales = 0; // Valor por defecto si las fechas son inválidas
                    }

                    //Almacenar en array
                    $datos[$this->nombre]=$segTotales;
                }
                
                $cons->close();

                return $datos;
                
            }
        }


    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>