<?php

require_once './Models/dashboardModel.php';
require_once './Config/database.php';

class DashboardController{
    private $conectar;
    private $dashboardController;

    public function dashboard(){
        require './Views/dashboard.php';
    }

    public function __construct() {
        $database= new Database();
        $this->conectar = $database->conectar();
        $this->dashboardController= new DashboardModel($this->conectar);
    }

    public function getNoticiaDestacada(){
        return $this->dashboardController->getNoticiaDestacada();
    }
    
    public function getListaNoticias(){
        return $this->dashboardController->getListaNoticias();
    }

    public function getNoticiaById(){
        $id = $_GET['id'] ?? '';
        return $this->dashboardController->getNoticiaById($id);
    }

    public function abreviacionNumerica(){
        return $this->dashboardController->abreviacionNumerica();
    }

    function abbreviateNumber($number) {
    $number = (int)$number;
    if ($number > 999) {
        $abrev = substr((string)$number, 0, 2);
        $result = implode(',', str_split($abrev));
        if ($number > 999999999) {
            $result .= ' B';
        } elseif ($number > 999999) {
            $result .= ' M';
        } elseif ($number > 999) {
            $result .= 'K';
        }
        return $result;
    } else {
        return $number;
    }
}

}