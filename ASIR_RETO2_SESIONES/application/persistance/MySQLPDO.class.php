<?php
class MySQLPDO {
    private static $host = "localhost"; //o la IP del servidor de BBBDD remoto
    private static $database = "tienda2122";
    private static $username = "tienda2122";
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
        $stmt = MySQLPDO::$base->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->rowCount();
        return $result; //devuelve el nº de filas afectadas por la sentencia
    }
    
    //ejecuta sentencias SELECT
    public static function select($sql, $params) {
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
        $sql = "SELECT id, nombre, apellido, nombreLogin, email, fechaNacimiento FROM usuario";
        $params = array();
        $resultado = MySQLPDO::select($sql, $params);
        return $resultado;
    }


    public static function constUsu($id){
        $sql = "SELECT * FROM usuario WHERE id = ?";
        $params = array($id);
        $resultado = MySQLPDO::select($sql, $params);

        if(sizeof($resultado) != 0){    
            extract($resultado[0]);
            $usuario = new usuario;
            $usuario->setId($id);
            $usuario ->setNombre($nombre);
            $usuario ->setApellido($apellido);
            $usuario ->setNombreLogin($nombreLogin);
            $usuario ->setEmail($email);
            $usuario ->setFechaNacimiento($fechaNacimiento);
            $usuario ->setHashContra($hashContra);
            return $usuario;
        }else{
            return false;
        }
    }


    public static function updateUsuario($usuario){
        $sql = "UPDATE usuario SET nombre=?, apellido=?, nombreLogin=?, email=?, fechaNacimiento=? WHERE id=?";
        $params = array($usuario->getNombre(), $usuario->getApellido(), $usuario->getNombreLogin(), $usuario->getEmail(), $usuario->getFechaNacimiento(), $usuario->getId());
        $resultado = MySQLPDO::exec($sql, $params);
        return $resultado;
    }


    public static function updateContra($usuario){
        $sql = "UPDATE usuario SET hashContra=? WHERE id=?";
        $params = array($usuario->getHashContra(), $usuario->getId());
        $resultado = MySQLPDO::exec($sql, $params);
        return $resultado;
    }

}
?>