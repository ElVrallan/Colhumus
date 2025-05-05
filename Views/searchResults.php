<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda</title>
    <link rel="stylesheet" href="./Assets/Css/dashboardStyle.css">
</head>

<body>
    <h1>Resultados de Búsqueda</h1>
    <div class="noticias-container">
        <?php if (!empty($resultados)): ?>
            <?php foreach ($resultados as $noticia): ?>
                <article class="noticia">
                    <div class="imagen-noticia">
                        <img src="./Assets/Images/Noticias/Thumbnail/<?= htmlspecialchars($noticia['imagen']); ?>" loading="lazy">
                    </div>
                    <div class="contenido-noticia">
                        <div class="titulo-noticia"><?= htmlspecialchars($noticia['titulo']); ?></div>
                        <div class="cuerpo-noticia"><?= htmlspecialchars($noticia['cuerpo']); ?></div>
                        <p class="fecha">Publicado el: <?= htmlspecialchars($noticia['fecha_publicacion']); ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No se encontraron resultados para su búsqueda.</p>
        <?php endif; ?>
    </div>
</body>

</html>
