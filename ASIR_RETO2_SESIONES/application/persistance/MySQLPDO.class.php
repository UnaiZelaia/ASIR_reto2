<?php
class MySQLPDO {
    private static $host = "localhost"; //o la IP del servidor de BBBDD remoto
    private static $database = "reto2grupo3";
    private static $username = "db_reto2";
    private static $password = "123";
    private static $base;
    
    public static function connect() {
        if (MySQLPDO::$base != null) {
            MySQLPDO::$base = null;
        }
        try {
            $dsn = "mysql:host=" . MySQLPDO::$host . ";dbname=" . MySQLPDO::$database;
            MySQLPDO::$base = new PDO($dsn, MySQLPDO::$username, MySQLPDO::$password);
            MySQLPDO::$base->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            return MySQLPDO::$base;
        } catch (Exception $e) {
            die ("Error connecting: {$e->getMessage()}");
        }
    }
    
    //ejecuta sentencias INSERT, UPDATE y DELETE
    public static function exec($sql, $params) {
        MySQLPDO::connect();
        $stmt = MySQLPDO::$base->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->rowCount();
        return $result; //devuelve el nº de filas afectadas por la sentencia
    }
    
    //ejecuta sentencias SELECT
    public static function select($sql, $params) {
        MySQLPDO::connect();
        $stmt = MySQLPDO::$base->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll();
        return $result; //devuelve el conjunto de datos de la consulta
    }

    public static function insUsuario($usuario){
        MySQLPDO::connect();
        $sql = "INSERT INTO usuario(nombre, apellido, nombreLogin, hashContra, email, fechaNacimiento) VALUES(
            ?, ?, ?, ?, ?, ?
        )";
        $params = array($usuario-> getNombre(), $usuario-> getApellido(), $usuario-> getNombreLogin(), $usuario-> getHashContra(), $usuario-> getEmail(), $usuario-> getFechaNacimiento());
        $resultado = MySQLPDO::exec($sql, $params);
        return $resultado;
    }

    public static function loginPDO($nombreUsuario){
        MySQLPDO::connect();
        $sql = "SELECT * FROM usuario WHERE nombreLogin = ?";
        $params = array($nombreUsuario);
        $resultado = MySQLPDO::select($sql, $params);
        $contenido = $resultado[0];
        return $contenido;
    }

    public static function listaUsu(){
        MySQLPDO::connect();
        $sql = "SELECT idUsuario, nombre, apellido, nombreLogin, email, fechaNacimiento FROM usuario";
        $params = array();
        $resultado = MySQLPDO::select($sql, $params);
        return $resultado;
    }


    public static function constUsu($id){
        MySQLPDO::connect();
        $sql = "SELECT * FROM usuario WHERE idUsuario = ?";
        $params = array($id);
        $resultado = MySQLPDO::select($sql, $params);

        if(sizeof($resultado) != 0){    
            extract($resultado[0]);
            $usuario = new usuario;
            $usuario->setId($idUsuario);
            $usuario ->setNombre($Nombre);
            $usuario ->setApellido($Apellido);
            $usuario ->setNombreLogin($nombreLogin);
            $usuario ->setEmail($email);
            $usuario ->setFechaNacimiento($FechaNacimiento);
            $usuario ->setHashContra($hashContra);
            return $usuario;
        }else{
            return false;
        }
    }


    public static function updateUsuario($usuario){
        MySQLPDO::connect();
        $sql = "UPDATE usuario SET nombre=?, apellido=?, nombreLogin=?, email=?, fechaNacimiento=? WHERE idUsuario=?";
        $params = array($usuario->getNombre(), $usuario->getApellido(), $usuario->getNombreLogin(), $usuario->getEmail(), $usuario->getFechaNacimiento(), $usuario->getId());
        $resultado = MySQLPDO::exec($sql, $params);
        return $resultado;
    }


    public static function updateContra($usuario){
        MySQLPDO::connect();
        $sql = "UPDATE usuario SET hashContra=? WHERE idUsuario=?";
        $params = array($usuario->getHashContra(), $usuario->getId());
        $resultado = MySQLPDO::exec($sql, $params);
        return $resultado;
    }

    public static function verFalta(){
        MySQLPDO::connect();
        $sql = "SELECT idUsuario, nombre, apellido, nombreLogin, email, fechaNacimiento FROM usuario";
        $params = array();
        $resultado = MySQLPDO::select($sql, $params);
        return $resultado;
    }

    public static function obtenerFaltas($pasarid) {
        $sql = "SELECT * FROM registroentradas WHERE idUsuario=?";
        $params = array($pasarid->getId());
        $resultado = MySQLPDO::select($sql, $params);
        if (sizeof($resultado) !=0) { //el id se corresponde a un usuario de BBDD
            extract($resultado[0]); //extrae el primer elemento del arraym y crea vbles de forma automatica
                                    //con el mismo nombre que las columnas de la tabla de BBDD
            $faltas = new entradas();
            $faltas->SetidEntr_Sal($identr_sal);
            $faltas->setidUsuario($idUsuario);
            $faltas->setFecha($fecha);
            $faltas->setHora($hora);
            $faltas->setEntr_Sali($entr_sal);
            return $faltas;
 
        } else { //el id no es valido, no se corresponde con ningun usuario}
           return false;
        }

}
}
?>