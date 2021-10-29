<html>
<head>
  <link rel="stylesheet" href="css/Regiscss.css">
  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/home.css">
  <link rel="stylesheet" href="../application/css/tablaUsuarios.css">
  <title>Modificar usuario</title>
</head>
<?php
    session_start();
    if(isset($_SESSION["logeado"])){
?>
<body>
    <div class="topnav">
        <a class="active" href="home_log.php">Home</a>
        <a href="../application/listaUsuarios.php">Administrar Usuarios</a>
        <a href="#contact">Calendario</a>
        <a href="#about">Opciones</a>
        <a class="active" href="terminarSesion.php">Cerrar sesión</a>
    </div>
    <div class="main">
    <p class="sign" align="center">Modificar <br> contraseña</p>
    <form class="form1" method="POST" action="modContra.php?id=<?php echo $_GET["id"]; ?>">
        <input name="contra" class="usuario" type="password" align="center" placeholder="Introduzca su contraseña"/>
        <input name="nuevaContra1" class="pass" type="password" align="center" placeholder="Nueva contraseña"/>
        <input name="nuevaContra2" class="pass" type="password" align="center" placeholder="Confirmar nueva contraseña"/>
        <input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>"/>
        <input class="submit" align="center" type="submit" value="Modificar">    
    </form>
    </div>
    <?php
        include("model/Usuario.class.php");
        include("persistance/MySQLPDO.class.php");


        if($_POST){
            $postId = $_POST["id"];
            MySQLPDO::connect();
            $usuario = MySQLPDO::constUsu($postId);
            $contra = $_POST["contra"];
            $nuevaContra1 = $_POST["nuevaContra1"];
            $nuevaContra2 = $_POST["nuevaContra2"];
            if(password_verify($contra, $usuario->getHashContra())){
                if($nuevaContra1 == $nuevaContra2){
                $hashContra = password_hash($nuevaContra1, PASSWORD_DEFAULT);
                $usuario->setHashContra($hashContra);
                $resultado = MySQLPDO::updateContra($usuario);
                    if($resultado != 0){
                        function alert($msg) {
                            echo "<script type='text/javascript'>alert('$msg');</script>";
                        }
                        alert("Contraseña cambiada con exito");
                    }
                }
            }
        }
    }else{
        header("Location: errorSesion.php");
    }
    ?>