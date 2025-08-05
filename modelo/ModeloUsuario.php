<?php
require_once 'ModeloBase.php';

class ModeloUsuario extends ModeloBase {

 public function loginUsuario(string $usuario, string $password): false|array {
    $sql = "SELECT * FROM usuarios WHERE usuario = :usuario LIMIT 1";
    $stmt = $this->preparar($sql, [':usuario' => $usuario]);
    $user = $this->obtenerUno($stmt);

    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }

    return false;
}
    

    public function contarUsuarios(): int {
        $sql = "SELECT COUNT(*) FROM usuarios";
        $stmt = $this->preparar($sql);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }


    public function contarUsuariosPorEstado(string $estado): int {
        $sql = "SELECT COUNT(*) FROM usuarios WHERE LOWER(estado) = LOWER(:estado)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':estado' => $estado]);
        return (int) $stmt->fetchColumn();
    }



    public function contarUsuariosPorRol($rol) {
        $sql = "SELECT COUNT(*) as total FROM usuarios WHERE rol = :rol";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':rol', $rol);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }


    public function buscarPorCorreo(string $correo): false|array {
    $correo = strtolower(trim($correo));  // Asegura limpieza
    $sql = "SELECT * FROM usuarios WHERE LOWER(TRIM(correo)) = :correo LIMIT 1";
    $stmt = $this->preparar($sql, [':correo' => $correo]);
    return $this->obtenerUno($stmt);
    }



    public function guardarTokenRecuperacion(int $id_usuario, string $token): void {
        $sql = "UPDATE usuarios SET token_recuperacion = :token WHERE id_usuario = :id";
        $this->preparar($sql, [':token' => $token, ':id' => $id_usuario])->execute();
    }

    public function verificarToken(string $token): false|array {
    $sql = "SELECT * FROM usuarios WHERE token_recuperacion = :token LIMIT 1";
    $stmt = $this->preparar($sql, [':token' => $token]);
    return $this->obtenerUno($stmt);
}


public function actualizarContraseñaConToken(string $token, string $nueva): void {
    $nuevaHash = password_hash($nueva, PASSWORD_BCRYPT);
    $sql = "UPDATE usuarios SET password = :password WHERE token_recuperacion = :token";
    $stmt = $this->preparar($sql, [
        ':password' => $nuevaHash,
        ':token' => $token
    ]);
    $stmt->execute();
}


public function listarUsuarios(): array {
    $sql = "SELECT id_usuario, usuario, rol, nombres, apellidos, correo, estado FROM usuarios";
    $stmt = $this->preparar($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function actualizarEstado(int $id_usuario, string $estado): bool {
    $sql = "UPDATE usuarios SET estado = :estado WHERE id_usuario = :id";
    $stmt = $this->preparar($sql, [
        ':estado' => $estado,
        ':id' => $id_usuario
    ]);
    return $stmt->execute();
}


public function actualizarUsuario(array $datos): bool {
    $sql = "UPDATE usuarios SET 
                usuario = :usuario, 
                rol = :rol, 
                nombres = :nombres, 
                apellidos = :apellidos, 
                correo = :correo 
            WHERE id_usuario = :id";

    $stmt = $this->preparar($sql, [
        ':usuario'   => $datos['usuario'],
        ':rol'       => $datos['rol'],
        ':nombres'   => $datos['nombres'],
        ':apellidos' => $datos['apellidos'],
        ':correo'    => $datos['correo'],
        ':id'        => $datos['id_usuario']
    ]);

    return $stmt->execute();
}

public function usuarioExisteEdit(string $usuario, int $excluirId = 0): bool {
    $sql = "SELECT COUNT(*) FROM usuarios WHERE usuario = :usuario AND id_usuario != :id";
    $stmt = $this->preparar($sql, [':usuario' => $usuario, ':id' => $excluirId]);
    return $stmt->fetchColumn() > 0;
}

public function eliminarUsuario(int $id): bool {
    $sql = "DELETE FROM usuarios WHERE id_usuario = :id";
    $stmt = $this->preparar($sql, [':id' => $id]);
    return $stmt->execute();
}


public function crearUsuario(array $datos): bool {
    $sql = "INSERT INTO usuarios (usuario, nombres, apellidos, correo, rol, password, estado) 
            VALUES (:usuario, :nombres, :apellidos, :correo, :rol, :password, :estado)";
    $stmt = $this->preparar($sql, $datos);
    return $stmt->execute();
}

public function usuarioExiste(string $usuario): bool {
    $sql = "SELECT COUNT(*) FROM usuarios WHERE usuario = :usuario";
    $stmt = $this->preparar($sql, [':usuario' => $usuario]);
    return $stmt->fetchColumn() > 0;
}


public function correoExiste(string $correo): bool {
    $sql = "SELECT COUNT(*) FROM usuarios WHERE correo = :correo";
    $stmt = $this->preparar($sql, [':correo' => $correo]);
    return $stmt->fetchColumn() > 0;
}

    
}


