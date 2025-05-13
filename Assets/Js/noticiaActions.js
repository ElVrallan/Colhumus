// Función para dar Like a una noticia
function likeNoticia(id, likeCountId) {
  const xhr = new XMLHttpRequest();
  xhr.open("GET", `index.php?action=contLikes&id=${id}`, true);
  xhr.onload = function () {
    if (xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      if (response.success) {
        // Actualizar el conteo de likes en la noticia destacada
        const likeCountElement = document.getElementById(likeCountId);
        if (likeCountElement) {
          const likeTextElement = likeCountElement.querySelector(".like-text");
          if (likeTextElement) {
            likeTextElement.textContent = response.likes; // Mostrar el conteo actualizado desde la base de datos
          }
        }

        // Actualizar el conteo de likes en la lista de noticias, excluyendo la destacada
        const regularLikeCountElements = document.querySelectorAll(
          `#like-count-${id}`
        );
        regularLikeCountElements.forEach((element) => {
          if (element !== likeCountElement) {
            // Evitar duplicar la actualización
            const likeTextElement = element.querySelector(".like-text");
            if (likeTextElement) {
              likeTextElement.textContent = response.likes; // Mostrar el conteo actualizado desde la base de datos
            }
          }
        });
      } else {
        alert("Error al dar like.");
      }
    } else {
      console.error("Error en la solicitud AJAX.");
    }
  };
  xhr.onerror = function () {
    console.error("Error de red al intentar dar like.");
  };
  xhr.send();
}

// Función para compartir una noticia
function shareNoticia(id) {
  const url = `http://localhost/proyectos/colhumus/index.php?action=getNoticiaById&id=${id}`;
  const title = "Mira esta noticia interesante";
  const text = "¡Echa un vistazo a esta noticia en nuestro sitio web!";

  if (navigator.share) {
    navigator
      .share({
        title: title,
        text: text,
        url: url,
      })
      .then(() => {
        console.log("Contenido compartido exitosamente.");
        // Incrementar el conteo de compartidas
        const xhr = new XMLHttpRequest();
        xhr.open("GET", `index.php?action=contCompartir&id=${id}`, true);
        xhr.onload = function () {
          if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
              // Actualizar el conteo de compartidas en la noticia destacada
              const shareCountElementDestacada = document.getElementById(
                `share-count-${id}`
              );
              if (shareCountElementDestacada) {
                const shareTextDestacada = shareCountElementDestacada.querySelector(".share-text");
                if (shareTextDestacada) {
                  shareTextDestacada.textContent = response.shares;
                }
              }

              // Actualizar el conteo de compartidas en la lista de noticias
              const regularShareCountElements = document.querySelectorAll(
                `#share-count-${id}`
              );
              regularShareCountElements.forEach((element) => {
                if (element !== shareCountElementDestacada) {
                  const shareTextElement = element.querySelector(".share-text");
                  if (shareTextElement) {
                    shareTextElement.textContent = response.shares;
                  }
                }
              });
            } else {
              console.error("Error al actualizar el conteo de compartidas.");
            }
          }
        };
        xhr.send();
      })
      .catch((error) => {
        console.error("Error al compartir:", error);
      });
  } else {
    alert("La funcionalidad de compartir no está soportada en este navegador.");
  }
}

// Ensure the video enters fullscreen mode correctly
const video = document.querySelector(".noticia-destacada video");
if (video) {
  video.addEventListener("click", () => {
    if (video.requestFullscreen) {
      video.requestFullscreen();
    } else if (video.webkitRequestFullscreen) {
      // Safari
      video.webkitRequestFullscreen();
    } else if (video.msRequestFullscreen) {
      // IE/Edge
      video.msRequestFullscreen();
    }
  });
}

