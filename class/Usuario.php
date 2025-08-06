<?php
class Usuario {
    const ROL_USUARIO = 'USUARIO';
    const ROL_ADMIN = 'ADMINISTRADOR';

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

    public static function login($email, $password, $conexion) {
        $consulta = $conexion->prepare('SELECT id, nombre, email, password, rol FROM usuarios WHERE email = ? LIMIT 1');
        $consulta->bind_param('s', $email);
        $consulta->execute();
        $result = $consulta->get_result();
        if ($result && $row = $result->fetch_assoc()) {
            if (password_verify($password, $row['password'])) {
                return $row;
            } else {
                return 'wrong_password';
            }
        } else {
            return 'no_user';
        }
    }

    public static function logout() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }

    public static function getAll($conexion) {
        $usuarios = [];
        $consulta = $conexion->query("SELECT id, nombre, apellido, email, rol FROM usuarios");
        while ($row = $consulta->fetch_assoc()) {
            $usuarios[] = $row;
        }
        return $usuarios;
    }

    public static function deleteById($conexion, $id) {
        $consulta = $conexion->prepare("DELETE FROM usuarios WHERE id = ?");
        $consulta->bind_param("i", $id);
        $resultado = $consulta->execute();
        $consulta->close();
        return $resultado;
    }
}
