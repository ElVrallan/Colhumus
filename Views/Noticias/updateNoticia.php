<link rel="stylesheet" href="./Assets/Css/createNoticia.css">

</head>

<body>
    <div class="form-container">
        <form action="index.php?action=updateNoticia" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= isset($noticia['id']) ? htmlspecialchars($noticia['id']) : '' ?>">

            <div class="form-group">
                <label for="imagen">Imagen</label>
                <input type="file" name="imagen" id="imagen" accept="image/*">
                <p>Si no seleccionas una nueva imagen, se mantendrá la actual.</p>
                <!-- Imagen actual -->
                <img src="./Assets/Images/Noticias/Thumbnail/<?= isset($noticia['imagen']) ? htmlspecialchars($noticia['imagen']) : '' ?>" alt="Imagen actual" style="max-width: 200px;">
            </div>
            <div class="form-group">
                <label for="titulo">Título</label>
                <!-- Título -->
                <input type="text" name="titulo" value="<?= isset($noticia['titulo']) ? htmlspecialchars($noticia['titulo']) : '' ?>" maxlength="100" required>
            </div>
            <div class="form-group">
                <label for="cuerpo">Cuerpo</label>
                <!-- Cuerpo -->
                <textarea name="cuerpo" required><?= isset($noticia['cuerpo']) ? htmlspecialchars($noticia['cuerpo']) : '' ?></textarea>
            </div>
            <div class="form-group checkbox-group">
                <label for="destacada">Destacada</label>
                <!-- Destacada -->
                <input type="checkbox" name="destacada" value="1" <?= (isset($noticia['destacada']) && $noticia['destacada']) ? 'checked' : '' ?>>
            </div>
            <div class="button-group">
                <a href="index.php">
                    <button type="button" class="cancel-button">Cancelar</button>
                </a>
                <button type="submit">Actualizar Noticia</button>
            </div>
        </form>
    </div>
</body>

</html>