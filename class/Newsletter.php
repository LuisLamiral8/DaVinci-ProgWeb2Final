<?php
class Newsletter {
	public $id;
	public $email;

	public function __construct($email) {
		$this->email = $email;
	}

	public function save($conexion) {
		$consulta = $conexion->prepare( "INSERT INTO newsletter (email) VALUES (?)");
		$consulta->bind_param("s", $this->email);
		try {
			$resultado = $consulta->execute();
		} catch (mysqli_sql_exception $e) {
			if ($e->getCode() == 1062) {
				$consulta->close();
				return 'duplicate';
			} else {
				$consulta->close();
				return 'error';
			}
		}
		$consulta->close();
		return $resultado;
	}
}