<?php
    include('persistance/MySQLPDO.class.php');
    include('model/Usuario.class.php');              

    $usuario = new usuario;
    $postUsuario = $_POST["usuario"];
    $postContra = $_POST["pass"];

    $contenido = MySQLPDO::loginPDO($postUsuario);

    if (password_verify($postContra, $contenido["hashContra"]) == true){
            session_start();
            $_SESSION["usuario"] = new usuario;
            $_SESSION["usuario"] ->setNombre($contenido["nombre"]);
            $_SESSION["usuario"] ->setApellido($contenido["apellido"]);
            $_SESSION["usuario"] ->setNombreLogin($contenido["nombreLogin"]);
            $_SESSION["usuario"] ->setEmail($contenido["email"]);
            $_SESSION["usuario"] ->setFechaNacimiento($contenido["fechaNacimiento"]);
            $_SESSION["usuario"] ->setHashContra($contenido["hashContra"]);
            $_SESSION["logeado"] = "OK";                               
            header("Location: home_log.php");
            exit();
    } else{
            header("Location: ErrorLogin.php");
            exit();
    }
?>