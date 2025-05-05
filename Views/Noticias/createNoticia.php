<link rel="stylesheet" href="./Assets/Css/createNoticia.css">

</head>
<body>
    <div class="form-container">
        <form action="index.php?action=createNoticia" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="imagen">Imagen</label>
                <input type="file" name="imagen" id="imagen" accept="image/*" required>
            </div>
            <div class="form-group">
                <label for="titulo">Título</label>
                <input type="text" name="titulo" id="titulo" placeholder="Ingrese el título de la noticia" required>
            </div>
            <div class="form-group">
                <label for="cuerpo">Cuerpo</label>
                <textarea name="cuerpo" id="cuerpo" placeholder="Escriba el contenido de la noticia aquí" required oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px';"></textarea>
            </div>
            <div class="form-group checkbox-group">
                <label for="destacada">Destacada</label>
                <input type="checkbox" name="destacada" id="destacada" value="1">
            </div>
            <div class="button-group">
                <a href="index.php">
                    <button type="button" class="cancel-button">Cancelar</button>
                </a>
                <button type="submit">Subir Noticia</button>
            </div>
        </form>
    </div>
</body>
</html>
