<?php
    function alert($msg) {
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
    alert("Parece que no has iniciado sesión. Inicia sesión para ver este contenido");
    header("Location: login.php");
?>