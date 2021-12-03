<?php
    include('persistance/MySQLPDO.class.php');
    include('model/Usuario.class.php');

    if ($_POST){                //Los datos del usuario llegan desde el formulario de registro mediante POST
    $usuario = new usuario();   //Creamos un objeto usuario con los datos enviados por POST

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

    $resultado = MySQLPDO::insUsuario($usuario);     //Usamos el método insUsuario() para insertar los datos del objeto usuario en la base de datos

    if($resultado != 0){                             //Si el resultado de la consulta devuelve algo (número de filas afectadas), se asume que el registro ha sido exitoso
        $nombreLogin = $usuario -> getNombreLogin();
        $contenido = MySQLPDO::loginPDO($postUsuario, $postContra);

        if(password_verify($postPass, $contenido["hashContra"]) == true){    //Si la verificacion de contraseña es correcta, se construye objeto usuario como variable de sesion y se redirige a home_log.php
            session_start();
            $_SESSION["usuario"] = new usuario;    
            $_SESSION["usuario"] ->setNombre($contenido["Nombre"]);
            $_SESSION["usuario"] ->setApellido($contenido["Apellido"]);
            $_SESSION["usuario"] ->setNombreLogin($contenido["nombreLogin"]);
            $_SESSION["usuario"] ->setEmail($contenido["email"]);
            $_SESSION["usuario"] ->setFechaNacimiento($contenido["FechaNaci"]);
            header("Location: home_log.php");
            exit();
        }else{
            header("Location: errorLogin.php");
            exit();
        }
    }else{
        print("Login fallido");
    }
}
?>
