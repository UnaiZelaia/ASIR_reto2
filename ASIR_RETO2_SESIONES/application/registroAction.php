<?php
    include('persistance/MySQLPDO.class.php');
    include('model/Usuario.class.php');

    if ($_POST){
    $usuario = new usuario();

    $postUsuario = $_POST["usuario"];
    $postPass = $_POST["pass"];                                        
    $postNombre = $_POST["nombre"];                                        
    $postApellido = $_POST["apellido"];                                       
    $postEmail = $_POST["email"];                                        
    $postDate = $_POST["date"];              
        
    $usuario -> setNombreLogin($postUsuario);
    $usuario -> setHashContra(password_hash($postPass, PASSWORD_DEFAULT));
    $usuario -> setNombre($postNombre);
    $usuario -> setApellido($postApellido);
    $usuario -> setEmail($postEmail);
    $usuario -> setFechaNacimiento($postDate);

    $resultado = MySQLPDO::insUsuario($usuario);

    if($resultado != 0){
        $nombreLogin = $usuario -> getNombreLogin();
        $contenido = MySQLPDO::loginPDO($postUsuario, $postContra);

        if(password_verify($postPass, $contenido["hashContra"]) == true){
            session_start();
            $_SESSION["usuario"] = new usuario;    
            $_SESSION["usuario"] ->setNombre($contenido["nombre"]);
            $_SESSION["usuario"] ->setApellido($contenido["apellido"]);
            $_SESSION["usuario"] ->setNombreLogin($contenido["nombreLogin"]);
            $_SESSION["usuario"] ->setEmail($contenido["email"]);
            $_SESSION["usuario"] ->setFechaNacimiento($contenido["fechaNacimiento"]);
            header("Location: http://localhost/ASIR_RETO2_SESIONES/application/home_log.php");    //TODO: Cambiar a ruta relativa
            exit();
        }else{
            header("Location: http://localhost/ASIR_RETO2_SESIONES/application/ErrorLogin.php");
            exit();
        }
    }else{
        print("Login fallido");
    }
}
?>