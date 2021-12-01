<?php
    //Includes para usar las clases usuario y MySQLPDO y susu métodos.
    include('persistance/MySQLPDO.class.php');
    include('model/Usuario.class.php');  

    //Iniciamos la sesión y comprobamos si la variable de sesión logeado está establecida.
    session_start();
    if(isset($_SESSION["logeado"])){
?>
<html>
    <head>
        <link rel="stylesheet" href="css/home.css">
        <link rel="stylesheet" href="../application/css/tablaUsuarios.css">
        <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
        <title>Lista</title>
    </head>
    <body>
        <!-- Barra de navegación superior -->
        <div class="topnav">
        <a class="active" href="home_log.php">Home</a>
        <a href="../application/listaUsuarios.php">Administrar Usuarios</a>
        <a href="../application/resumenFaltas.php">Resumen de faltas</a>
        <a href="#about">Opciones</a>
        <a class="active" href="terminarSesion.php">Cerrar sesión</a>
    </div>

        
        <!-- Div que contiene la lista de usuarios -->
        <div class="table-wrapper">
        <table border="1" class="fl-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Login</th>
                <th>Email</th>
                <th>Fecha de Nacimiento</th>
                <th>Borrar Usuario</th>
                <th>Faltas usuario</th>
            </tr>
            </thead>
                <?php
                    //Usamos el método listaUsu() para realizar una consulta con la base de datos que devuelva todos los usuarios que estén almacenados y
                    //lo gurdamos en una variable. Esta variable es un array bidimensional con todos los registros de los usuario guardados en arrays.
                    $resultado = MySQLPDO::listaUsu();

                    if(sizeof($resultado) != 0){                //Si la variable resultado NO está vacia (hay registros) se ejecuta el siguiente código.
                        foreach($resultado as $registro){       //foreach loop que se ejecuta las mismas veces que registros hay.
                            extract($registro);                 //Método extract() para generar variables desde una array de manera automática.
                            $id64 = base64_encode($idUsuario);         //Codificamos el id en base64 para ofuscarlo un poco.
                            ?>                                  
                         
                            <!-- Código que genera la lista de los usuarios. Se pinta un dato del usuario por cada casilla -->
                            <!-- Se abre un bloque php en cada <td> de la lista en la que hacemos echo al parametro deseado -->
                            <tr>                                        
                            <td><a href="modUsuario.php?id=<?php echo $id64 ?>"><?php echo $idUsuario ?></a></td> <!-- Genera un link con el id del usuario y manda el id a través de la url al clicar. Reenvia a una página de modificación de usuario que usa la ID mandada por URL para saber que usuario se está modificando -->
                            <td><?php echo $nombre ?></td>
                            <td><?php echo $apellido ?></td>
                            <td><?php echo $nombreLogin ?></td>
                            <td><?php echo $email ?></td>
                            <td><?php echo $fechaNacimiento ?></td>
                            <td><form method="post" action="listaUsuarios.php">            <!-- Boton para borrado del usuario. Última casilla de la lista -->
                                <input type="hidden" name="id" value="<?php echo $id?>"/>
                                <input type="submit" value="Borrar"/>
                            </form></td>
                            <td><a href="verFaltas.php?id=<?php echo $id64 ?>"><?php print($idUsuario); ?></a></td>
                            </tr>
                            <?php
                        }
                    
                    }else{
                        print("No se han encontrado resultados"); //Si no hay registros en la base de datos, se pinta por pantalla.
                }
                ?>
        </table>
        </div>
            <!-- Final del div que contiene la tabla -->
    </body>
</html>


<?php                                            //Código que maneja el borrado de los usuarios
if($_POST){
    $idBorrar = $_POST["id"];                   //Recibimos el parámetro ID mediante POST y lo usamos como parámetro de la consulta SQL para borrar el registro con ese ID.
    $sql = "DELETE FROM usuario WHERE idUsuario=?";
    $params = array($idBorrar);
    MySQLPDO::exec($sql, $params);              //Método exec() de MySQLPDO que realiza la consulta contra la BBDD
}
    }else{
        header("Location: errorSesion.php");    //Si la comprbación de sesión falla, se redirige al usuario a una página de error.
    }
?>
