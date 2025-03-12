    <style>
        .noticia {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 10px;
            background: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        body {
            background-color: #A9E159;
        }

        .titulo-noticia {
            font-size: 2rem;
            color: #333;
            text-align: center;
            margin-bottom: 15px;
        }

        .imagen-noticia img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            object-fit: cover;
        }

        .fecha {
            font-size: 0.9rem;
            color: #666;
            text-align: center;
            margin: 10px 0;
        }

        .cuerpo-noticia {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #444;
            text-align: justify;
        }

        .estadisticas {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 15px;
        }

        .estadisticas span {
            display: flex;
            align-items: center;
            font-size: 1rem;
            color: #333;
            cursor: pointer;
        }

        .estadisticas svg {
            margin-left: 5px;
            width: 18px;
            height: 18px;
            fill: #007bff;
        }

        .floating-buttons {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .floating-button {
            background-color: #468704;
            border: none;
            border-radius: 20px;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .floating-button svg {
            width: 24px;
            height: 24px;
            fill: white;
        }

        .floating-button.delete {
            background-color: #d9534f;
        }
    </style>
    </head>

    <body>
        <?php if (isset($noticia) && $noticia): ?>
            <article class="noticia">
                <h1 class="titulo-noticia"><?= htmlspecialchars($noticia['titulo']); ?></h1>

                <div class="imagen-noticia">
                    <img src="./Assets/Images/Noticias/Thumbnail/<?= htmlspecialchars($noticia['imagen']); ?>"
                        alt="<?= htmlspecialchars($noticia['titulo']); ?>"
                        loading="lazy"
                        onerror="this.onerror=null; this.src='./Assets/Images/default-thumbnail.jpg';">
                </div>

                <p class="fecha">Publicado el: <?= htmlspecialchars($noticia['fecha_publicacion']); ?></p>

                <div class="cuerpo-noticia">
                    <?= nl2br(htmlspecialchars($noticia['cuerpo'])); ?>
                </div>
            </article>
        <?php else: ?>
            <p>No se encontró la noticia.</p>
        <?php endif; ?>

        <div class="floating-buttons">
            <form action="index.php" method="GET">
                <input type="hidden" name="action" value="updateNoticia">
                <input type="hidden" name="id" value="<?= htmlspecialchars($noticia['id']); ?>">
                <button type="submit" class="floating-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                    </svg>
                </button>
            </form>


            <form action="index.php" method="GET">
                <input type="hidden" name="action" value="deleteNoticia">
                <input type="hidden" name="id" value="<?= htmlspecialchars($noticia['id']); ?>">
                <button type="submit" class="floating-button delete">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1z" />
                    </svg>
                </button>
            </form>
        </div>
    </body>

    </html>