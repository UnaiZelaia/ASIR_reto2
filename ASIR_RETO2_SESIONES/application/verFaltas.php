
<?php
    //Includes para usar las clases usuario y MySQLPDO y susu métodos.
    include('persistance/MySQLPDO.class.php');
    include('model/Usuario.class.php');  
    session_start();
    if(isset($_SESSION["logeado"])){
?>

<html>
<head>
        <link rel="stylesheet" href="css/home.css">
        <link rel="stylesheet" href="../application/css/tablaUsuarios.css">
        <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
        <title>Lista</title>
</head>
<body>
<div class="topnav">
        <a class="active" href="home_log.php">Home</a>
        <a href="../application/listaUsuarios.php">Administrar Usuarios</a>
        <a href="#contact">Calendario</a>
        <a href="#about">Opciones</a>
        <a class="active" href="terminarSesion.php">Cerrar sesión</a>
        </div>
<div class="table-wrapper">
<table border="1" class="fl-table">
            <thead>
            <tr>
                <th>idEntr_Sal</th>
                <th>idUsuario</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Entr_Sali</th>
            </tr>

<?php
if($_POST){
$id = $_GET['id'];
$id= base64_decode($id);
$pasarid = new usuario();
$pasarid->SetId($id);
$resultado = MySQLPDO::verFalta($pasarid);
if(sizeof($resultado) != 0){                //Si la variable resultado NO está vacia (hay registros) se ejecuta el siguiente código.
    foreach($resultado as $faltas){       //foreach loop que se ejecuta las mismas veces que registros hay.
        extract($faltas);                 //Método extract() para generar variables desde una array de manera automática.     
?>

    <tr> 
            <td><?php echo $identr_sal ?></td>
            <td><?php echo $idUsuario ?></td>
            <td><?php echo $fecha ?></td>
            <td><?php echo $hora ?></td>
            <td><?php echo $entr_sal ?></td>
    </tr>
    <?php
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