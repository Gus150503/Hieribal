<?php
abstract class ModeloBase {
    protected $pdo;

    public function __construct() {
        require_once __DIR__ . '/../config/conexion.php';
        $this->pdo = (new Conexion())->conectar();
    }

    protected function preparar($sql, $parametros = []) {
        $stmt = $this->pdo->prepare($sql);
        foreach ($parametros as $clave => $valor) {
            $stmt->bindValue($clave, $valor);
        }
        return $stmt;
    }

    protected function obtenerUno($stmt) {
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    protected function ejecutar($stmt) {
        return $stmt->execute();
    }
}
