
<?php
    //Includes para usar las clases usuario y MySQLPDO y susu métodos.
    include('../persistance/MySQLPDO.class.php');
    include('../model/Usuario.class.php');  
    include('../model/Entradas.class.php');
    session_start();
    if(isset($_SESSION["logeado"]) && $_SESSION["usuario"]->getRol() == 2){
?>

<html>
<head>
        <link rel="stylesheet" href="../css/home.css">
        <link rel="stylesheet" href="../css/tablaUsuarios.css">
        <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
        <title>Lista</title>
</head>
<body>
    <div class="topnav">
        <a class="active" href="home_log.php">Home</a>
        <a href="listaUsuarios.php">Administrar Usuarios</a>
        <a href="resumenFaltas.php">Resumen de faltas</a>
        <a href="#about">Opciones</a>
        <a class="active" href="terminarSesion.php">Cerrar sesión</a>
    </div>
<table border="1" class="fl-table">
            <thead>
            <tr>
                <th>idEntr_Sal</th>
                <th>idUsuario</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Justificar Falta</th>
            </tr>

<?php
$id64 = $_GET['id'];
$id = base64_decode($id64);
$resultado = MySQLPDO::verFaltas($id);
if(sizeof($resultado) != 0){                //Si la variable resultado NO está vacia (hay registros) se ejecuta el siguiente código.
    foreach($resultado as $faltas){       //foreach loop que se ejecuta las mismas veces que registros hay.
        extract($faltas);                 //Método extract() para generar variables desde una array de manera automática.     
?>

    <tr> 
            <td><?php echo $idEntr_Sal ?></td>
            <td><?php echo $idUsuario ?></td>
            <td><?php echo $Fecha ?></td>
            <td><?php echo $Hora_Entr ?></td>
            <td><form action="verFaltas.php?id=<?php echo $id64?>" method="POST">
                <input type="hidden" name="id" value="<?php echo $identr_sal?>"/>
                <input type="submit" name="justificarFalta" value="Justificar falta">
            </form></td>
    </tr>
    <?php if (isset($_POST["justificarFalta"])){
        $falta = $identr_sal;
        $sql = "DELETE FROM registroEntradas WHERE identr_sal = ?";
        $params = array($falta);
        MySQLPDO::exec($sql, $params);
    }
    }
    }
    } else {
        header("Location: errorSesion.php");
    }
    ?>
</table>
</div>
</body>
</html>