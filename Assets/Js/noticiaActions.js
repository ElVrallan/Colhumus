// Función para dar Like a una noticia
function likeNoticia(id, likeCountId) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `index.php?action=contLikes&id=${id}`, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                // Incrementar el conteo de likes en la noticia destacada
                const likeCountElement = document.getElementById(likeCountId);
                if (likeCountElement) {
                    const likeTextElement = likeCountElement.querySelector('.like-text');
                    if (likeTextElement) {
                        let currentLikes = parseInt(likeTextElement.textContent.replace(/,/g, '')) || 0;
                        likeTextElement.textContent = currentLikes + 1;
                    }
                }

                // Incrementar el conteo de likes en la lista de noticias, excluyendo la destacada
                const regularLikeCountElements = document.querySelectorAll(`#like-count-${id}`);
                regularLikeCountElements.forEach((element) => {
                    if (element !== likeCountElement) { // Evitar duplicar la actualización
                        const likeTextElement = element.querySelector('.like-text');
                        if (likeTextElement) {
                            let currentLikes = parseInt(likeTextElement.textContent.replace(/,/g, '')) || 0;
                            likeTextElement.textContent = currentLikes + 1;
                        }
                    }
                });
            } else {
                alert('Error al dar like.');
            }
        } else {
            console.error('Error en la solicitud AJAX.');
        }
    };
    xhr.onerror = function() {
        console.error('Error de red al intentar dar like.');
    };
    xhr.send();
}

// Función para compartir una noticia
function shareNoticia(id) {
    const url = `http://localhost/proyectos/colhumus/index.php?action=getNoticiaById&id=${id}`;
    const title = "Mira esta noticia interesante";
    const text = "¡Echa un vistazo a esta noticia en nuestro sitio web!";

    if (navigator.share) {
        navigator.share({
            title: title,
            text: text,
            url: url
        }).then(() => {
            console.log('Contenido compartido exitosamente.');
            // Incrementar el conteo de compartidas
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `index.php?action=contCompartir&id=${id}`, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        const shareCountElement = document.getElementById(`share-count-${id}`);
                        const shareText = shareCountElement.querySelector('.share-text');
                        if (shareText) {
                            shareText.textContent = response.shares;
                        }
                    } else {
                        console.error('Error al actualizar el conteo de compartidas.');
                    }
                }
            };
            xhr.send();
        }).catch((error) => {
            console.error('Error al compartir:', error);
        });
    } else {
        alert('La funcionalidad de compartir no está soportada en este navegador.');
    }
}

// Ensure the video enters fullscreen mode correctly
const video = document.querySelector('.noticia-destacada video');
if (video) {
  video.addEventListener('click', () => {
    if (video.requestFullscreen) {
      video.requestFullscreen();
    } else if (video.webkitRequestFullscreen) { // Safari
      video.webkitRequestFullscreen();
    } else if (video.msRequestFullscreen) { // IE/Edge
      video.msRequestFullscreen();
    }
  });
}