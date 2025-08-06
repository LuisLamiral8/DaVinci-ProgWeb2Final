<?php
class Usuario {
    public $nombre;
    public $apellido;
    public $dni;
    public $email;
    public $password;
    public $rol;

    public function __construct($nombre, $apellido, $dni, $email, $password, $rol = 'usuario') {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->dni = $dni;
        $this->email = $email;
        $this->password = $password;
        $this->rol = $rol;
    }

    public function save($conexion) {
        // Hashea la contraseña si no está hasheada
        if (strpos($this->password, '$2y$') !== 0) {
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        }
        $consulta = $conexion->prepare("INSERT INTO usuarios (nombre, apellido, dni, email, password, rol) VALUES (?, ?, ?, ?, ?, ?)");
        $consulta->bind_param("ssssss", $this->nombre, $this->apellido, $this->dni, $this->email, $this->password, $this->rol);
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
