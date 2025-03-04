<!DOCTYPE html>
<html lang="en">

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
        <?php foreach($listaNoticias as $noticia): ?>
        <article class="noticia">
            <!-- Imagen de la noticia -->
            <div class="imagen-noticia">
                <img src="./Assets/Images/Noticias/Thumbnail/<?= $noticia['imagen']; ?>"
                    alt="<?= $noticia['titulo']; ?>" loading="lazy"
                    onerror="this.onerror=null; this.src='./Assets/Images/default-thumbnail.jpg';">
            </div>
            <!-- Contenido de la noticia -->
            <div class="contenido-noticia">
                <h2 class="titulo-noticia"><?= $noticia['titulo']; ?></h2>

                <!-- Cuerpo del texto -->
                <div class="cuerpo-noticia">
                    <?php 
            // Configuración
            $lineCharCount = 36; // Cada "línea" se corta a 36 caracteres
            $maxLines = 12;      // Se mostrarán 12 líneas en cada columna
            $truncLimit = 23;    // En la última línea de la columna derecha se trunca a 23 caracteres

            $cuerpo = $noticia['cuerpo'];

            // Dividir el texto en "chunks" de 36 caracteres (sin respetar palabras)
            $chunks = str_split($cuerpo, $lineCharCount);

            // Columna izquierda: primeros 12 chunks
            $izquierda = array_slice($chunks, 0, $maxLines);
            while(count($izquierda) < $maxLines){
              $izquierda[] = "";
            }

            // Columna derecha: el resto (máximo 12 líneas)
            $restChunks = array_slice($chunks, $maxLines);
            $derecha = array_slice($restChunks, 0, $maxLines);
            while(count($derecha) < $maxLines){
              $derecha[] = "";
            }
            // Truncar la última línea de la columna derecha si es necesario
            if(mb_strlen($derecha[$maxLines-1]) > $truncLimit){
              $derecha[$maxLines-1] = mb_substr($derecha[$maxLines-1], 0, $truncLimit) . '... Ver más...';
            }
          ?>
                    <div class="cuerpo-container">
                        <div class="columna-izquierda">
                            <?php for($i = 0; $i < $maxLines; $i++): ?>
                            <p class="linea"><?= $izquierda[$i] ?></p>
                            <?php endfor; ?>
                        </div>
                        <div class="divisor">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 40" preserveAspectRatio="none">
                                <rect x="3.33" width="3.33" height="40" rx="1.665" fill="#000" />
                            </svg>
                        </div>
                        <div class="columna-derecha">
                            <?php for($i = 0; $i < $maxLines; $i++): ?>
                            <p class="linea"><?= $derecha[$i] ?></p>
                            <?php endfor; ?>
                        </div>
                    </div>
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