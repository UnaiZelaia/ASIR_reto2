<html>
<head>
  <link rel="stylesheet" href="../css/Regiscss.css">
  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/home.css">
  <link rel="stylesheet" href="../css/tablaUsuarios.css">
  <title>Modificar usuario</title>
</head>
<?php
    session_start();                    //Iniciamos la session y comprobamos si el usuario está logeado.
    if(isset($_SESSION["logeado"]) && $_SESSION["usuario"]->getRol() == 2){    //Si la comprobación de sesión es correcta, se muestra la página.
?>
<body>
    <!-- Barra de navegación superior -->
    <div class="topnav">
        <a class="active" href="home_log.php">Home</a>
        <a href="listaUsuarios.php">Administrar Usuarios</a>
        <a href="resumenFaltas.php">Resumen de faltas</a>
        <a href="#about">Opciones</a>
        <a class="active" href="terminarSesion.php">Cerrar sesión</a>
    </div>
    <!-- Div que contiene el formulario principal -->
    <div class="main">
    <p class="sign" align="center">Modificar <br> contraseña</p>
    <form class="form1" method="POST" action="modContra.php?id=<?php echo $_GET["id"]; //El formulario recarga la página pasando el id del usuario a modificar como parámetro en la URL ?>"> 
        <input name="contra" class="usuario" type="password" align="center" placeholder="Introduzca su contraseña"/>
        <input name="nuevaContra1" class="pass" type="password" align="center" placeholder="Nueva contraseña"/>
        <input name="nuevaContra2" class="pass" type="password" align="center" placeholder="Confirmar nueva contraseña"/>
        <input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>"/>
        <input class="submit" align="center" type="submit" value="Modificar">    
    </form>
    </div>
    <?php
        //Includes para usar las clases usuario y MySQLPDO
        include("../model/Usuario.class.php");
        include("../persistance/MySQLPDO.class.php");


        if($_POST){                                   //Si llegan parametros mediante POST
            $postId = $_POST["id"];                   //Se recupera el usuario al que corresponde esa id de la base de datos
            $usuario = MySQLPDO::constUsu($postId);   //y se contruye un objeto usuario con los parámetros recibidos
            $contra = $_POST["contra"];               //Se recuperan las contraseñas introducidas en el formulario y se guerdan en variables (contaseña actual y nueva contraseña 2 veces)
            $nuevaContra1 = $_POST["nuevaContra1"];
            $nuevaContra2 = $_POST["nuevaContra2"];
              if(password_verify($contra, $usuario->getHashContra())){              //Si la contraseña introducida concuerda con la de la BBDD
                  if($nuevaContra1 == $nuevaContra2){                               //Y las 2 variables de nueva contraseña son iguales
                    $hashContra = password_hash($nuevaContra1, PASSWORD_DEFAULT);   //Se hashea la nueva contraseña
                    $usuario->setHashContra($hashContra);                           //y se guarda en la variable del objeto usuario $hashContra
                    $resultado = MySQLPDO::updateContra($usuario);                  //usamos el método updateContra() para modificar la contraseña. 
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
