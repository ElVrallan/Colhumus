<?php

require_once './Models/noticiaModel.php';
require_once './Config/database.php';

class NoticiaController {
    private $conectar;
    private $noticiaModel;

    public function dashboard(){
        require './Views/dashboard.php';
    }

    public function __construct(){
        $database= new Database();
        $this->conectar = $database->conectar();
        $this->noticiaModel= new NoticiaModel($this->conectar);
    }

    public function getNoticia(){
        $id = $_GET['id'];
        $noticia = $this->noticiaModel->getNoticia($id);
        require './Views/noticia.php';
    }

    public function getComentarios($id) {
        $query = "SELECT c.*, u.nombre AS usuario_nombre
                  FROM comentarios AS c
                  INNER JOIN usuarios AS u ON c.usuario_id = u.id
                  WHERE c.noticia_id = ?
                  ORDER BY c.fecha DESC
                  LIMIT 10";
        
        $stmt = $this->conectar->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetchAll();
    }
    
    public function createNoticia(){
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $imagen     = $_POST['imagen'];
            $titulo     = $_POST['titulo'];
            $cuerpo     = $_POST['cuerpo'];
            $destacada  = $_POST['destacada'];
            $this->noticiaModel->createNoticia($imagen, $titulo, $cuerpo, $destacada);
            header("Location: index.php=dashboard");
        }
    }

    public function updateNoticia(){
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $id         = $_POST['id'];
            $imagen     = $_POST['imagen'];
            $titulo     = $_POST['titulo'];
            $cuerpo     = $_POST['cuerpo'];
            $destacada  = $_POST['destacada'];
            $this->noticiaModel->updateNoticia($id, $imagen, $titulo, $cuerpo, $destacada);
            header("Location: index.php?action=dashboard");
        }
    }

    public function deleteNoticia(){
        $id = $_GET['id'] ?? '';
        $this->noticiaModel->deleteNoticia($id);
    }

    public function actualizarNoticiaDestacada(){
        $id = $_GET['id']?? '';
        $this->noticiaModel->actualizarNoticiaDestacada($id);
        header("Location: index.php?action=dashboard");
    }

    public function contLikes(){
        $id = $_GET['id']?? '';
        $this->noticiaModel->contLikes($id);
    }

    public function contComentarios(){
        $id = $_GET['id']?? '';
        $this->noticiaModel->contComentarios($id);
    }

    public function contCompartir(){
        $id = $_GET['id']?? '';
        $this->noticiaModel->contCompartir($id);
    }
}