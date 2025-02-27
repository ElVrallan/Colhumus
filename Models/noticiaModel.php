<?php

class NoticiaModel{

    private $conn;
    private $noticias = "noticias";
    private $comentarios = "comentarios";

    public function __construct($conectar){
        $this->conn = Database::conectar();
    }

    public function getNoticia($id){
        $stmt = $this->conn->prepare("SELECT * FROM $this->noticias WHERE id =? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getComentarios($id){
        $stmt = $this->conn->prepare("SELECT * FROM $this->comentarios WHERE id_noticia =? ORDER BY fecha_creacion DESC LIMIT 10");
        $stmt->execute([$id]);
        return $stmt->fetchAll();
    }

    public function createNoticia($imagen, $titulo, $cuerpo, $destacada) {
        $query = "INSERT INTO ".$this->noticias." 
                  (imagen, titulo, cuerpo, fecha_publicacion, likes, conteo_comentarios, conteo_compartidas, destacada) 
                  VALUES (?, ?, ?, ?, 0, 0, 0, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$imagen, $titulo, $cuerpo, $destacada]);
    }

    public function updateNoticia($id, $imagen, $titulo, $cuerpo, $destacada) {
        $query = "UPDATE " . $this->noticias . " 
                  SET imagen = ?, titulo = ?, cuerpo = ?, destacada = ? 
                  WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$imagen, $titulo, $cuerpo, $destacada, $id]);
    } 
    
    public function deleteNoticia($id) {
        $query = "DELETE FROM " . $this->noticias . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }

    public function actualizarNoticiaDestacada($id) {
        $this->conn->beginTransaction();
        try {
            $queryDesactivar = "UPDATE " . $this->noticias . " SET destacada = 0 WHERE destacada = 1";
            $stmtDesactivar = $this->conn->prepare($queryDesactivar);
            $stmtDesactivar->execute();
    
            $queryActivar = "UPDATE " . $this->noticias . " SET destacada = 1 WHERE id = ?";
            $stmtActivar = $this->conn->prepare($queryActivar);
            $stmtActivar->execute([$id]);
    
            $this->conn->commit();
        } catch (Exception $e) {
            // Si hay un error, revertir la transacción
            $this->conn->rollBack();
            throw $e;
        }
    }
    
    public function contLikes($id) {
        $query = "UPDATE " . $this->noticias . " SET likes = likes + 1 WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
    
    public function contComentarios($id) {
        $query = "UPDATE " . $this->noticias . " SET conteo_comentarios = conteo_comentarios + 1 WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }

    public function contCompartir($id) {
        $query = "UPDATE " . $this->noticias . " SET conteo_compartidas = conteo_compartidas + 1 WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
?>