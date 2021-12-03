<?php
    // incluimos las clases de Usuario y MySQLPDO para poder usar sus métodos y crear objetos.
    include('../persistance/MySQLPDO.class.php');
    include('../model/Usuario.class.php');              

    //Recuperamos los parámetros que se han enviado mediante el método POST (usuario y contraseña).
    $postUsuario = $_POST["usuario"];
    $postContra = $_POST["pass"];

    //Usamos el método loginPDO (ver documentación para más información) de la clase MySQLPDO para realizar una consulta con la base de datos. Como parametro de entrada usamos
    //el nombre del usuario. Guardamos en la variable contenido un array con todos los parámetros del usuario.

    $contenido = MySQLPDO::loginPDO($postUsuario);

    //Usamos el método incluido de php password_verify() para determinar si la contraseña introducida en el login concuerda con la contraseña de la base de datos. Este método
    //crea un hash de la contraseña e texto plano que le introducimos y lo compara con el hash de la contraseña de la BBDD.

    if (password_verify($postContra, $contenido["hashContra"]) == true){//Si la comparación es exitosa:
            session_start();                                            //Iniciamos sesion para continuidad de las variables a través de diferentes páginas.
            $_SESSION["usuario"] = new usuario;                         //Creamos un objeto usuario como variable de sesión. 
            $_SESSION["usuario"] ->setNombre($contenido["Nombre"]);     //Asignamos las variables del objeto usuario usando lo datos recuperados de la BBDD.
            $_SESSION["usuario"] ->setApellido($contenido["Apellido"]);
            $_SESSION["usuario"] ->setNombreLogin($contenido["nombreLogin"]);
            $_SESSION["usuario"] ->setEmail($contenido["email"]);
            $_SESSION["usuario"] ->setFechaNacimiento($contenido["FechaNaci"]);
            $_SESSION["usuario"] ->setHashContra($contenido["hashContra"]);   
            $_SESSION["logeado"] = "OK";                                //Creamos esta variable de sesión para futuras comprobaciones.                         
            header("Location: Home_log.php");                           //Mandamos al usuario a la página principal de la aplicación.
            exit();
    } else{
            header("Location: ErrorLogin.php");                         //Si la verificación de la contraseña falla, se redirige al usuario a una página de error.
            exit();
    }
?>
