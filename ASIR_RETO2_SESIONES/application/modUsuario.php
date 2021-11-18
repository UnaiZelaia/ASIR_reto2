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
<body>
<?php
include('persistance/MySQLPDO.class.php');
include('model/Usuario.class.php');
session_start();
if(isset($_SESSION["logeado"])){ //Comprobar si el usuario está logueado
MySQLPDO::connect();

if($_POST){
  $modId = $_POST["id"];
  $nombre = $_POST["nombre"];
  $nombreLogin = $_POST["usuario"];
  $apellido = $_POST["apellido"];
  $email = $_POST["email"];
  $fechaNacimiento = $_POST["date"];

  $modUsuario = new usuario();
  $modUsuario->setId($modId);
  $modUsuario->setNombre($nombre);
  $modUsuario->setApellido($apellido);
  $modUsuario->setNombreLogin($nombreLogin);
  $modUsuario->setEmail($email);
  $modUsuario->setFechaNacimiento($fechaNacimiento);

  MySQLPDO::connect();
  MySQLPDO::updateUsuario($modUsuario);
  header("Location: listaUsuarios.php");

}else if(!isset($_GET["id"])){

  print($_GET["id64"]);
  die("ERROR: No se ha recibido ID de usuario");

}else{  $id64 = $_GET["id"];

  $id = base64_decode($id64);
  $usuario = MySQLPDO::constUsu($id);
}

if (!$usuario){
  die("El usuario no existe en la base de datos");
}
  ?>
    <div class="topnav">
        <a class="active" href="home_log.php">Home</a>
        <a href="../application/listaUsuarios.php">Administrar Usuarios</a>
        <a href="#contact">Calendario</a>
        <a href="#about">Opciones</a>
        <a class="active" href="terminarSesion.php">Cerrar sesión</a>
        </div>

    <div class="main">
    <p class="sign" align="center">Introduzca  <br> los datos<br> a modificar</p>
        <form method="POST" action="modUsuario.php">
        <input type="hidden" name="id" value="<?php echo $usuario->getId(); ?>">
        <input name="usuario" class="usuario" type="text" align="center" placeholder="Usuario" value="<?php echo $usuario->getNombreLogin(); ?>"/>
        <input name="nombre" class="usuario" type="text" align="center" placeholder="Nombre" value="<?php echo $usuario->getNombre(); ?>"/>
        <input name="apellido" class="usuario" type="text" align="center" placeholder="Apellidos" value="<?php echo $usuario->getApellido(); ?>"/>
        <input name="email" class="usuario" type="email" align="center" placeholder="Correo electrónico" value="<?php echo $usuario->getEmail(); ?>"/>
        <input name="date" type="date" class="usuario" align="center" placeholder="fecha de nacimiento" value="<?php echo $usuario->getFechaNacimiento(); ?>"/>
        <input type="submit" class="submit" align=center value="modificar" />
        <p class="forgot" align="center"><a href="modContra.php?id=<?php echo $usuario->getId(); ?>">Modificar contraseña</p>
        <input type="hidden" name="id" value="<?php echo $id?>"/>
        </form>
    </div>
</body>
</html>
<?php // Esto cierra el bracket del if que chequea si el usuario está logueado
  }else{
    header("Location: errorSesion.php");
}
?>
