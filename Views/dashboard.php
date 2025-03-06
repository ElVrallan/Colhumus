<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Noticias</title>
    <link rel="stylesheet" href="./Assets/Css/dashboardStyle.css">
</head>

<body>
    <div class="noticia-destacada">
        <!-- Contenido de la noticia destacada -->
    </div>

    <div class="noticias-container">
        <?php foreach ($listaNoticias as $noticia): ?>
        <article class="noticia">
            <div class="imagen-noticia">
                <img src="./Assets/Images/Noticias/Thumbnail/<?= $noticia['imagen']; ?>"
                    alt="<?= $noticia['titulo']; ?>" loading="lazy"
                    onerror="this.onerror=null; this.src='./Assets/Images/default-thumbnail.jpg';">
            </div>

            <div class="contenido-noticia">
                <div class="titulo-noticia">
                    <?= $noticia['titulo']; ?>
                </div>

                <div class="cuerpo-noticia">
                    <?= $noticia['cuerpo']; ?>
                </div>

                <p class="fecha">Publicado el: <?= $noticia['fecha_publicacion']; ?></p>
                <div class="estadisticas">
                    <span class="iconlike"><?= $noticia['likes']; ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-hand-thumbs-up-fill" viewBox="0 0 16 16">
                            <path
                                d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a10 10 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733q.086.18.138.363c.077.27.113.567.113.856s-.036.586-.113.856c-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.2 3.2 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.8 4.8 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z" />
                        </svg>
                    </span>

                    <span class="iconcomment"><?= $noticia['conteo_comentarios']; ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-chat-dots-fill" viewBox="0 0 16 16">
                            <path
                                d="M16 8c0 3.866-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7M5 8a1 1 0 1 0-2 0 1 1 0 0 0 2 0m4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                        </svg>
                    </span>

                    <span class="iconshare"><?= $noticia['conteo_compartidas']; ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-share-fill" viewBox="0 0 16 16">
                            <path
                                d="M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.5 2.5 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5" />
                        </svg>
                    </span>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
</body>

</html>