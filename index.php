<?php

require_once './Controllers/dashboardController.php';
require_once './Controllers/noticiaController.php';
require_once './Controllers/usuarioController.php';

$dashboardController = new DashboardController();
$noticiaController = new NoticiaController();
$usuarioController = new UsuarioController();

$action = $_GET['action'] ?? 'dashboard';

switch ($action) {
    case 'dashboard':
        $noticiaDestacada = $dashboardController->getNoticiaDestacada();
        $listaNoticias = $dashboardController->getListaNoticias();
        require_once './Helpers/helper.php';
        include './Views/Includes/navbar.php';
        include './Views/dashboard.php';
        break;
    case 'acercaDe':
        include './Views/Includes/navbar.php';
        include './Views/acercaDe.php';
        break;
    case 'iniciarSesion':
        include './Views/Includes/navbar.php';
        include './Views/usuarios/login.php';
        break;
    case 'getNoticiaById':
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id = $_GET['id'];
            $noticia = $noticiaController->getNoticiaById($id);
            require_once './Helpers/helper.php';
            include './Views/Includes/navbar.php';
            include './Views/Noticias/showNoticia.php';
        } else {
            echo "Error: ID de noticia no válido.";
        }
        break;
    case 'createNoticia':
        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == 1) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $noticiaController->createNoticia();
            } else {
                include './Views/Includes/navbar.php';
                include './Views/Noticias/createNoticia.php';
            }
        } else {
            echo "Error: No tienes permisos para realizar esta acción.";
        }
        break;
    case 'updateNoticia':
        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == 1) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $noticiaController->updateNoticia();
                include './Views/Includes/navbar.php';
                include './Views/dashboard.php';
            } else {
                if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                    $id = $_GET['id'];
                    $noticia = $noticiaController->getNoticiaById($id);
                    include './Views/Includes/navbar.php';
                    include './Views/Noticias/updateNoticia.php';
                } else {
                    echo "Error: ID de noticia no válido.";
                }
            }
        } else {
            echo "Error: No tienes permisos para realizar esta acción.";
        }
        break;
    case 'deleteNoticia':
        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == 1) {
            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $id = $_GET['id'];
                $noticia = $noticiaController->deleteNoticia($id);
            } else {
                echo "Error: ID de noticia no válido.";
            }
        } else {
            echo "Error: No tienes permisos para realizar esta acción.";
        }
        break;
    case 'contLikes':
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $noticiaController->contLikes();
        } else {
            echo json_encode(['success' => false]);
        }
        break;
    case 'contCompartir':
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $noticiaController->contCompartir();
        } else {
            echo json_encode(['success' => false]);
        }
        break;
    case 'searchNoticias':
        $noticiaDestacada = $dashboardController->getNoticiaDestacada();
        $resultados = $dashboardController->searchNoticias();
        require_once './Helpers/helper.php';
        include './Views/Includes/navbar.php';
        require './Views/Noticias/resultadosBusqueda.php';
        break;
    case 'login':
        $usuarioController->login();
        break;
    case 'registrarse':
        include './Views/Includes/navbar.php';
        include './Views/usuarios/registrarse.php';
        break;
    case 'registrar':
        $usuarioController->registrarse();
        break;
    case 'olvideContraseña':
        include './Views/Includes/navbar.php';
        include './Views/usuarios/olvideContraseña.php';
        break;
    case 'enviarEmail':
        $usuarioController->olvideContraseña();
        break;
    case 'reestablecerContraseña':
        $usuarioController->reestablecerContraseña();
        break;
    case 'logout':
        session_destroy();
        header("Location: index.php?action=dashboard");
        exit();
        break;
    default:
        $noticiaDestacada = $dashboardController->getNoticiaDestacada();
        $listaNoticias = $dashboardController->getListaNoticias();
        require_once './Helpers/helper.php';
        include './Views/Includes/navbar.php';
        include './Views/dashboard.php';
        break;
}
