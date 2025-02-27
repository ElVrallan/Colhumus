<?php

require_once '../Models/inicioModel.php';
require_once '../Config/database.php';

class InicioController{
    private $conectar;
    private $inicioModel;

    public function dashboard(){
        require './Views/dashboard.php';
    }

    public function __construct() {
        $database= new Database();
        $this->conectar = $database->conectar();
        $this->inicioModel= new InicioModel($this->conectar);
    }

    public function getNoticiaDestacada(){
        return $this->inicioModel->getNoticiaDestacada();
    }
    
    public function getListaNoticias() {
        return $this->inicioModel->getListaNoticias();
    }

    public function getNoticiaById() {
        $id = $_GET['id'] ?? '';
        return $this->inicioModel->getNoticiaById($id);
    }
}