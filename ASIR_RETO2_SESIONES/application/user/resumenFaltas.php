<?php
    //Incluimos la clase usuario para poder usarla.
    include('../model/Usuario.class.php');
    include('../persistance/MySQLPDO.class.php');

    //Iniciamos la sesion y comprobamos si la variable logeado está establecida. Si lo está, la página se carga. sino, se redirige al usuario a una página de error.
    session_start();
    if(isset($_SESSION["logeado"])){    //Método isset de PHP para comprobar si la variable logeado está establecida.
?>
<html>
    <head>
        <link rel="stylesheet" href="../css/home.css">
        <link rel="stylesheet" href="../css/tablaUsuarios.css">
        <title>HOME</title>
</head>
    <body>
    <div class="topnav">
        <a class="active" href="home_log.php">Home</a>
        <a href="listaUsuarios.php">Administrar Usuarios</a>
        <a href=".resumenFaltas.php">Resumen de faltas</a>
        <a href="#about">Opciones</a>
        <a class="active" href="terminarSesion.php">Cerrar sesión</a>
    </div>

    <div>
        <form align="left" method="POST" action="resumenFaltas.php">
        Buscar por nombre: <input type="text" name="nombre"></input>
        <input type="submit" value="Buscar" name="busquedaNombre">
        </form>
        <form align="right" method="POST" action="resumenFaltas.php">
            Buscar por fecha: <br>Fecha de inicio: <input type="date" name="fechaInicio"></input><br>
            Fecha final: <input type="date" name="FechaFin"></input><br>
            <input type="submit" value="Buscar" name="busquedaFecha">
        </form>
    </div>
    <?php
        if($_POST["busquedaNombre"]){ ?>

            <div class="table-wrapper">
        <table border="1" class="fl-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Dia Faltado</th>
                </tr>
            </thead>
            <?php
                    //Usamos el método listaUsu() para realizar una consulta con la base de datos que devuelva todos los usuarios que estén almacenados y
                    //lo gurdamos en una variable. Esta variable es un array bidimensional con todos los registros de los usuario guardados en arrays.
                    $resultado = MySQLPDO::buscarNombreFaltas($_POST["nombre"]);
                    if(sizeof($resultado) != 0){                //Si la variable resultado NO está vacia (hay registros) se ejecuta el siguiente código.
                        foreach($resultado as $registro){       //foreach loop que se ejecuta las mismas veces que registros hay.
                            extract($registro);                 //Método extract() para generar variables desde una array de manera automática.
                            ?>                                  
                         
                            <!-- Código que genera la lista de los usuarios. Se pinta un dato del usuario por cada casilla -->
                            <!-- Se abre un bloque php en cada <td> de la lista en la que hacemos echo al parametro deseado -->
                            <tr>                                        
                            <td><?php echo $nombre ?></a></td> 
                            <td><?php echo $apellido ?></td>
                            <td><?php echo $Fecha ?></td>
                            <?php
                        }
                    
                    }else{
                        print("No se han encontrado resultados"); //Si no hay registros en la base de datos, se pinta por pantalla.
                }





        } elseif($_POST["busquedaFecha"]){ ?>
            <div class="table-wrapper">
        <table border="1" class="fl-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Dia Faltado</th>
                </tr>
            </thead>
            <?php
                    //Usamos el método listaUsu() para realizar una consulta con la base de datos que devuelva todos los usuarios que estén almacenados y
                    //lo gurdamos en una variable. Esta variable es un array bidimensional con todos los registros de los usuario guardados en arrays.
                    $resultado = MySQLPDO::buscarFechas($_POST["fechaInicio"], $_POST["fechaFin"]);
                    if(sizeof($resultado) != 0){                //Si la variable resultado NO está vacia (hay registros) se ejecuta el siguiente código.
                        foreach($resultado as $registro){       //foreach loop que se ejecuta las mismas veces que registros hay.
                            extract($registro);                 //Método extract() para generar variables desde una array de manera automática.
                            ?>                                  
                         
                            <!-- Código que genera la lista de los usuarios. Se pinta un dato del usuario por cada casilla -->
                            <!-- Se abre un bloque php en cada <td> de la lista en la que hacemos echo al parametro deseado -->
                            <tr>                                        
                            <td><?php echo $nombre ?></a></td> 
                            <td><?php echo $apellido ?></td>
                            <td><?php echo $Fecha ?></td>
                            <?php
                        }
                    
                    }else{
                        print("No se han encontrado resultados"); //Si no hay registros en la base de datos, se pinta por pantalla.
                }

        }else{
    ?>


    <div class="table-wrapper">
        <table border="1" class="fl-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Dia Faltado</th>
                </tr>
            </thead>
            <?php
                    //Usamos el método listaUsu() para realizar una consulta con la base de datos que devuelva todos los usuarios que estén almacenados y
                    //lo gurdamos en una variable. Esta variable es un array bidimensional con todos los registros de los usuario guardados en arrays.
                    $resultado = MySQLPDO::resumenFaltas();

                    if(sizeof($resultado) != 0){                //Si la variable resultado NO está vacia (hay registros) se ejecuta el siguiente código.
                        foreach($resultado as $registro){       //foreach loop que se ejecuta las mismas veces que registros hay.
                            extract($registro);                 //Método extract() para generar variables desde una array de manera automática.
                            ?>                                  
                         
                            <!-- Código que genera la lista de los usuarios. Se pinta un dato del usuario por cada casilla -->
                            <!-- Se abre un bloque php en cada <td> de la lista en la que hacemos echo al parametro deseado -->
                            <tr>                                        
                            <td><?php echo $nombre ?></a></td> 
                            <td><?php echo $apellido ?></td>
                            <td><?php echo $Fecha ?></td>
                            <?php
                        }
                    
                    }else{
                        print("No se han encontrado resultados"); //Si no hay registros en la base de datos, se pinta por pantalla.
                }
            }
                ?>
<?php } ?>

    