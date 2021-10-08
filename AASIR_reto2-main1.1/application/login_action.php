<?php
    require_once('S:/clase/AASIR_reto2-main1.1/persistance/MySQLPDO.class.php');               // IMPORTANTE MODIFICAR URL
    require_once('S:/clase/AASIR_reto2-main1.1/application/model/Usuario.class.php');          // IMPORTANTE MODIFICAR URL

    MySQLPDO::connect();
    $usuario = new Usuario;

    $postUsuario = $_POST["usuario"];
    $postContra = $_POST["pass"];

    $usuario -> setNombreLogin($postUsuario);
    $usuario -> sethashContra($postContra);
    $nomUsuario = $usuario ->getNombreLogin();
    

    $sql = "SELECT * FROM usuario WHERE nombreLogin = ?";
    $params = array($usuario->getNombreLogin());
    $resultado = MySQLPDO::select($sql, $params);

    if(password_verify($postContra, $resultado[0][3])){
        header("Location: http://localhost/AASIR_reto2-main1.1/application/home_log.php");         // IMPORTANTE MODIFICAR URL
        exit();
    } else{
        print("</br>Login fallido<br>");
    }

    print("nombre: $nomUsuario </br> contraseña: " . password_hash($postContra, PASSWORD_DEFAULT));
?>