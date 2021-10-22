<html>
<head>
  <link rel="stylesheet" href="css/Regiscss.css">
  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  <title>Sign in</title>
</head>
<body>

  <?php
  include('persistance/MySQLPDO.class.php');
  MySQLPDO::connect();
  $id=$_GET["id"];
  $sql="SELECT id, nombre, apellido, nombreLogin, email, fechaNacimiento FROM usuario WHERE id=?";
  $params = array($id);
  $resultado = MySQLPDO::select($sql, $params);
  $resultado = $resultado[0]
  
  ?>

    <div class="main">
    <p class="sign" align="center">Introduzca  <br> los datos<br> a modificar</p>
        <form action="registroAction.php" method="POST">
        <input name="usuario" class="usuario" type="text" align="center" placeholder="Usuario" value="<?php echo $resultado["nombreLogin"]?>"/>
        <input name="nombre" class="usuario" type="text" align="center" placeholder="Nombre" value="<?php echo $resultado["nombre"]?>"/>
        <input name="apellido" class="usuario" type="text" align="center" placeholder="Apellidos" value="<?php echo $resultado["apellido"]?>"/>
        <input name="email" class="usuario" type="email" align="center" placeholder="Correo electrónico" value="<?php echo $resultado["email"]?>"/>
        <input name="date" type="date" class="usuario" align="center" placeholder="fecha de nacimiento" value="<?php echo $resultado["fechaNacimiento"]?>"/>
        <input type="submit" class="submit" align=center value="modificar" />
        <p class="forgot" align="center"><a href="Login.php">Volver a la página de login</p>
        </form>
    </div>
</body>
</html>