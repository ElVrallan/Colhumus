    <style>
        .form-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input, textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #468704;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #356503;
        }
    </style>
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
                <input type="text" name="titulo" id="titulo" required>
            </div>
            <div class="form-group">
                <label for="cuerpo">Cuerpo</label>
                <textarea name="cuerpo" id="cuerpo" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" name="destacada" value="1"> Destacada
                </label>
            </div>
            <button type="submit">Subir Noticia</button>
        </form>
    </div>
</body>
</html>
