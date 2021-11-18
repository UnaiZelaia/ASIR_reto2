<html>
<?php
if (!isset($_GET["token"])) {
    header("Location: errorSesion.php");
}
?>
<head>
  <meta http-equiv="refresh" content="600"/>
  <link rel="stylesheet" href="css/Login_css.css"/>
  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet"/>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css"/>
  <script src="js/jquery-1.7.2.min.js" type="text/javascript"></script>
  <script src="js/funciones.js" type="text/javascript"></script>
  <title>Sign in</title>
</head>

<body>
  <div class="main">
    <p class="sign" align="center">Grupo 3 <br> ASIR</p>
    <form class="form1" method="POST" action="login_action.php">
      <input name="usuario" class="usuario" type="text" align="center" placeholder="Usuario"/>
      <input name="pass" class="pass" type="password" align="center" placeholder="Contraseña"/>
      <input class="submit" align="center" type="submit" value="Iniciar sesión"></a>
      <p class="forgot" align="center"><a href="recuperarContra.php">Recuperar contraseña</p>
      <p class="Registro" align="center"><a href="Registro.php"> Regístrate</a></p>  
      <a target="_self" href="Model/ActivarSensorReader.php?token=<?php echo $_GET["token"]; ?>">Verificar Usuario</a>    
    </div>
    <div id="mensaje">
            <img id="imageMessage" />
            <div class="messageStyle">
                <p id="txtMensaje"></p>
            </div>
        </div>
        <form>
            <div>
                <div>
                    <label>nombre</label>
                    <input id="Nombre" type="text" />
                </div>
                <div style="margin-top: 5px;">
                    <label>apellido</label>
                    <input id="apellido" type="text" />
                </div>
                <div style="margin-top: 5px;">
                    <label>Nombre de usuario:</label>
                    <input id="login" type="text" />
                </div>
                <div style="margin-top: 5px;">
                    <label>Foto:</label>
                    <input id="foto" type="file" />
                </div>   
                <input id="activeSensorLocal" onclick="activarSensor('<?php echo $_GET["token"] ?>')" style="margin-top: 5px;" type="button" value="Asociar Huella" />
                <input id="saveChanges" onclick="addUser('<?php echo $_GET["token"] ?>')" style="margin-top: 5px;" type="button" value="Guardar" />
                <a target="_self" href="model/ActivarSensorReader.php?token=<?php echo $_GET["token"]; ?>">Verificar Usuario</a>
            </div>

            <div id="fingerPrint" style="border: solid 1px black;width: 18%;height: 290px;margin-top: 5px;display: none;">
                <div style="display: block">
                    <img id="<?php echo base64_decode($_GET["token"]); ?>" src="imagenes/finger.png" style="width: 80%;margin-left: 9%;"> 
                </div>
                <div style="display: block;padding-left: 3px;">
                    <label id="<?php echo base64_decode($_GET["token"]) . "_status" ?>" style="margin-left: 5px;">
                        Estado del sensor: Inactivo
                    </label>
                    <textarea id="<?php echo base64_decode($_GET["token"]) . "_texto" ?>" cols="30" rows="3"> 
                        ---
                    </textarea>
                </div>
            </div>
        </form>
    </body>
    <script src="js/funciones.js" type="text/javascript"></script>
    <script>
                    cargar_push();
    </script>
</html>