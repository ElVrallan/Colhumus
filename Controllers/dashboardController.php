<?php

require_once './Models/dashboardModel.php';
require_once './Config/conn.php';

class DashboardController {
    private $dashboardController;

    public function dashboard() {
        require './Views/dashboard.php';
    }

    public function __construct() {
        global $conn;
        $this->dashboardController = new DashboardModel($conn);
    }

    public function getNoticiaDestacada() {
        return $this->dashboardController->getNoticiaDestacada();
    }

    public function getListaNoticias() {
        return $this->dashboardController->getListaNoticias();
    }

    public function getNoticiaById() {
        $id = $_GET['id'] ?? '';
        return $this->dashboardController->getNoticiaById($id);
    }

    public function searchNoticias() {
        $query = $_GET['query'] ?? '';
        return $this->dashboardController->searchNoticias($query);
    }
}