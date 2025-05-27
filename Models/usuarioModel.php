<?php

class UsuarioModel {
    private $conn;
    private $usuarios = "usuarios";

    public function __construct() {
        $this->conn = Database::conectar();
    }

    public function obtenerPorCorreo($correo) {
        $sql = "SELECT * FROM {$this->usuarios} WHERE correo = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$correo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function registrar($nombre, $correo, $contraseña) {
        $hash = password_hash($contraseña, PASSWORD_BCRYPT);
        $sql = "INSERT INTO {$this->usuarios} (nombre_usuario, correo, contraseña) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$nombre, $correo, $hash]);
    }

    public function actualizarToken($correo, $token, $expira) {
        $sql = "UPDATE {$this->usuarios} SET reset_token = ?, token_expires = ? WHERE correo = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$token, $expira, $correo]);
    }

    public function obtenerPorToken($token) {
        $sql = "SELECT * FROM {$this->usuarios} WHERE reset_token = ? AND token_expires > NOW()";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarContraseña($id, $nuevaContraHash) {
        $sql = "UPDATE {$this->usuarios} SET contraseña = ?, reset_token = NULL, token_expires = NULL WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$nuevaContraHash, $id]);
    }
}
?>