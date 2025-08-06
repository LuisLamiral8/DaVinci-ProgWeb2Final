<?php
class Novedad {
    public $id;
    public $descripcion;
    public $orden;

    public function __construct($id, $descripcion, $orden) {
        $this->id = $id;
        $this->descripcion = $descripcion;
        $this->orden = $orden;
    }

    public static function getAll($conexion) {
        $novedades = [];
        $consulta = $conexion->query("SELECT id, descripcion, orden FROM novedades ORDER BY orden ASC");
        while ($row = $consulta->fetch_assoc()) {
            $novedades[] = new Novedad($row['id'], $row['descripcion'], $row['orden']);
        }
        return $novedades;
    }

    public static function updateById($conexion, $id, $descripcion, $orden) {
        $consulta = $conexion->prepare("UPDATE novedades SET descripcion = ?, orden = ? WHERE id = ?");
        $consulta->bind_param("sii", $descripcion, $orden, $id);
        $resultado = $consulta->execute();
        $consulta->close();
        return $resultado;
    }
}
