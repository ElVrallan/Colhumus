<link rel="stylesheet" href="./Assets/Css/showNoticia.css">
<script src="./Assets/Js/noticiaActions.js" defer></script>
<?php require_once __DIR__ . '/../../Helpers/helper.php'; ?>


<body>
<?php include './Views/Includes/navbar.php'; ?>

    <!-- Elimina el botón de gestionar usuarios aquí, ya que solo debe ir in la página principal (dashboard) -->

    <?php if (isset($noticia) && $noticia): ?>
    <article class="noticia">
        <h1 class="titulo-noticia"><?= htmlspecialchars($noticia['titulo']); ?></h1>

        <div class="imagen-noticia">
            <?php if (!empty($noticia['imagen']) && pathinfo($noticia['imagen'], PATHINFO_EXTENSION) === 'mp4'): ?>
            <video controls width="100%" height="auto" style="border-radius: 8px; object-fit: cover;">
                <source src="./Assets/Images/Noticias/Thumbnail/<?= htmlspecialchars($noticia['imagen']); ?>"
                    type="video/mp4">
                Tu navegador no soporta la reproducción de videos.
            </video>
            <?php elseif (!empty($noticia['imagen'])): ?>
            <img src="./Assets/Images/Noticias/Thumbnail/<?= htmlspecialchars($noticia['imagen']); ?>"
                alt="<?= htmlspecialchars($noticia['titulo']); ?>" loading="lazy">
            <?php else: ?>
            <p>Imagen no disponible.</p>
            <?php endif; ?>
        </div>

        <p class="fecha">Publicado el: <?= htmlspecialchars($noticia['fecha_publicacion']); ?></p>
        <div class="texto-audio">
            Leer noticia:
            <button class="leer" onclick="leerNoticia()">🔊 Escuchar</button>
            <button class="detener" onclick="detenerLectura()">⏹️ Detener</button>
        </div>
        <div class="cuerpo-noticia">
            <div class="visualmente-oculto">Colhumus, regeneración de suelos</div>
            <?= nl2br(htmlspecialchars($noticia['cuerpo'])); ?>
        </div>

        <div class="estadisticas">
            <span class="iconlike" id="like-count-<?= htmlspecialchars($noticia['id']); ?>">
                <span class="like-text"><?= abbreviateNumber($noticia['likes']); ?></span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-hand-thumbs-up-fill" viewBox="0 0 16 16">
                    <path
                        d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a10 10 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733q.086.18.138.363c.077.27.113.567.113.856s-.036.586-.113.856c-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.2 3.2 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.8 4.8 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z" />
                </svg>
            </span>

            <span class="iconcomment" id="comentarios-count-<?= htmlspecialchars($noticia['id']); ?>">
                <span class="comentarios-text" id="comentarios-text"><?= abbreviateNumber($noticia['conteo_comentarios']); ?></span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-chat-dots-fill" viewBox="0 0 16 16">
                    <path
                        d="M16 8c0 3.866-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7M5 8a1 1 0 1 0-2 0 1 1 0 0 0 2 0m4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                </svg>
            </span>
            <span class="iconshare" id="share-count-<?= htmlspecialchars($noticia['id']); ?>">
                <span class="share-text"><?= abbreviateNumber($noticia['conteo_compartidas']); ?></span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-share-fill" viewBox="0 0 16 16">
                    <path
                        d="M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.5 2.5 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5" />
                </svg>
            </span>
        </div>
        <div class="accion-buttons">
            <!-- Botón de Like -->
            <button class="accion-button" type="button"
                onclick="likeNoticia(<?= htmlspecialchars($noticia['id']); ?>, 'like-count-<?= htmlspecialchars($noticia['id']); ?>')">
                Like
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-hand-thumbs-up" viewBox="0 0 16 16">
                    <path
                        d="M8.864.046C7.908-.193 7.02.53 6.956 1.466c-.072 1.051-.23 2.016-.428 2.59-.125.36-.479 1.013-1.04 1.639-.557.623-1.282 1.178-2.131 1.41C2.685 7.288 2 7.87 2 8.72v4.001c0 .845.682 1.464 1.448 1.545 1.07.114 1.564.415 2.068.723l.048.03c.272.165.578.348.97.484.397.136.861.217 1.466.217h3.5c.937 0 1.599-.477 1.934-1.064a1.86 1.86 0 0 0 .254-.912c0-.152-.023-.312-.077-.464.201-.263.38-.578.488-.901.11-.33.172-.762.004-1.149.069-.13.12-.269.159-.403.077-.27.113-.568.113-.857 0-.288-.036-.585-.113-.856a2 2 0 0 0-.138-.362 1.9 1.9 0 0 0 .234-1.734c-.206-.592-.682-1.1-1.2-1.272-.847-.282-1.803-.276-2.516-.211a10 10 0 0 0-.443.05 9.4 9.4 0 0 0-.062-4.509A1.38 1.38 0 0 0 9.125.111zM11.5 14.721H8c-.51 0-.863-.069-1.14-.164-.281-.097-.506-.228-.776-.393l-.04-.024c-.555-.339-1.198-.731-2.49-.868-.333-.036-.554-.29-.554-.55V8.72c0-.254.226-.543.62-.65 1.095-.3 1.977-.996 2.614-1.708.635-.71 1.064-1.475 1.238-1.978.243-.7.407-1.768.482-2.85.025-.362.36-.594.667-.518l.262.066c.16.04.258.143.288.255a8.34 8.34 0 0 1-.145 4.725.5.5 0 0 0 .595.644l.003-.001.014-.003.058-.014a9 9 0 0 1 1.036-.157c.663-.06 1.457-.054 2.11.164.175.058.45.3.57.65.107.308.087.67-.266 1.022l-.353.353.353.354c.043.043.105.141.154.315.048.167.075.37.075.581 0 .212-.027.414-.075.582-.05.174-.111.272-.154.315l-.353.353.353.354c.047.047.109.177.005.488a2.2 2.2 0 0 1-.505.805l-.353.353.353.354c.006.005.041.05.041.17a.9.9 0 0 1-.121.416c-.165.288-.503.56-1.066.56z" >
                    </button>

            

