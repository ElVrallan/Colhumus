<link rel="stylesheet" href="./Assets/Css/createNoticia.css">

</head>
<body>
    <div class="form-container">
        <form action="index.php?action=updateNoticia" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= htmlspecialchars($noticia['id']); ?>">

            <div class="form-group">
                <label for="imagen">Imagen</label>
                <input type="file" name="imagen" id="imagen" accept="image/*">
                <p>Si no seleccionas una nueva imagen, se mantendrá la actual.</p>
            </div>
            <div class="form-group">
                <label for="titulo">Título</label>
                <input type="text" name="titulo" id="titulo" value="<?= htmlspecialchars($noticia['titulo']); ?>" required>
            </div>
            <div class="form-group">
                <label for="cuerpo">Cuerpo</label>
                <textarea name="cuerpo" id="cuerpo" required oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px';"><?= htmlspecialchars($noticia['cuerpo']); ?></textarea>
                <script>
                    // Adjust the height of the textarea dynamically based on its content
                    document.addEventListener('DOMContentLoaded', function() {
                        const cuerpoTextarea = document.getElementById('cuerpo');
                        cuerpoTextarea.style.height = cuerpoTextarea.scrollHeight + 'px';
                    });
                </script>
            </div>
            <div class="form-group checkbox-group">
                <label for="destacada">Destacada</label>
                <input type="checkbox" name="destacada" id="destacada" value="1" <?= $noticia['destacada'] ? 'checked' : ''; ?>>
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