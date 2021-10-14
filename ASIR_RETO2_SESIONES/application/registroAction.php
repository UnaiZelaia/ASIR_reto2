<?php
    include('persistance/MySQLPDO.class.php');
    include('model/Usuario.class.php');

    MySQLPDO::connect();
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

    $sql = "INSERT INTO usuario(nombre, apellido, nombreLogin, hashContra, email, fechaNacimiento) VALUES(
        ?, ?, ?, ?, ?, ?
    )";
    $params = array($usuario-> getNombre(), $usuario-> getApellido(), $usuario-> getNombreLogin(), $usuario-> getHashContra(), $usuario-> getEmail(), $usuario-> getFechaNacimiento());
    $resultado = MySQLPDO::exec($sql, $params);
    

    if($resultado == true){
        header("Location: http://localhost/ASIR_reto2-main/AASIR_reto2-main1.1/application/login.php");         // IMPORTANTE MODIFICAR URL
        exit();
    }
    else{
        print("Login fallido");
    }
?>