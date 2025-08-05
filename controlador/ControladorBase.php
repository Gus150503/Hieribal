<?php
abstract class ControladorBase {

    protected function iniciarSesion(): void {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    protected function setSesion(string $clave, mixed $valor): void {
        $this->iniciarSesion();
        $_SESSION[$clave] = $valor;
    }

    protected function getSesion(string $clave): mixed {
        $this->iniciarSesion();
        return $_SESSION[$clave] ?? null;
    }

    protected function eliminarSesion(string $clave): void {
        $this->iniciarSesion();
        unset($_SESSION[$clave]);
    }

    protected function destruirSesion(): void {
        $this->iniciarSesion();
        $_SESSION = [];
        session_destroy();
    }

    protected function redirigir(string $url): never {
        header("Location: $url");
        exit();
    }
}
