<?php
    require_once('S:/clase/ASIR_reto2-main/persistance/MySQLPDO.class.php');
    require_once('S:/clase/ASIR_reto2-main/application/model/Usuario.class.php');
    $usuario = new Usuario;

    $postUsuario = $_POST["usuario"];
    $postContra = $_POST["pass"];

    $hashContra = password_hash($postContra, PASSWORD_DEFAULT);

    $usuario -> setNombre($postUsuario);
    $usuario -> sethashContra($hashContra);

    $nombreUsuario = $usuario -> getNombre();

    print("nombre: $nombreUsuario</br> contraseña: $hashContra");
?>