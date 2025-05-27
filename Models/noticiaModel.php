<?php
require_once 'Config/Database.php';

class NoticiaModel {

    protected $db;
    private $noticias = "noticias";
    private $comentarios = "comentarios";

    public function __construct(PDO $conexion) {
        $this->db = $conexion;
    }

    public function getNoticiaById($id) {
        $stmt = $this->db->prepare("SELECT * FROM $this->noticias WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getComentarios($id) {
        $query = "SELECT c.id, c.contenido, c.id_usuario, u.nombre_usuario AS usuario
                  FROM comentarios AS c
                  INNER JOIN usuarios AS u ON c.id_usuario = u.id
                  WHERE c.id_publicacion = ?
                  ORDER BY c.id DESC
                  LIMIT 10";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Elimina un comentario si el usuario es autor o admin.
     *
     * @param int $comentario_id ID del comentario a eliminar
     * @return bool True si se eliminó el comentario, false en caso contrario
     */
public function deleteComentario($comentario_id) {
    $query = "DELETE FROM comentarios WHERE id = ?";
    $stmt = $this->db->prepare($query);
    $stmt->execute([$comentario_id]);
    return $stmt->rowCount() > 0;
}


    public function guardarComentario($id_publicacion, $id_usuario, $contenido) {
        $query = "INSERT INTO comentarios (id_publicacion, id_usuario, contenido) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id_publicacion, $id_usuario, $contenido]);
    }

    public function obtenerComentariosPorNoticia($noticia_id) {
        $sql = "SELECT c.*, u.nombre AS autor FROM comentarios c 
                JOIN usuarios u ON c.user_id = u.id 
                WHERE noticia_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$noticia_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function eliminarComentario($comentario_id) {
        $sql = "DELETE FROM comentarios WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$comentario_id]);
    }

    public function obtenerComentario($comentario_id) {
        $sql = "SELECT * FROM comentarios WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$comentario_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createNoticia($imagen, $titulo, $cuerpo, $destacada) {
        if ($destacada) {
            $queryUnsetDestacada = "UPDATE $this->noticias SET destacada = 0 WHERE destacada = 1";
            $this->db->prepare($queryUnsetDestacada)->execute();
        }

        $query = "INSERT INTO $this->noticias 
                  (imagen, titulo, cuerpo, fecha_publicacion, likes, conteo_comentarios, conteo_compartidas, destacada) 
                  VALUES (?, ?, ?, CURDATE(), 0, 0, 0, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$imagen, $titulo, $cuerpo, $destacada]);
    }

    public function updateNoticia($id, $imagen, $titulo, $cuerpo, $destacada) {
        if ($destacada) {
            $queryUnsetDestacada = "UPDATE $this->noticias SET destacada = 0 WHERE destacada = 1";
            $this->db->prepare($queryUnsetDestacada)->execute();
        }

        $query = "UPDATE $this->noticias 
                  SET imagen = ?, titulo = ?, cuerpo = ?, destacada = ? 
                  WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$imagen, $titulo, $cuerpo, $destacada, $id]);
    }

    public function deleteNoticia($id) {
        $query = "DELETE FROM $this->noticias WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id]);
    }

    public function contLikes($id) {
        $query = "UPDATE $this->noticias SET likes = likes + 1 WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id]);
    }

    public function contComentarios($id) {
        $query = "UPDATE $this->noticias SET conteo_comentarios = conteo_comentarios + 1 WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id]);
    }

    public function contCompartir($id) {
        $query = "UPDATE $this->noticias SET conteo_compartidas = conteo_compartidas + 1 WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id]);
    }

    // Bloquear usuario
    public function bloquearUsuario($usuario_id) {
        $query = "UPDATE usuarios SET bloqueado = 1 WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$usuario_id]);
    }

    // Desbloquear usuario
    public function desbloquearUsuario($usuario_id) {
        $query = "UPDATE usuarios SET bloqueado = 0 WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$usuario_id]);
    }

    // Consultar si el usuario está bloqueado
    public function estaBloqueado($usuario_id) {
        $query = "SELECT bloqueado FROM usuarios WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$usuario_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return isset($row['bloqueado']) ? (bool)$row['bloqueado'] : false;
    }

    // Elimina todos los comentarios de un usuario
    public function eliminarComentariosDeUsuario($usuario_id) {
        $query = "DELETE FROM comentarios WHERE id_usuario = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$usuario_id]);
    }

    // Resta 1 al contador de comentarios de una noticia
    public function restarComentario($noticia_id) {
        $query = "UPDATE $this->noticias SET conteo_comentarios = GREATEST(conteo_comentarios - 1, 0) WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$noticia_id]);
    }

    // Resta varios comentarios al contador de una noticia (por ejemplo, al bloquear usuario)
    public function restarVariosComentarios($noticia_id, $cantidad) {
        $query = "UPDATE $this->noticias SET conteo_comentarios = GREATEST(conteo_comentarios - ?, 0) WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$cantidad, $noticia_id]);
    }

    // Obtiene para cada noticia la cantidad de comentarios que hizo un usuario
    public function obtenerNoticiasYConteoPorUsuario($usuario_id) {
        $query = "SELECT id_publicacion, COUNT(*) as total FROM comentarios WHERE id_usuario = ? GROUP BY id_publicacion";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