<!-- Botón para mostrar el formulario de comentarios -->
<button id="btn-comentar" class="accion-button" type="button" onclick="mostrarFormularioComentarioPersonalizado()">
    Comentar
</button>

<!-- Modal -->
<div id="modal-comentario" class="modal oculto">
    <div class="modal-contenido">
        <span class="cerrar" onclick="cerrarFormularioComentario()">&times;</span>
        <h3>Agregar un comentario</h3>
        <?php
        // Solo afecta la acción de comentar, no el login ni navegación
        $usuario_bloqueado = false;
        if (isset($_SESSION['user_id'])) {
            try {
                $pdo = new PDO('mysql:host=localhost;dbname=colhumus;charset=utf8', 'root', ''); // Ajusta usuario/clave si es necesario
                $stmt = $pdo->prepare("SELECT bloqueado FROM usuarios WHERE id = ?");
                $stmt->execute([$_SESSION['user_id']]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $usuario_bloqueado = isset($row['bloqueado']) && $row['bloqueado'] == 1;
            } catch (Exception $e) {
                $usuario_bloqueado = false;
            }
        }
        ?>
        <?php if ($usuario_bloqueado): ?>
            <div style="color: red; margin-bottom: 10px;">No puedes comentar porque tu usuario está bloqueado.</div>
        <?php else: ?>
            <form id="form-comentario">
                <input type="hidden" name="noticia_id" value="<?= htmlspecialchars($noticia['id'] ?? '') ?>">
                <textarea name="contenido" id="contenido-comentario" rows="4" required maxlength="500" placeholder="Escribe tu comentario..." style="width: 100%;"></textarea><br>
                <div id="contador-caracteres" style="font-size: 0.9em; color: #666; text-align: right;">0/500</div>
                <div id="advertencia-caracteres" style="color: red; display: none; margin-bottom: 8px;">No se permite más de 500 caracteres.</div>
                <button class="accion-button" type="submit">Enviar comentario</button>
            </form>
            <div id="mensaje-exito" style="display:none; color: green; margin-top: 10px;">
                ¡Comentario enviado con éxito!
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function mostrarFormularioComentario() {
    document.getElementById('modal-comentario').classList.remove('oculto');
}


function cerrarFormularioComentario() {
    document.getElementById('modal-comentario').classList.add('oculto');
}

// Evitar que se recargue la página al enviar
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form-comentario');
    const textarea = document.getElementById('contenido-comentario');
    const advertencia = document.getElementById('advertencia-caracteres');
    const contador = document.getElementById('contador-caracteres');

    textarea.addEventListener('input', function () {
        const longitud = textarea.value.length;
        contador.textContent = longitud + "/500";
        if (longitud > 500) {
            advertencia.style.display = 'block';
        } else {
            advertencia.style.display = 'none';
        }
    });

    form.addEventListener('submit', function (e) {
        if (textarea.value.length > 500) {
            advertencia.style.display = 'block';
            e.preventDefault();
            return false;
        }

        e.preventDefault(); // 💡 Esto evita la recarga

        const formData = new FormData(form);

        fetch('index.php?action=comentar', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            // Mostrar mensaje de éxito
            document.getElementById('mensaje-exito').style.display = 'block';

            // Limpiar textarea
            form.reset();

            // Cerrar el modal y recargar la página inmediatamente
            cerrarFormularioComentario();
            document.getElementById('mensaje-exito').style.display = 'none';
            location.reload(); // Recarga la página para mostrar el nuevo comentario
        })
        .catch(error => {
            alert("Error al enviar el comentario");
            console.error(error);
        });
    });

    <?php if (isset($usuario_bloqueado) && $usuario_bloqueado): ?>
        var btnComentar = document.getElementById('btn-comentar');
        if (btnComentar) btnComentar.disabled = true;
    <?php endif; ?>
});

