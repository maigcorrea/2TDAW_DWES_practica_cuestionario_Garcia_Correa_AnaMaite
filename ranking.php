<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./estilos/style_ranking.css">
</head>
<body>
    <h1>RANKING</h1>

    <?php
        require_once "clases.php";

        try{
            $db=new mysqli('localhost','root','','kahoot');
            $db->set_charset("utf8");
        }catch(Exception $e){
            header("Location:formulario.php?mensaje=0");
        }


        $usuario=new usuarios($db);
        $lista_ranking=$usuario->obtener_ranking();

        asort($lista_ranking);//Ordenar ranking de menor a mayor tiempo           
    ?>

    <!-- Crear tabla con los datos -->
     <div class="ranking-container">
        <div class="table-container">
            <table>
                <tr><th>Usuario</th><th>Tiempo</th></tr>       
                    <?php
                        foreach ($lista_ranking as $key => $value) {
                            echo "<tr><td>$key</td><td>$value s</td></tr>";
                        }
                    ?>
            </table>
        </div>
     </div>
        
</body>
</html>