 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php

        class preguntas{
            private $bd;
            private $cod;
            private $enunciado;
            private $respuesta;
            private $preguntas_mostradas="";//Donde se van a almacenar las preguntas que ya se han mostrado, para que no se repitan
            // $cont=0; //Contador
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

            public function get_pregunta($n){ //Le paso el nombre del usuario para asignarlo como una propiedad más del objeto, y así poder pasarselo luego al método toString
                //Generar un número random
                $sent="SELECT MAX(cod) from preguntas;";//Consultar cuantas preguntas hay en la bd para saber el límite máximo del num random
                $cons=$this->bd->prepare($sent);
                $cons->execute();
                $cons->bind_result($codMax);
                $cons->fetch();
                $cons->close();

                
                // echo $n;
                $this->nom=$n;
                if($codMax<1){//Comprobar que haya preguntas en la bd
                    echo "No hay preguntas en la base de datos";
                }else{
                    $array = explode(",", $this->preguntas_mostradas);
                    // echo count($array)."Primer Count";
                    //El número se sigue generando hasta que no esté incluido dentro del array de las preguntas que ya se han mostrado
                    do{
                        $codRandom=random_int(1,$codMax);//Generar el número random
                    }while(in_array($codRandom,$array));//Se comprueba si el número generado está dentro del array con las preguntas mostradas, si devuelve true es que ya existe y por lo tanto se tiene qie generar otro número
                    
                    $this->preguntas_mostradas .= ",".$codRandom;
                    // $cont+=1;


                    //Generar la consulta del enunciado a partir del num random
                    $sent="SELECT cod,enunciado FROM preguntas WHERE cod=?;";//El código es dinámico

                    $cons=$this->bd->prepare($sent);
                    $cons->bind_param("i",$codRandom);
                    $cons->execute();
                    $cons->bind_result($this->cod, $this->enunciado);

                    $cons->fetch();
                    // $this->preguntas_mostradas = $codRandom." ";//Añadir el código al array para comprobar que no se repita

                    $cons->close(); 
                    // Retornar el objeto con echo para mostrarlo con __toString()
                    echo $this;
                }
  
            }


            //Método para repetir la pregunta si el usuario falla
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



            function llegar_tope(){
                $array = explode(",", $this->preguntas_mostradas);
                // echo $this->preguntas_mostradas;
                // if($cont==5){
                //     echo "Fin";
                // }
                if(count($array)==6){
                    // foreach ($array as $value) {
                    //     echo $value."<br>";
                    // }
                    // $usuario = new usuarios($this->bd); // Pasar la base de datos 
                    // $nomUsu=$usuario->getNombre();

                    // $usuario = new usuarios($this->bd, $nomUsu); 
                    // $usuario->insertarTFinal(); // Registrar el tiempo final

                    echo "Fin. Se redirige a la página de ranking";
                    header("Location:ranking.php");
                }
            }


            // public function pasar_str_numero(){

            // }
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
                        // echo count($array);
                        // foreach ($array as  $value) {
                        //     echo $value."<br>";
                        // }
                    }else{
                        echo "<p class='msj'>Ooops! Has fallado</p>";
                        $comprobar=false;
                        // echo count($array);
                        // foreach ($array as  $value) {
                        //     echo $value."<br>";
                        // }
                    }

                    return $comprobar;
                }catch(Exception $e){
                    echo "Error al comprobar las respuestas";
                }
                
            }


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


            // public function __setFinal($fin){
            //     $this->tFinal=$nom;
            // }


            public function insertarUsuarioTiempo(){
                if($this->check_usuario($this->nombre)){
                    $sent="INSERT INTO usuarios(nombre) VALUES (?);";//No hay que pasarle dos parámetros ?,? haciendo referencia la nombre y al tiempo en el que empieza, porque el tiempo, al estar predeterminado en la bd como current_timesptamp(), va a manejarlo automáticamente MySQL, es decir, lo va a insertar automáticamente

                    $cons=$this->bd->prepare($sent);
                    // $t = time();
                    $cons->bind_param("s",$this->nombre);
                    $cons->execute();


                    $cons->close();

                    // header("Location:cuestionario.php?mensaje=1");
                    // exit(); //El exit() sirve para asegurarse de que el script se detenga y no siga ejecutandose
                }else{
                    header("Location:cuestionario.php?mensaje=2");
                    exit();
                }
                
            }

            public function getNombre() {
                return $this->nombre;
            }        


            public function insertarTFinal($time){
                // echo "Nombre del usuario: " . $this->nombre;
                // echo($time);
                $sent="UPDATE usuarios SET tFinal=? WHERE nombre=?;";
                $cons=$this->bd->prepare($sent);
                // $t = time();
                $cons->bind_param("ss",$time,$this->nombre);
                $cons->execute();


                $cons->close();
                
            }




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



            public function __toString(){
                $str = " <br>".$this->nombre;
                return $str;
            }




            // public function obtener_ranking(){
            //     $sent="SELECT nombre,tFinal from usuarios";


            // }
        }


    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>