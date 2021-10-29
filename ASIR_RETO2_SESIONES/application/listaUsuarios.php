<?php
    include('persistance/MySQLPDO.class.php');
    include('model/Usuario.class.php');  
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
        
    <div class="topnav">
        <a class="active" href="home_log.php">Home</a>
        <a href="../application/listaUsuarios.php">Administrar Usuarios</a>
        <a href="#contact">Calendario</a>
        <a href="#about">Opciones</a>
        <a class="active" href="terminarSesion.php">Cerrar sesión</a>
        </div>

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
            </tr>
            </thead>
                <?php
                    $resultado = MySQLPDO::listaUsu();

                    if(sizeof($resultado) != 0){
                        foreach($resultado as $registro){
                            extract($registro);
                            $id64 = base64_encode($id);
                            ?>
                            <tr>
                            <td><a href="modUsuario.php?id=<?php echo $id64 ?>"><?php echo $id ?></a></td>
                            <td><?php echo $nombre ?></td>
                            <td><?php echo $apellido ?></td>
                            <td><?php echo $nombreLogin ?></td>
                            <td><?php echo $email ?></td>
                            <td><?php echo $fechaNacimiento ?></td>
                            <td><form method="post" action="listaUsuarios.php">
                                <input type="hidden" name="id" value="<?php echo $id?>"/>
                                <input type="submit" value="Borrar"/>
                            </form></td>
                            </tr>
                            <?php
                        }
                    
                    }else{
                        print("No se han encontrado resultados");
                }
                ?>
        </table>
        </div>
    </body>
</html>


<?php 
if($_POST){
    $idBorrar = $_POST["id"];
    $sql = "DELETE FROM usuario WHERE id=?";
    $params = array($idBorrar);
    MySQLPDO::exec($sql, $params);
}
    }else{
        header("Location: errorSesion.php");
    }
?>