// Cambia la función para mostrar el modal o alerta según el estado de bloqueo
function mostrarFormularioComentarioPersonalizado() {
    <?php if (!isset($_SESSION['user_id'])): ?>
        Swal.fire({
            icon: 'warning',
            title: 'Debes iniciar sesión para esta acción',
            text: 'Por favor, inicia sesión para poder comentar.',
            confirmButtonText: 'Aceptar'
        });
    <?php elseif (isset($usuario_bloqueado) && $usuario_bloqueado): ?>
        Swal.fire({
            icon: 'error',
            title: 'Usuario bloqueado',
            text: 'No puedes comentar porque tu usuario está bloqueado.',
            confirmButtonText: 'Aceptar'
        });
    <?php else: ?>
        mostrarFormularioComentario();
    <?php endif; ?>
}
</script>





            <!-- Botón de Compartir -->
            <button class="accion-button" type="button"
                onclick="shareNoticia(<?= htmlspecialchars($noticia['id']); ?>)">
                Compartir
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-share"
                    viewBox="0 0 16 16">
                    <path
                        d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.5 2.5 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5m-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3m11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3" />
                </svg>
            </button>
        </div>
    </article>

    <!-- Sección de Comentarios -->
    <div class="comentarios-container">
        <h3>Comentarios</h3>
        <div id="contador-comentarios" style="font-weight:bold;margin-bottom:10px;">
            Total: <span id="comentarios-total"><?= (int)$noticia['conteo_comentarios'] ?></span>
        </div>
        <?php if (!empty($comentarios)): ?>
            <?php foreach ($comentarios as $comentario): ?>
                <div class="comentario" style="position:relative; min-height:70px;" id="comentario-<?= htmlspecialchars($comentario['id']) ?>">
                    <div style="width:100%;">
                        <strong><?= htmlspecialchars($comentario["usuario"] ?? 'Usuario') ?>:</strong><br>
                    </div>
                    <div style="width:100%;">
                        <span
                            style="
                                display:block;
                                word-break:break-word;
                                overflow-wrap:break-word;
                                white-space:normal;
                                width: 100%;
                                font-size:1.1rem;
                                color:#333;
                                min-height:48px;
                                padding:10px 2px 10px 2px;
                                background:transparent;
                                margin-left:auto;
                                margin-right:auto;
                            ">
                            <?= isset($comentario["contenido"]) ? htmlspecialchars($comentario["contenido"]) : "Contenido no disponible"; ?>
                        </span>
                        <?php
                            $esAdmin = isset($_SESSION['user_id']) && $_SESSION['user_id'] == 1;
                            $esAutor = isset($_SESSION['user_id']) && isset($comentario['id_usuario']) && $_SESSION['user_id'] == $comentario['id_usuario'];
                            $usuarioBloqueado = isset($comentario['usuario_bloqueado']) && $comentario['usuario_bloqueado'];
                        ?>
                        <?php if ($esAdmin && isset($comentario['id_usuario'])): ?>
                            <!-- Botón de bloquear/desbloquear usuario eliminado -->
                        <?php endif; ?>
                        <?php if ($esAdmin || $esAutor): ?>
                            <div style="width:100%; text-align:right; margin-top:12px;">
                                <form method="POST" action="index.php?action=deleteComentario"
                                      style="display:inline-block;"
                                      onsubmit="return confirmarEliminarComentarioAjax(this, event, <?= htmlspecialchars($comentario['id']) ?>);">
                                    <input type="hidden" name="comentario_id" value="<?= htmlspecialchars($comentario['id']) ?>">
                                    <input type="hidden" name="noticia_id" value="<?= htmlspecialchars($noticia['id']) ?>">
                                    <button type="submit" class="accion-button"
                                            style="background:#d9534f;padding:4px 10px;">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay comentarios aún.</p>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    function confirmarEliminarComentarioAjax(form, event, comentarioId) {
        event.preventDefault();
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¿Deseas eliminar este comentario?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // AJAX para eliminar sin recargar toda la página
                const formData = new FormData(form);
                fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(() => {
                    // Elimina el comentario del DOM
                    const comentarioDiv = document.getElementById('comentario-' + comentarioId);
                    if (comentarioDiv) comentarioDiv.remove();
                    // Disminuye el contador de comentarios en la vista
                    const totalSpan = document.getElementById('comentarios-total');
                    if (totalSpan) {
                        let total = parseInt(totalSpan.textContent, 10);
                        if (total > 0) totalSpan.textContent = total - 1;
                    }
                    // Actualiza el contador de la burbuja de comentarios en la barra de estadísticas
                    const comentariosText = document.getElementById('comentarios-text');
                    if (comentariosText) {
                        let total = parseInt(comentariosText.textContent.replace(/\D/g, ''), 10);
                        if (isNaN(total)) total = 0;
                        if (total > 0) comentariosText.textContent = total - 1;
                    }
                })
                .catch(() => {
                    Swal.fire('Error', 'No se pudo eliminar el comentario.', 'error');
                });
            }
        });
        return false;
    }
    </script>
    <?php else: ?>
    <?php endif; ?>



    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == 1): ?>
    <div class="floating-buttons">
        <form action="index.php" method="GET">
            <input type="hidden" name="action" value="updateNoticia">
