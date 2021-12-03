<?php 
    include_once "../model/Usuario.class.php";
    session_start();
    exec("cmd /c start java -jar --enable-preview C:\Users/2ASIR\Desktop\ASIR2_HUELLA_JAVA\ASIR2_HUELLA_JAVA.jar" . " " . $_SESSION["usuario"]->getNombreLogin());
    header("Location: home_log.php");
?>