<?php

require_once './Models/noticiaModel.php';
require_once './Config/conn.php';

class NoticiaController {
    private $noticiaModel;

    public function __construct(){
        global $conn;
        $this->noticiaModel = new NoticiaModel($conn);
    }
    
    public function dashboard(){
        require './Views/dashboard.php';
    }
    
    
    
    public function getNoticiaById($id) {
        if (!isset($id) || !is_numeric($id)) {
            die("Error: ID de noticia inválido.");
        }
        $noticia = $this->noticiaModel->getNoticiaById($id);
        if (!$noticia) {
            die("Error: La noticia no existe.");
        }
        // No obtener ni pasar comentarios aquí, solo retorna la noticia
        return $noticia;
    }
    
    public function deleteComentario() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $comentario_id = $_POST['comentario_id'] ?? null;
        $noticia_id = $_POST['noticia_id'] ?? null;
        $usuario_id = $_SESSION['user_id'] ?? null;

        if ($comentario_id && $usuario_id) {
            // Obtener el comentario para validar el usuario
            $comentario = $this->noticiaModel->obtenerComentario($comentario_id);
            if (!$comentario) {
                header("Location: index.php?action=getNoticiaById&id=" . $noticia_id . "&errorToken=1");
                exit();
            }
            // Solo admin o autor pueden eliminar
            if ($usuario_id == 1 || $usuario_id == $comentario['id_usuario']) {
                // Usa el método eliminarComentario y verifica el resultado (debe devolver true si elimina)
                $resultado = $this->noticiaModel->eliminarComentario($comentario_id);
                if ($resultado) {
                    $this->noticiaModel->restarComentario($comentario['id_publicacion']);
                } else {
                    // Si no se eliminó, muestra error
                    header("Location: index.php?action=getNoticiaById&id=" . $noticia_id . "&errorToken=1");
                    exit();
                }
                header("Location: index.php?action=getNoticiaById&id=" . $noticia_id);
                exit();
            } else {
                header("Location: index.php?action=getNoticiaById&id=" . $noticia_id . "&errorToken=1");
                exit();
            }
        }
        header("Location: index.php?action=getNoticiaById&id=" . $noticia_id);
        exit();
    }

    
    public function getComentarios($id) {
        $id = $_GET['id']?? '';
        $this->noticiaModel->getComentarios($id);
        header("Location: index.php?action=dashboard");
    }
    public function comentar() {
        $noticia_id = $_POST['noticia_id'] ?? null;
        $contenido = $_POST['contenido'] ?? null;
        $usuario_id = $_SESSION['user_id'] ?? null;
    
        if ($usuario_id && $this->noticiaModel->estaBloqueado($usuario_id)) {
            echo "No puedes comentar porque tu usuario está bloqueado.";
            exit();
        }
    
        if ($noticia_id && $contenido && $usuario_id) {
            $this->noticiaModel->guardarComentario($noticia_id, $usuario_id, $contenido);
            $this->noticiaModel->contComentarios($noticia_id); // Incrementa el contador
            header("Location: index.php?action=getNoticiaById&id=" . $noticia_id);
        } else {
            echo "Error al enviar el comentario. Verifica los datos.";
        }
    }


       // Suponiendo que tienes algo así para eliminar un comentario
