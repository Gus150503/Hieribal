<?php
require_once 'ModeloBase.php';

class ModeloCliente extends ModeloBase {

    public function registrarCliente(array $datos): bool {
        $sql = "INSERT INTO clientes 
                (cedula, nombres, apellidos, telefono, correo, contraseña, token_verificacion, verificado)
                VALUES (:cedula, :nombres, :apellidos, :telefono, :correo, :contrasena, :token, 0)";
        
        $stmt = $this->preparar($sql, [
            ':cedula'     => $datos['cedula'],
            ':nombres'    => $datos['nombres'],
            ':apellidos'  => $datos['apellidos'],
            ':telefono'   => $datos['telefono'],
            ':correo'     => $datos['correo'],
            ':contrasena' => $datos['contraseña'],
            ':token'      => $datos['token']
        ]);

        return $this->ejecutar($stmt);
    }

    public function buscarPorCorreo(string $correo): ?array {
        $sql = "SELECT * FROM clientes WHERE correo = :correo LIMIT 1";
        $stmt = $this->preparar($sql, [':correo' => $correo]);
        return $this->obtenerUno($stmt);
    }

    public function loginCliente(string $correo, string $password): false|array {
        $cliente = $this->buscarPorCorreo($correo);
        if ($cliente && password_verify($password, $cliente['contraseña'])) {
            return $cliente;
        }
        return false;
    }

    public function guardarTokenRecuperacion(string $correo, string $token): bool {
        $sql = "UPDATE clientes SET token_recuperacion = :token WHERE correo = :correo";
        $stmt = $this->preparar($sql, [
            ':token' => $token,
            ':correo' => $correo
        ]);
        return $this->ejecutar($stmt);
    }

    public function buscarPorToken(string $token): ?array {
        $sql = "SELECT * FROM clientes WHERE token_recuperacion = :token LIMIT 1";
        $stmt = $this->preparar($sql, [':token' => $token]);
        return $this->obtenerUno($stmt);
    }

    public function actualizarContraseña(string $correo, string $nueva): bool {
        $sql = "UPDATE clientes SET contraseña = :nueva WHERE correo = :correo";
        $stmt = $this->preparar($sql, [
            ':nueva' => $nueva,
            ':correo' => $correo
        ]);
        return $this->ejecutar($stmt);
    }

    public function registrarClienteGoogle(string $nombre, string $correo): bool {
        $sql = "INSERT INTO clientes 
                (cedula, nombres, apellidos, telefono, correo, contraseña, verificado) 
                VALUES ('', :nombres, '', '', :correo, '', 1)";
        
        $stmt = $this->preparar($sql, [
            ':nombres' => $nombre,
            ':correo'  => $correo
        ]);
        return $this->ejecutar($stmt);
    }

    public function verificarCuenta(string $token): bool {
        $sql = "UPDATE clientes SET verificado = 1, token_verificacion = NULL 
                WHERE token_verificacion = :token";
        $stmt = $this->preparar($sql, [':token' => $token]);
        return $this->ejecutar($stmt);
    }

    public function cedulaExiste(string $cedula): bool {
        $sql = "SELECT 1 FROM clientes WHERE cedula = :cedula LIMIT 1";
        $stmt = $this->preparar($sql, [':cedula' => $cedula]);
        $stmt->execute();
        return $stmt->fetchColumn() !== false;
    }

    public function correoExiste(string $correo): bool {
        $sql = "SELECT 1 FROM clientes WHERE correo = :correo LIMIT 1";
        $stmt = $this->preparar($sql, [':correo' => $correo]);
        $stmt->execute();
        return $stmt->fetchColumn() !== false;
    }
}
