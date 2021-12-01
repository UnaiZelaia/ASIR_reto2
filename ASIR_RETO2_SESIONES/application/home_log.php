<?php
    //Incluimos la clase usuario para poder usarla.
    include('model/Usuario.class.php');

    //Iniciamos la sesion y comprobamos si la variable logeado está establecida. Si lo está, la página se carga. sino, se redirige al usuario a una página de error.
    session_start();
    if(isset($_SESSION["logeado"])){    //Método isset de PHP para comprobar si la variable logeado está establecida.
?>
<html>
    <head>
        <link rel="stylesheet" href="css/home.css">
        <link rel="stylesheet" href="../application/css/tablaUsuarios.css">
        <title>HOME</title>
</head>
    <body>
        <!-- Barra de navegación superior para moverse a través de la aplicación web. -->
    <div class="topnav">
        <a class="active" href="home_log.php">Home</a>
        <a href="../application/listaUsuarios.php">Administrar Usuarios</a>
        <a href="../application/resumenFaltas.php">Resumen de faltas</a>
        <a href="#about">Opciones</a>
        <a class="active" href="terminarSesion.php">Cerrar sesión</a>
    </div>
        
        
        <?php
            //Está pagina es muy simple. Simplemente recupera el nombre de usuario desde la variable de sesion usuario y la pinta por pantalla.
            $nombre = $_SESSION["usuario"] -> getNombre();
            print("<h1>Bienvenido, $nombre</h1>");

            print ("<a href='ejecutarHuella.php'>Asociar huella</a>");
        }else{
            header("Location: errorSesion.php");    //Si la verificación de sesión falla, el usuario es redirigido a una página de error.
        }
        ?>

    </body>
</html>
