<?php if (isset($noticia) && $noticia): ?>
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
</style>

<article class="noticia">
    <h1 class="titulo-noticia"> <?= htmlspecialchars($noticia['titulo']); ?> </h1>
    
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

    <div class="estadisticas">
        <span class="iconlike">
            <?= number_format($noticia['likes']); ?>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965..." />
            </svg>
        </span>

        <span class="iconcomment">
            <?= number_format($noticia['conteo_comentarios']); ?>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                <path d="M16 8c0 3.866-3.582 7-8 7a9 9 0 0 1-2.347-.306c..." />
            </svg>
        </span>

        <span class="iconshare">
            <?= number_format($noticia['conteo_compartidas']); ?>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                <path d="M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.5 2.5..." />
            </svg>
        </span>
    </div>
</article>

<?php else: ?>
    <p>No se encontró la noticia.</p>
<?php endif; ?>
