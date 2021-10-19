<?php
    include('model/Usuario.class.php');
    session_start();

?>
<html>
    <head>
        <link rel="stylesheet" href="css/home.css">
        <title>HOME</title>
</head>
    <body>

        <div class="topnav">
        <a class="active" href="#home">Home</a>
        <a href="../application/listaUsuarios.php">Administrar Usuarios</a>
        <a href="#contact">Calendario</a>
        <a href="#about">Opciones</a>
        <a class="active" href="login.php">Cerrar sesión</a>
        </div>
        <?php
            $nombre = $_SESSION["usuario"] -> getNombre();
            print("<h1>Bienvenido, $nombre</h1>");
        ?>

    </body>
</html>