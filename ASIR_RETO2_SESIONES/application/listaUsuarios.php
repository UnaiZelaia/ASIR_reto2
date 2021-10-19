<?php
    include('persistance/MySQLPDO.class.php');
    include('model/Usuario.class.php');  

    
    $resultado = MySQLPDO::listaUsu();

?>
<html>
    <head>
        <link rel="stylesheet" href="../application/css/tablaUsuarios.css">
        <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
        <title>Lista</title>
    </head>
    <body>
        <div class="table-wrapper">
        <table border="1" class="fl-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Login</th>
                <th>Email</th>
                <th>Fecha de Nacimiento</th>
            </tr>
            </thead>
                <?php
                    foreach($resultado as $registro){
                        print("<tr>");
                        print("<td>" . $registro["id"] . "</td>");
                        print("<td>" . $registro["nombre"] . "</td>");
                        print("<td>" . $registro["apellido"] . "</td>");
                        print("<td>" . $registro["nombreLogin"] . "</td>");
                        print("<td>" . $registro["email"] . "</td>");
                        print("<td>" . $registro["fechaNacimiento"] . "</td>");
                    }
                ?>
        </table>
        </div>
    </body>
</html>