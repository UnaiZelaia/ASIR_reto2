<?php
    include('model/Usuario.class.php');
    session_start();
    if(isset($_SESSION["logeado"])){
?>
<html>
    <head>
        <link rel="stylesheet" href="css/home.css">
        <link rel="stylesheet" href="../application/css/tablaUsuarios.css">
        <title>HOME</title>
</head>
    <body>

        <div class="topnav">
        <a class="active" href="home_log.php">Home</a>
        <a href="../application/listaUsuarios.php">Administrar Usuarios</a>
        <a href="#contact">Calendario</a>
        <a href="#about">Opciones</a>
        <a class="active" href="terminarSesion.php">Cerrar sesión</a>
        </div>
        <?php
            $nombre = $_SESSION["usuario"] -> getNombre();
            print("<h1>Bienvenido, $nombre</h1>");
        }else{
            header("Location: errorSesion.php");
        }
        ?>

    </body>
</html>