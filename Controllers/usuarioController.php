<?php

require_once './Models/usuarioModel.php';
require_once './Config/database.php';
require_once './Helpers/enviarCorreo.php'; // Asegúrate de que esta ruta sea correcta

session_start();

class UsuarioController {
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new UsuarioModel();
    }

    // Acción de login
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = $_POST['correo'] ?? '';
            $contraseña = $_POST['contraseña'] ?? '';
    
            $usuario = $this->usuarioModel->obtenerPorCorreo($correo);
    
            if ($usuario && password_verify($contraseña, $usuario['contraseña']) && !$usuario['bloqueado']) {
                $_SESSION['user_id'] = $usuario['id'];
                $_SESSION['nombre_usuario'] = $usuario['nombre_usuario']; // para mostrar en el navbar
                header("Location: index.php?action=dashboard");
                exit(); // DETIENE la ejecución aquí
            } else {
                // Redirigir con un mensaje de error en la URL (puedes leerlo luego en la vista)
                header("Location: index.php?action=iniciarSesion&popup=login_error");
                exit();
            }
        } else {
            // Mostrar vista de login
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
                header("Location: index.php?action=iniciarSesion&popup=correoDuplicado");
            } else {
                $this->usuarioModel->registrar($nombre, $correo, $contraseña);
                header("Location: index.php?action=iniciarSesion&popup=registroExitoso");
                exit();
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
            
            $link = "http://localhost/proyectos/colhumus/index.php?action=reestablecerContraseña&token=$token";

            if (enviarCorreoRecuperacion($correo, $link)) {
                header("Location: index.php?action=olvideContraseña&popup=correoEnviado");
            } else {
                header("Location: index.php?action=olvideContraseña&popup=correoNoEnviado");
            }
        } else {
            // Por seguridad, no revelar si el correo existe o no
                header("Location: index.php?action=olvideContraseña&popup=correoEnviado");
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
                header("Location: index.php?action=iniciarSesion&popup=contraseñaActualizada");
            } else {
                header("Location: index.php?action=olvideContraseña&popup=errorToken");
            }
        } else {
            include './Views/Includes/navbar.php';
            require __DIR__ . '/../views/usuarios/reestablecerContraseña.php';
        }
    }
}