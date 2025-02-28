<?php

require_once './Controllers/dashboardController.php';
require_once './Controllers/noticiaController.php';

$dashboardController = new DashboardController();
$noticiaController = new NoticiaController();

$action = $_GET['action'] ?? 'dashboard';

switch($action){
    case 'dashboard':
        $noticiaDestacada = $dashboardController->getNoticiaDestacada();
        $listaNoticias = $dashboardController->getListaNoticias();
        include './Views/includes/navbar.php';
        include './Views/includes/scrollbar.php';
        include './Views/dashboard.php';
        break;
    case 'getNoticiaById':
        $noticia = $noticiaController->getNoticiaById();
        include './Views/Noticias/Noticia.php';
        break;
    case 'actualizarNoticiaDestacada':
        $noticiaController->actualizarNoticiaDestacada();
        break;
    case 'deleteNoticia':
        $noticiaController->deleteNoticia();
        break;
    case 'addNoticia':
        $noticiaController->addNoticia();
        break;
    case 'editNoticia':
        $noticiaController->editNoticia();
        break;
    case 'comentarios':
        $noticiaController->comentarios();
        break;
    default:
        $noticiaDestacada = $dashboardController->getNoticiaDestacada();
        $listaNoticias = $dashboardController->getListaNoticias();
        include './Views/Includes/navbar.php';
        include './Views/Includes/scrollbar.php';
        include './Views/dashboard.php';
        break;
} 