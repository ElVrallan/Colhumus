<?php

require_once './Models/dashboardModel.php';
require_once './Config/database.php';

class DashboardController {
    private $conectar;
    private $dashboardController;

    public function dashboard() {
        require './Views/dashboard.php';
    }

    public function __construct() {
        $database= new Database();
        $this->conectar = $database->conectar();
        $this->dashboardController= new DashboardModel($this->conectar);
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
}