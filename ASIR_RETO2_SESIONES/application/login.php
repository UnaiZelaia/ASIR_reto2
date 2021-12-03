<html>
<head>
  <link rel="stylesheet" href="css/Login_css.css">
  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  <title>Sign in</title>
</head>

<body>
  <div class="main">
    <p class="sign" align="center">Grupo 3 <br> ASIR</p>
 <!-- El formulario principal para recoger información del usuario que quiera hacer login (Nombre de usuario y contraseña) y las envia mediante método POST al documento PHP que
 maneja está información (login_action.php). -->
    <form class="form1" method="POST" action="login_action.php">
      <input name="usuario" class="usuario" type="text" align="center" placeholder="Usuario"/>
      <input name="pass" class="pass" type="password" align="center" placeholder="Contraseña"/>
      <input class="submit" align="center" type="submit" value="Iniciar sesión"></a>
    
    <!-- Link para ir al la página de recuperación de contraseña -->
      <p class="forgot" align="center"><a href="recuperarContra.php">Recuperar contraseña</p>
    <!-- Link para ir al la página de registro de usuario -->
      <p class="Registro" align="center"><a href="Registro.php"> Regístrate</P>        
    </div>
</body>
</html>
