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
        <?php
      // Función para dividir el texto sin cortar palabras
      function wrapText($text, $maxLength) {
          $words = explode(" ", $text);
          $lines = [];
          $currentLine = "";

          foreach ($words as $word) {
              // Sumar 1 por el espacio si currentLine no está vacío
              if (mb_strlen($currentLine) + mb_strlen($word) + ($currentLine !== "" ? 1 : 0) <= $maxLength) {
                  $currentLine .= ($currentLine ? " " : "") . $word;
              } else {
                  $lines[] = $currentLine;
                  $currentLine = $word;
              }
          }

          if ($currentLine !== "") {
              $lines[] = $currentLine;
          }

          return $lines;
      }

      // Función para formatear el título: se trunca a 77 caracteres (si es muy largo)
      // y se limita visualmente a 2 líneas mediante CSS.
      function formatTitle($title) {
          $maxTitleLength = 77; // Truncamiento a 77 caracteres
          if (mb_strlen($title) > $maxTitleLength) {
              return mb_substr($title, 0, $maxTitleLength) . '...';
          }
          return $title;
      }
    ?>

        <?php foreach ($listaNoticias as $noticia): ?>
        <article class="noticia">
            <!-- Imagen de la noticia -->
            <div class="imagen-noticia">
                <img src="./Assets/Images/Noticias/Thumbnail/<?= $noticia['imagen']; ?>"
                    alt="<?= $noticia['titulo']; ?>" loading="lazy"
                    onerror="this.onerror=null; this.src='./Assets/Images/default-thumbnail.jpg';">
            </div>

            <!-- Contenido de la noticia -->
            <div class="contenido-noticia">
                <!-- Título de la noticia -->
                <h2 class="titulo-noticia">
                    <?= formatTitle($noticia['titulo']); ?>
                </h2>

                <!-- Cuerpo de la noticia dividido en 2 columnas -->
                <div class="cuerpo-noticia">
                    <?php 
              $maxLines = 12;      // Máximo de 12 líneas por columna
              $lineCharLimit = 23; // Límite de caracteres para envolver cada línea
              
              // Dividir el cuerpo en líneas sin cortar palabras
              $lineas = wrapText($noticia['cuerpo'], $lineCharLimit);
              
              // Primera columna: las primeras 12 líneas
              $izquierda = array_slice($lineas, 0, $maxLines);
              
              // Segunda columna: las siguientes 12 líneas
              $derecha = array_slice($lineas, $maxLines, $maxLines);
              
              // Si la segunda columna tiene 12 líneas, truncamos la última:
              if(count($derecha) === $maxLines) {
                  if(mb_strlen($derecha[$maxLines - 1]) > 13) {
                      $derecha[$maxLines - 1] = mb_substr($derecha[$maxLines - 1], 0, -13) . '... Ver más...';
                  } else {
                      $derecha[$maxLines - 1] .= '... Ver más...';
                  }
              }
            ?>

                    <div class="cuerpo-container">
                        <div class="columna-izquierda">
                            <?php foreach ($izquierda as $linea): ?>
                            <p class="linea"><?= $linea; ?></p>
                            <?php endforeach; ?>
                        </div>
                        <div class="columna-derecha">
                            <?php foreach ($derecha as $linea): ?>
                            <p class="linea"><?= $linea; ?></p>
                            <?php endforeach; ?>
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