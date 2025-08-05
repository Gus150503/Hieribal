<?php
class Conexion {
    private $host = "localhost";
    private $db = "hieribal"; 
    private $usuario = "root";
    private $password = "";
    private $conexion;

    public function conectar() {
        try {
            $this->conexion = new PDO("mysql:host={$this->host};dbname={$this->db};charset=utf8", $this->usuario, $this->password);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conexion;
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            return false;
        }
    }
}
