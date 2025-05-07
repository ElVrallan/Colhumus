<?php

class UsuarioModel{

    private $conn;
    private $usuarios = "usuarios";

    public function __construct($conectar){
        $this->conn = Database::conectar();
    }
    
}
?>