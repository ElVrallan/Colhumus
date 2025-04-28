<?php

require_once './Controllers/dashboardController.php';
require_once './Controllers/noticiaController.php';

$dashboardController = new DashboardController();
$noticiaController = new NoticiaController();

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
            include './Views/Includes/navbar.php';
            include './Views/Noticias/showNoticia.php';
        } else {
            echo "Error: ID de noticia no válido.";
        }
        break;
    case 'createNoticia':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $noticiaController->createNoticia();
        } else {
            include './Views/Includes/navbar.php';
            include './Views/Noticias/createNoticia.php';
        }
        break;
    case 'updateNoticia':
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
        break;
    case 'deleteNoticia':
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id = $_GET['id'];
            $noticia = $noticiaController->deleteNoticia($id);
        } else {
            echo "Error: ID de noticia no válido.";
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
    default:
        $noticiaDestacada = $dashboardController->getNoticiaDestacada();
        $listaNoticias = $dashboardController->getListaNoticias();
        require_once './Helpers/helper.php';
        include './Views/Includes/navbar.php';
        include './Views/dashboard.php';
        break;
}
