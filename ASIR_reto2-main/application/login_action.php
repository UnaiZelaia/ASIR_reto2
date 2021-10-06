<?php
    require_once('D:/test/php/ASIR_reto2-main/persistance/MySQLPDO.class.php');
    require_once('D:/test/php/ASIR_reto2-main/application/model/Usuario.class.php');
    $usuario = new Usuario;

    $postUsuario = $_POST["usuario"];
    $postContra = $_POST["pass"];

    $usuario -> setNombreLogin($postUsuario);
    $usuario -> sethashContra($postContra);
    $nomUsuario = $usuario ->getNombreLogin();
    MySQLPDO::connect();

    $sql = "SELECT * FROM usuario WHERE nombreLogin = ?";
    $params = array($usuario->getNombreLogin());
    $resultado = MySQLPDO::select($sql, $params);

    if(password_verify($postContra, $resultado[0][4])){
        print("</br>Login exitoso<br>");
    } else{
        print("</br>Login fallido<br>");
    }

    print("nombre: $nomUsuario </br> contraseña: " . password_hash($postContra, PASSWORD_DEFAULT));
?>