public function eliminarComentario($comentario_id) {
    session_start(); // para obtener datos de usuario

    $usuario_id = $_SESSION['usuario_id']; 
    $es_admin = $_SESSION['es_admin'] ?? false;

    $resultado = $this->model->deleteComentario($comentario_id, $usuario_id, $es_admin);

    if (!$resultado) {
        // No se pudo borrar (porque no es admin ni dueño del comentario)
        $_SESSION['error'] = "No tienes permisos para realizar esta acción.";
        header("Location: comentarios.php");  // redirige a donde quieras
        exit;
    } else {
        $_SESSION['success'] = "Comentario eliminado correctamente.";
        header("Location: comentarios.php");
        exit;
    }
}

    
    
    public function createNoticia() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Verificar si se subió una imagen correctamente
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $directorioDestino = "./Assets/Images/Noticias/Thumbnail/";
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

    public function updateNoticia() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id         = $_POST['id'];
            $titulo     = $_POST['titulo'];
            $cuerpo     = $_POST['cuerpo'];
            $destacada  = isset($_POST['destacada']) ? 1 : 0; 
    
            // Obtener la noticia actual para mantener la imagen si no se cambia
            $noticiaActual = $this->noticiaModel->getNoticiaById($id);
            $imagen = $noticiaActual['imagen']; // Mantener la imagen actual por defecto
    
            // Manejo de imagen: Si se sube una nueva, reemplazarla
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $directorioDestino = "./Assets/Images/Noticias/Thumbnail/";
                $nombreImagen = basename($_FILES["imagen"]["name"]);
                $rutaCompleta = $directorioDestino . $nombreImagen;
    
                // Mover la imagen al directorio de destino
                if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaCompleta)) {
                    // Eliminar la imagen anterior si existe
                    $rutaImagenAnterior = $directorioDestino . $imagen;
                    if (file_exists($rutaImagenAnterior)) {
                        unlink($rutaImagenAnterior);
                    }
                    $imagen = $nombreImagen; // Actualizar la imagen solo si se subió correctamente
                } else {
                    echo "Error al subir la imagen.";
                    exit;
                }
            }
    
            // Actualizar noticia en la base de datos
            $this->noticiaModel->updateNoticia($id, $imagen, $titulo, $cuerpo, $destacada);
    
            // Redirigir a dashboard
            header("Location: index.php?action=dashboard");
            exit;
        }
    }

    public function deleteNoticia(){
        $id = $_GET['id'] ?? '';
        
        // Obtener la noticia para acceder a la imagen
        $noticia = $this->noticiaModel->getNoticiaById($id);
        if ($noticia && isset($noticia['imagen'])) {
            $rutaImagen = "./Assets/Images/Noticias/Thumbnail/" . $noticia['imagen'];
            
            // Verificar si el archivo existe y eliminarlo
            if (file_exists($rutaImagen)) {
                unlink($rutaImagen);
            }
        }
        
        // Eliminar la noticia de la base de datos
        $this->noticiaModel->deleteNoticia($id);
        header("Location: index.php?action=dashboard");
        exit();
    }

    public function actualizarNoticiaDestacada(){
        $id = $_GET['id']?? '';
        $this->noticiaModel->actualizarNoticiaDestacada($id);
        header("Location: index.php?action=dashboard");
        exit();
    }

    public function contLikes(){
        $id = $_GET['id'] ?? '';
        if (is_numeric($id)) {
            $this->noticiaModel->contLikes($id);
            $noticia = $this->noticiaModel->getNoticiaById($id);
            echo json_encode(['success' => true, 'likes' => $noticia['likes']]);
        } else {
            echo json_encode(['success' => false]);
        }
        exit();
    }

    public function contComentarios(){
        $id = $_GET['id']?? '';
        $this->noticiaModel->contComentarios($id);
    }

    public function contCompartir(){
        $id = $_GET['id'] ?? '';
        if (is_numeric($id)) {
            $this->noticiaModel->contCompartir($id);
            $noticia = $this->noticiaModel->getNoticiaById($id);
            echo json_encode(['success' => true, 'shares' => $noticia['conteo_compartidas']]);
        } else {
            echo json_encode(['success' => false]);
        }
        exit();
    }

    // Bloquear usuario (solo admin)
    public function bloquearUsuario() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
            echo json_encode(['success' => false, 'message' => 'No tienes permisos para realizar esta acción.']);
            exit();
        }
        $usuario_id = $_POST['usuario_id'] ?? null;
        if ($usuario_id) {
            $comentarios = $this->noticiaModel->obtenerNoticiasYConteoPorUsuario($usuario_id);
            $this->noticiaModel->bloquearUsuario($usuario_id);
            $this->noticiaModel->eliminarComentariosDeUsuario($usuario_id);
            foreach ($comentarios as $row) {
                $this->noticiaModel->restarVariosComentarios($row['id_publicacion'], $row['total']);
            }
            echo json_encode(['success' => true]);
            exit();
        } else {
            echo json_encode(['success' => false, 'message' => 'Usuario no válido.']);
            exit();
        }
    }

    // Desbloquear usuario (solo admin)
    public function desbloquearUsuario() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
            echo json_encode(['success' => false, 'message' => 'No tienes permisos para realizar esta acción.']);
            exit();
        }
        $usuario_id = $_POST['usuario_id'] ?? null;
        if ($usuario_id) {
            $this->noticiaModel->desbloquearUsuario($usuario_id);
            echo json_encode(['success' => true]);
            exit();
        } else {
            echo json_encode(['success' => false, 'message' => 'Usuario no válido.']);
            exit();
        }
    }

    public function bloquearUsuarioDirecto($usuario_id) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
            echo "Error: No tienes permisos para realizar esta acción.";
            exit();
        }
        if ($usuario_id) {
            // Antes de eliminar los comentarios, obtener las noticias afectadas y la cantidad de comentarios por noticia
            $comentarios = $this->noticiaModel->obtenerNoticiasYConteoPorUsuario($usuario_id);
            $this->noticiaModel->bloquearUsuario($usuario_id);
            $this->noticiaModel->eliminarComentariosDeUsuario($usuario_id);
            // Disminuir el contador de comentarios en cada noticia afectada
            foreach ($comentarios as $row) {
                $this->noticiaModel->restarVariosComentarios($row['id_publicacion'], $row['total']);
            }
        }
    }

    public function desbloquearUsuarioDirecto($usuario_id) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
            echo "Error: No tienes permisos para realizar esta acción.";
            exit();
        }
        if ($usuario_id) {
            $this->noticiaModel->desbloquearUsuario($usuario_id);
        }
    }

    // Muestra solo la sección de comentarios de una noticia
    public function mostrarComentarios($id) {
        if (!isset($id) || !is_numeric($id)) {
            die("Error: ID de noticia inválido.");
        }
        $noticia = $this->noticiaModel->getNoticiaById($id);
        if (!$noticia) {
            die("Error: La noticia no existe.");
        }
        // Obtener los comentarios y pasarlos a la vista
        $comentarios = $this->noticiaModel->getComentarios($id);
        // Asegúrate de que la vista use $comentarios para mostrar los comentarios
        require './Views/Noticias/showNoticia.php';
    }
}