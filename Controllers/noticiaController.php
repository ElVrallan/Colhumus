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

    public function getNoticiaById($id) {
        if (!isset($id) || !is_numeric($id)) {
            die("Error: ID de noticia inválido.");
        }
    
        $noticia = $this->noticiaModel->getNoticiaById($id);
    
        if (!$noticia) {
            die("Error: La noticia no existe.");
        }
    
        return $noticia; // ✅ Devolver la noticia
    }
    
    

    public function getComentarios($id) {
        $id = $_GET['id']?? '';
        $this->noticiaModel->getComentarios($id);
        header("Location: index.php?action=dashboard");
    }
    
    public function createNoticia() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Verificar si se subió una imagen correctamente
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $directorioDestino = "Assets/Images/Noticias/Thumbnail/";
                $nombreImagen = basename($_FILES["imagen"]["name"]);
                $rutaCompleta = $directorioDestino . $nombreImagen;
    
                // Mover la imagen al directorio de destino
                if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaCompleta)) {
                    echo "Imagen subida con éxito.";
                } else {
                    echo "Error al subir la imagen.";
                    exit; // Detener el proceso si la imagen no se pudo subir
                }
            } else {
                echo "Error: No se seleccionó ninguna imagen.";
                exit;
            }
    
            // Obtener otros campos del formulario
            $titulo    = $_POST['titulo'] ?? '';
            $cuerpo    = $_POST['cuerpo'] ?? '';
            $destacada = isset($_POST['destacada']) ? 1 : 0;
    
            // Llamar al modelo para insertar los datos en la base de datos
            $this->noticiaModel->createNoticia($nombreImagen, $titulo, $cuerpo, $destacada);
    
            // Redirigir a dashboard
            header("Location: index.php?dashboard");
            exit;
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