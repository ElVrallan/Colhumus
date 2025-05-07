<?php

require_once './Models/usuarioModel.php';
require_once './Config/database.php';

class UsuarioController {
    private $conectar;
    private $usuarioController;

    public function login() {
        require './Views/usuarios/login.php';
    }

    public function __construct() {
        $database= new Database();
        $this->conectar = $database->conectar();
        $this->usuarioController= new UsuarioModel($this->conectar);
    }
}