<html>
<head>
  <link rel="stylesheet" href="css/Regiscss.css">
  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  <title>Sign in</title>
</head>
<body>
    <div class="main">
    <p class="sign" align="center">Introduzca  <br> sus datos</p>
        <form action="registroAction.php" method="POST">
        <input name="usuario" class="usuario" type="text" align="center" placeholder="Usuario"/>
        <input name="pass" class="pass" type="password" align="center" placeholder="Contraseña"/>
        <input name="nombre" class="usuario" type="text" align="center" placeholder="Nombre"/>
        <input name="apellido" class="usuario" type="text" align="center" placeholder="Apellidos"/>
        <input name="email" class="usuario" type="email" align="center" placeholder="Correo electrónico"/>
        <input name="date" type="date" class="usuario" align="center" placeholder="fecha de nacimiento"/>
        <input type="submit" class="submit" align=center value="Registrarse" />
        <p class="forgot" align="center"><a href="Login.php">Volver a la página de login</p>
        </form>
    </div>
</body>
</html>