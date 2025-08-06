<?php
class Contact {
    public $id;
    public $motivo;
    public $nombre;
    public $email;
    public $telefono;
    public $comentario;
    public $fecha;

    public function __construct($motivo, $nombre, $email, $telefono, $comentario) {
        $this->motivo = $motivo;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->telefono = $telefono;
        $this->comentario = $comentario;
    }

    public function save($conexion) {
        $consulta = $conexion->prepare("INSERT INTO contactos (motivo, nombre, email, telefono, comentario) VALUES (?, ?, ?, ?, ?)");
        $consulta->bind_param("sssss", $this->motivo, $this->nombre, $this->email, $this->telefono, $this->comentario);
        $resultado = $consulta->execute();
        $consulta->close();
        return $resultado;
    }
}
