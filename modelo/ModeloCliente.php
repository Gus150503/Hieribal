<?php
require_once 'ModeloBase.php';

class ModeloCliente extends ModeloBase
{
    /**
     * Inserta un cliente normal (registro manual).
     * Espera $datos con: cedula, nombres, apellidos, telefono, correo, contraseña (ya hasheada), token
     */
    public function registrarCliente(array $datos): bool
    {
        $sql = "INSERT INTO clientes 
                (cedula, nombres, apellidos, telefono, correo, contraseña, token_verificacion, verificado)
                VALUES (:cedula, :nombres, :apellidos, :telefono, :correo, :contrasena, :token, 0)";

        $stmt = $this->preparar($sql, [
            ':cedula'     => $datos['cedula'] ?? null,
            ':nombres'    => $datos['nombres'] ?? null,
            ':apellidos'  => $datos['apellidos'] ?? null,
            ':telefono'   => $datos['telefono'] ?? null,
            ':correo'     => $datos['correo'] ?? null,
            ':contrasena' => $datos['contraseña'] ?? null, // se asume ya hasheada
            ':token'      => $datos['token'] ?? null,
        ]);

        return $this->ejecutar($stmt);
    }

    /**
     * Devuelve array del cliente o null si no existe.
     */
    public function buscarPorCorreo(string $correo): ?array
    {
        $sql = "SELECT * FROM clientes WHERE correo = :correo LIMIT 1";
        $stmt = $this->preparar($sql, [':correo' => $correo]);
        $row  = $this->obtenerUno($stmt);   // puede ser array|false según tu ModeloBase
        return $row ?: null;                 // <-- normaliza a null
    }

    /**
     * Login por correo/contraseña.
     * Devuelve array del cliente si ok, o false si credenciales inválidas.
     */
    public function loginCliente(string $correo, string $password): false|array
    {
        $cliente = $this->buscarPorCorreo($correo);
        if ($cliente === null) {
            return false;
        }
        // OJO: la columna se llama 'contraseña' en tu BD.
        $hash = $cliente['contraseña'] ?? '';
        if (is_string($hash) && $hash !== '' && password_verify($password, $hash)) {
            return $cliente;
        }
        return false;
    }

    /**
     * Guarda token de recuperación.
     */
    public function guardarTokenRecuperacion(string $correo, string $token): bool
    {
        $sql = "UPDATE clientes SET token_recuperacion = :token WHERE correo = :correo";
        $stmt = $this->preparar($sql, [
            ':token'  => $token,
            ':correo' => $correo,
        ]);
        return $this->ejecutar($stmt);
    }

    /**
     * Busca cliente por token de recuperación. Devuelve array o null.
     */
    public function buscarPorToken(string $token): ?array
    {
        $sql = "SELECT * FROM clientes WHERE token_recuperacion = :token LIMIT 1";
        $stmt = $this->preparar($sql, [':token' => $token]);
        $row  = $this->obtenerUno($stmt);
        return $row ?: null;                 // <-- normaliza a null
    }

    /**
     * Actualiza contraseña (hashea internamente).
     */
    public function actualizarContraseña(string $correo, string $nueva): bool
    {
        $hash = password_hash($nueva, PASSWORD_DEFAULT);

        $sql = "UPDATE clientes SET contraseña = :nueva WHERE correo = :correo";
        $stmt = $this->preparar($sql, [
            ':nueva'  => $hash,
            ':correo' => $correo,
        ]);
        return $this->ejecutar($stmt);
    }

    /**
     * Registro rápido para Google: marca verificado=1 y deja null en campos no obligatorios.
     * Puedes luego permitir que el usuario complete sus datos.
     */
    public function registrarClienteGoogle(string $nombre, string $correo): bool
    {
        $sql = "INSERT INTO clientes 
                (cedula, nombres, apellidos, telefono, correo, contraseña, verificado) 
                VALUES (NULL, :nombres, NULL, NULL, :correo, NULL, 1)";
        // Si tu tabla exige valores no nulos para algunas columnas, ajusta defaults en la BD o aquí.
        $stmt = $this->preparar($sql, [
            ':nombres' => $nombre,
            ':correo'  => $correo,
        ]);
        return $this->ejecutar($stmt);
    }

    /**
     * Verifica cuenta por token de verificación.
     */
    public function verificarCuenta(string $token): bool
    {
        $sql = "UPDATE clientes 
                   SET verificado = 1, token_verificacion = NULL 
                 WHERE token_verificacion = :token";
        $stmt = $this->preparar($sql, [':token' => $token]);
        return $this->ejecutar($stmt);
    }

    /**
     * ¿Existe cédula?
     */
    public function cedulaExiste(string $cedula): bool
    {
        $sql = "SELECT 1 FROM clientes WHERE cedula = :cedula LIMIT 1";
        $stmt = $this->preparar($sql, [':cedula' => $cedula]);
        $stmt->execute();
        return $stmt->fetchColumn() !== false;
    }

    /**
     * ¿Existe correo?
     */
    public function correoExiste(string $correo): bool
    {
        $sql = "SELECT 1 FROM clientes WHERE correo = :correo LIMIT 1";
        $stmt = $this->preparar($sql, [':correo' => $correo]);
        $stmt->execute();
        return $stmt->fetchColumn() !== false;
    }
}
