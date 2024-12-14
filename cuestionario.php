<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
   <link rel="stylesheet" href="./style.css">
</head>
<body>
    <?php
        require_once "clases.php";

        try{
            $db=new mysqli('localhost','root','','kahoot');
            $db->set_charset("utf8");
        }catch(Exception $e){
            header("Location:formulario.php?mensaje=0");
        }
        

        $cont=0;
        
        //USUARIOS
        if(isset($_POST["env"])){
            
            if($_POST["nom"]!=""){
                //Se inserta el usuario
                $nombre=$_POST["nom"];

                $user=new usuarios($db,$_POST["nom"]);
                $user->insertarUsuarioTiempo();

                $preg=new preguntas($db);           
                $preg->get_pregunta($nombre);
            }else{
                header("Location:cuestionario.php?mensaje=4");
            }
            
            // $time=date("Y-m-d H:i:s");
            // $user->insertarTFinal($time);

            //Salen las preguntas
        }else if(!isset($_POST['env1'])){
            echo '
            <div id="registro-container">
                <div class="form-registro">
                    <form class="registro" action="#" method="post" enctype="multipart/form-data">
                        <label>Bienvenid@!</label><br>
                        <label for="nom">Introduce tu nombre</label><br>
                        <input type="text" name="nom" id=""><br>';
                        if(isset($_GET["mensaje"])){
                            if($_GET["mensaje"]==2){
                                echo "<p class='errYaRegistrado'>Error. El usuario ya está presente en la Base de Datos</p>";
                            }
                            if($_GET["mensaje"]==4) echo "<p class='inputVacio'>El campo está vacío</p>";
                        }
                        echo '
                        <input type="submit" value="Enviar" name="env">
                    </form>
                </div>
            </div>
            
            ';
        }

        if(isset($_POST['env1'])){
                $preg = new preguntas($db, $_POST['codPA'], $_POST['pMostradas']);
                
                $nombre = $_POST["nom"]; // Recupera el nombre del formulario
                $user=new usuarios($db,$nombre);//Generar usuario con el mismo nombre que el usuario que se generó en el registro

                $time=date("Y-m-d H:i:s");
                $user->insertarTFinal($time);//Utilizar el usuario creado para ir actualizando el tiempo en el que finaliza cada pregunta, de forma que en la última pregunta obtengo el tiempo total que ha tardado
                if($preg->comprobarRespuesta($_POST['res'])){
                        $preg->llegar_tope();
                        $preg->get_pregunta($nombre);
                        
                }else{
                    $preg->repetir_pregunta($_POST['codPA']);
                }
            
                
        }


    // }while($cont<5);

        // if(isset($_POST["env".$preg->get_cod()])){
        //     if($preg->comprobarRespuesta($_POST['res'],$_POST['codPreguntaActual'])){
        //         //Pasar a la siguiente pregunta
        //     }else{
        //         //Repetir pregunta
        //     }
        // }

        // if(isset($_POST["env1"]) && !isset($_POST["env"])){
        //     $preg1=new preguntas($db);
        //     $preg1->get_pregunta();
        // }else if(isset($_POST["env"])){
        //     $preg=new preguntas($db);
        //     $preg->get_pregunta();
        // }


        if(isset($_GET["mensaje"])){
            if($_GET["mensaje"]==0) echo "<p class='errBd'>Error de conexión con la Base de Datos</p>";
            // if($_GET["mensaje"]==1) echo "<p class='msjExitoUsuario'>Usuario registrado correctamente</p>";
            
        }
    ?>
</body>
</html>