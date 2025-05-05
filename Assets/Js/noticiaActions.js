// Función para dar Like a una noticia
function likeNoticia(id, likeCountId) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `index.php?action=contLikes&id=${id}`, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                const likeCountElement = document.getElementById(likeCountId);
                const likeText = likeCountElement.querySelector('.like-text');
                if (likeText) {
                    likeText.textContent = response.likes;
                }
            } else {
                alert('Error al dar like.');
            }
        }
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
