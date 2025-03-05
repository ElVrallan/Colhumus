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

                <p class="fecha"><?= $noticia['fecha_publicacion']; ?></p>
                <div class="estadisticas">
                    <span>Likes: <?= $noticia['likes']; ?></span>
                    <span>Comentarios: <?= $noticia['conteo_comentarios']; ?></span>
                    <span>Compartidas: <?= $noticia['conteo_compartidas']; ?></span>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
</body>

</html>