<?php
    session_start();
    include('persistance/MySQLPDO.class.php');
    include('model/Usuario.class.php');              

    MySQLPDO::connect();
    $_SESSION["usuario"] = new Usuario;

    $postUsuario = $_POST["usuario"];
    $postContra = $_POST["pass"];

    $nomUsuario = $_SESSION["usuario"] ->getNombreLogin();
    $_SESSION["usuario"] ->setNombreLogin($postUsuario);

    $sql = "SELECT * FROM usuario WHERE nombreLogin = ?";
    $params = array($_SESSION["usuario"]->getNombreLogin());
    $resultado = MySQLPDO::select($sql, $params);
    $contenido = $resultado[0];



    if(password_verify($postContra, $contenido["hashContra"])){    
        $_SESSION["usuario"] ->setNombre($contenido["nombre"]);
        $_SESSION["usuario"] ->setApellido($contenido["apellido"]);
        $_SESSION["usuario"] ->setNombreLogin($contenido["nombreLogin"]);
        $_SESSION["usuario"] ->setEmail($contenido["email"]);
        $_SESSION["usuario"] ->setFechaNacimiento($contenido["fechaNacimiento"]);                                           
        header("Location: http://localhost/ASIR_reto2-main/AASIR_reto2-main1.1/application/home_log.php");
        exit();
    } else{
        print("</br>Login fallido<br>");
    }
?>