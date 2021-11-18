<?php

include_once './bd.php';
include_once 'persistance/MySQLPDO.class.php';
$con = new bd();
$foto = null;
$extension = null;

if (isset($_FILES['foto']) && !empty($_FILES['foto'])) {
    $archivo = $_FILES['foto']["tmp_name"];
    $nombre_archivo = $_FILES['foto']["name"];
    $size = $_FILES['foto']["size"];
    $ext_pat = pathinfo($nombre_archivo);
    $ext = $ext_pat['extension'];
    $fp = fopen($archivo, 'rb');
    $contenido = fread($fp, $size);
    $temp = addslashes($contenido);
    fclose($fp);
    $foto = $temp;
}

$sqlInsert = "INSERT INTO usuario (nombre, apellido, nombreLogin, fecha_creacion) VALUES ?, ?, ?, NOW()";
$insertParams = array($_POST["nombre"], $_POST["apellido"], $_POST["nombreLogin"]);
MySQLPDO::exec($sqlInsert, $insertParams);


$insertHuella = "insert into huellas (documento, nombre_dedo, huella, imgHuella) "
        . "values ('" . $_POST['documento'] . "', 'Indice D',"
        . " (select huella from huellas_temp where pc_serial = '" . $_POST['token'] . "'), "
        . "(select imgHuella from huellas_temp where pc_serial = '" . $_POST['token'] . "'))";
$row = $con->exec($insertHuella);

$delete = "delete from huellas_temp where pc_serial = '" . $_POST['token'] . "'";

$row = $con->exec($delete);

$con->desconectar();
echo json_encode("{\"filas\":$row}");
