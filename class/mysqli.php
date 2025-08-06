<?php
class MySQLDB {
	private $servidor = "localhost";
	private $usuario = "root";
	private $password = "";
	private $dbname = "manga_db";
	private $conexion;

	public function __construct(){
		$this->conexion = new mysqli(
            $this->servidor,
            $this->usuario,
            $this->password,
            $this->dbname
        );
        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
	}

	public function getConnection(){
        return $this->conexion;
    }
}