<?php

require_once './Models/usuarioModel.php';
require_once './Config/database.php';

session_start();

class UsuarioController {
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new UsuarioModel();
    }

    // Acción de login
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = $_POST['correo'];
            $contraseña = $_POST['contraseña'];
            $usuario = $this->usuarioModel->obtenerPorCorreo($correo);

            if ($usuario && password_verify($contraseña, $usuario['contraseña']) && !$usuario['bloqueado']) {
                $_SESSION['user_id'] = $usuario['id'];
                header("Location: index.php?action=dashboard");
                exit();
                

            } else {
                echo "Credenciales inválidas o cuenta bloqueada.";
            }
        } else {
            require __DIR__ . '/../views/usuarios/login.php';
        }
    }

    // Acción de registro
    public function registrarse() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
            $nombre = $_POST['nombre_usuario'];
            $correo = $_POST['correo'];
            $contraseña = $_POST['contraseña'];

            if ($this->usuarioModel->obtenerPorCorreo($correo)) {
                echo "Ya existe un usuario con ese correo.";
            } else {
                $this->usuarioModel->registrar($nombre, $correo, $contraseña);
                echo "Registro exitoso.";
            }
        } else {
            require __DIR__ . '/../views/usuarios/registrarse.php';
        }
    }

    // Acción para recuperar contraseña (olvidé la contraseña)
    public function olvideContraseña() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = $_POST['correo'];
            $usuario = $this->usuarioModel->obtenerPorCorreo($correo);

            if ($usuario) {
                $token = bin2hex(random_bytes(50));
                $expira = date('Y-m-d H:i:s', strtotime('+1 hour'));
                $this->usuarioModel->actualizarToken($correo, $token, $expira);
                
                // Aquí puedes enviar el link por correo
                $link = "http://localhost/index.php?action=reestablecerContraseña&token=$token";
                mail($correo, "Recupera tu contraseña", "Visita este enlace: $link");

                echo "Si el correo existe, se envió un enlace.";
            } else {
                echo "Correo no encontrado.";
            }
        } else {
            require __DIR__ . '/../views/usuarios/olvideContraseña.php';
        }
    }

    // Acción para reestablecer la contraseña
    public function reestablecerContraseña() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['token'];
            $nuevaContraseña = $_POST['contraseña'];
            $usuario = $this->usuarioModel->obtenerPorToken($token);

            if ($usuario) {
                $nuevaContraHash = password_hash($nuevaContraseña, PASSWORD_BCRYPT);
                $this->usuarioModel->actualizarContraseña($usuario['id'], $nuevaContraHash);
                echo "Contraseña actualizada correctamente.";
            } else {
                echo "Token inválido o expirado.";
            }
        } else {
            require __DIR__ . '/../views/usuarios/reestablecerContraseña.php';
        }
    }
}