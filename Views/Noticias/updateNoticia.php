    <style>
        body {
            background-color: #A9E159;
            font-family: Arial, sans-serif;
        }

        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
        }

        input,
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
        }

        button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-update {
            background-color: #468704;
            color: white;
        }

        .btn-cancel {
            background-color: #d9534f;
            color: white;
        }
    </style>
    </head>

    <body>
        <div class="form-container">
            <h2>Actualizar Noticia</h2>
            <form action="index.php?action=updateNoticia" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= htmlspecialchars($noticia['id']); ?>">

                <div class="form-group">
                    <label for="titulo">Título:</label>
                    <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($noticia['titulo']); ?>" required>
                </div>

                <label>Imagen:</label>
                <input type="file" name="imagen">
                <p>Si no seleccionas una nueva imagen, se mantendrá la actual.</p>

                <div class="form-group">
                    <label for="cuerpo">Contenido:</label>
                    <textarea id="cuerpo" name="cuerpo" rows="5" required><?= htmlspecialchars($noticia['cuerpo']); ?></textarea>
                </div>

                <label>Destacada:</label>
                <input type="checkbox" name="destacada" value="1" <?= $noticia['destacada'] ? 'checked' : ''; ?>>

                <div class="btn-container">
                    <button type="submit" class="btn-update">Actualizar</button>
                    <a href="index.php" class="btn-cancel">Cancelar</a>
                </div>
            </form>
        </div>
    </body>

    </html>