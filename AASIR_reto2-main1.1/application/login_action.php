<?php
    include('persistance/MySQLPDO.class.php');               // IMPORTANTE MODIFICAR URL
    include('model/Usuario.class.php');                      // IMPORTANTE MODIFICAR URL

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
    $contenido = $resultado[0];

    if(password_verify($postContra, $contenido["hashContra"])){                                                    // modificar resultado[][] para que coja usuario.
        header("Location: http://localhost/ASIR_reto2-main/AASIR_reto2-main1.1/application/home_log.php");         // IMPORTANTE MODIFICAR URL
        exit();
    } else{
        print("</br>Login fallido<br>");
    }
?>