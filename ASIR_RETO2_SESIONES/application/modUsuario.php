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
//Includes para las clases de MySQLPDO y Usuario.
include('persistance/MySQLPDO.class.php');
include('model/Usuario.class.php');

//Iniciamos la sesión y comprobamos si la variable logeado está establecida. Si lo está, se ejecuta la página.
session_start();
if(isset($_SESSION["logeado"])){

if($_POST){                         //Comprueba si se han enviado parametros mediante POST. Este código se encarga de recibir información del formulario de abajo y modificar el usuario con los parametros enviados.
  $modId = $_POST["id"];            //Por defecto no debe ejecutarse la primera vez que se entra a la página debido a que estamos recibiendo el parametro id a través de GET
  $nombre = $_POST["nombre"];       //Este código solo se ejecuta cuando el formulario de la linea 65 envia parametros mediante POST.
  $nombreLogin = $_POST["usuario"]; //Primero recuperamos las variables enviadas mediante el método POST y las guardamos en variables.
  $apellido = $_POST["apellido"];
  $email = $_POST["email"];
  $fechaNacimiento = $_POST["date"];
                                      
  $modUsuario = new usuario();      //Creamos un objeto usuario y establecemos sus variables a los valores enviados mediante POST.
  $modUsuario->setId($modId);
  $modUsuario->setNombre($nombre);
  $modUsuario->setApellido($apellido);
  $modUsuario->setNombreLogin($nombreLogin);
  $modUsuario->setEmail($email);
  $modUsuario->setFechaNacimiento($fechaNacimiento);

  MySQLPDO::updateUsuario($modUsuario); //La función updateUsuario() de MySQLPDO recibe un objeto usuario y modifica el registro del id correspondiente con los datos de ese objeto.
  header("Location: listaUsuarios.php"); //Se reenvia al usuario a la misma página para actualizar la lista.

}else if(!isset($_GET["id"])){          //Comprueba si el parametro id se ha pasado mediante URL con el método GET. Si no se ha enviado, lanza un error y no carga la página.
  die("ERROR: No se ha recibido ID de usuario");
}else{                                  //Si el parámetro es enviado
  $id64 = $_GET["id"];                  //Se guarda en una variable 
  $id = base64_decode($id64);           //se decodifica la codificacion de base64
  $usuario = MySQLPDO::constUsu($id);   //Y se contruye un objeto usuario usando el id como parámetro con el nombre $usuario.
}

if (!$usuario){                                     //Comprueba si existe un objeto usuario con nombre $usuario existe. 
  die("El usuario no existe en la base de datos");  //Si no existe, lanza un error y no carga la página.
}
  ?>
  
    <!-- Barra de navegación superior -->
    <div class="topnav">
        <a class="active" href="home_log.php">Home</a>
        <a href="../application/listaUsuarios.php">Administrar Usuarios</a>
        <a href="../application/resumenFaltas.php">Resumen de faltas</a>
        <a href="#about">Opciones</a>
        <a class="active" href="terminarSesion.php">Cerrar sesión</a>
    </div>

    <!-- Div que contiene el formulario principal. Muestra los valores del usuario a modificar. Si cambias un parámetro y haces click sobre modificar, este parámetro se cambia -->
    <!-- Los datos son enviados mediante método POST y los maneja el bloque de código que comienza en la linea 21 de está página -->
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
<?php
  }else{            //Si la comprobación de sesion falla, se redirige al usuario a una página de error.
    header("Location: errorSesion.php");
}
?>