<input type="hidden" name="id" value="<?= htmlspecialchars($noticia['id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
            <button type="submit" class="floating-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-pencil-square" viewBox="0 0 16 16">
                    <path
                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                    <path fill-rule="evenodd"
                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                </svg>
            </button>
        </form>


        <form action="index.php" method="GET" id="deleteNoticiaForm">
            <input type="hidden" name="action" value="deleteNoticia">
<input type="hidden" name="id" value="<?= htmlspecialchars($noticia['id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
            <button type="button" class="floating-button delete" onclick="confirmDeleteNoticia()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash"
                    viewBox="0 0 16 16">
                    <path
                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                    <path
                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 1 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1z" />
                </svg>
            </button>
        </form>
    </div>
    <?php endif; ?>



</body>

<script>
let speech;

function leerNoticia() {
    // Usa innerText para obtener solo el texto visible de la noticia
    const cuerpo = document.querySelector(".cuerpo-noticia");
    let textoVisible = cuerpo ? cuerpo.innerText : '';
    // Si hay texto oculto, lo añade
    const textoOculto = document.querySelector(".visualmente-oculto")?.innerText || "";
    const contenido = (textoVisible + " " + textoOculto).trim();

    // Detiene cualquier lectura previa
    window.speechSynthesis.cancel();

    if (contenido.length === 0) {
        Swal.fire('Aviso', 'No hay contenido para leer.', 'info');
        return;
    }

    speech = new SpeechSynthesisUtterance(contenido);
    speech.lang = "es-ES";
    window.speechSynthesis.speak(speech);
}

function detenerLectura() {
    window.speechSynthesis.cancel();
}

// Detiene la voz al salir de la página
window.addEventListener("beforeunload", function() {
    window.speechSynthesis.cancel();
});

function confirmDeleteNoticia() {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¿Deseas eliminar esta noticia?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('deleteNoticiaForm').submit();
        }
    });
}

// Confirmación con SweetAlert para eliminar comentario
function confirmarEliminarComentario(event) {
    event.preventDefault();
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¿Deseas eliminar este comentario?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            event.target.form.submit();
        }
    });
    return false;
}

// Mostrar alerta si hay errorToken en la URL
document.addEventListener('DOMContentLoaded', function () {
    // Verifica si existe el parámetro errorToken en la URL
    const params = new URLSearchParams(window.location.search);
    if (params.get('errorToken')) {
        Swal.fire({
            title: 'Error',
            text: '¡Codigo invalido o expirado!',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    }
});
</script>
</body>
</html>