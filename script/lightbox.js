document.addEventListener("DOMContentLoaded", function () {
  const lightbox = document.getElementById("lightbox");
  const lightboxImage = document.getElementById("lightbox-image");
  const photoReference = document.getElementById("photo-reference");
  const photoCategory = document.getElementById("photo-category");
  const closeLightbox = document.getElementById("close-lightbox");
  const prevButton = document.querySelector(".lightbox-prev");
  const nextButton = document.querySelector(".lightbox-next");
  let currentIndex = -1;

  // Fonction pour mettre à jour les données des images
  function updateImageData() {
    return Array.from(document.querySelectorAll(".lightbox")).map((img) => {
      return {
        src: img.getAttribute("data-image"),
        reference:
          img.getAttribute("data-reference") || "Référence non définie",
        category: img.getAttribute("data-category") || "Catégorie non définie",
      };
    });
  }

  let imageData = updateImageData();

  // Fonction pour ouvrir la lightbox
  window.openLightbox = function (index, lightboxElements) {
    if (index < 0) index = lightboxElements.length - 1;
    if (index >= lightboxElements.length) index = 0;
    currentIndex = index;

    const currentElement = lightboxElements[index];
    const src = currentElement.getAttribute("data-image");
    const reference =
      currentElement.getAttribute("data-reference") || "Référence non définie";
    const category =
      currentElement.getAttribute("data-category") || "Catégorie non définie";

    if (!src) {
      console.error("Aucune image valide à afficher.");
      return;
    }

    lightboxImage.src = src;
    photoReference.textContent = reference; // Affiche la référence
    photoCategory.textContent = category; // Affiche la catégorie

    lightbox.classList.add("show");
  };

  // Fonction pour fermer la lightbox
  function closeLightboxFunc() {
    lightbox.classList.remove("show");
    currentIndex = -1;
  }

  // Afficher l'image précédente
  function showPrevImage(lightboxElements) {
    openLightbox(currentIndex - 1, lightboxElements);
  }

  // Afficher l'image suivante
  function showNextImage(lightboxElements) {
    openLightbox(currentIndex + 1, lightboxElements);
  }

  // Gestion des clics sur les miniatures
  document.addEventListener("click", function (e) {
    if (e.target.closest(".lightbox")) {
      const filteredLightboxElements = Array.from(
        document.querySelectorAll(".lightbox")
      );
      const index = filteredLightboxElements.indexOf(
        e.target.closest(".lightbox")
      );
      openLightbox(index, filteredLightboxElements);
    }
  });

  // Evénements de fermeture et navigation
  if (closeLightbox) {
    closeLightbox.addEventListener("click", closeLightboxFunc);
  }

  if (prevButton) {
    prevButton.addEventListener("click", function () {
      const filteredLightboxElements = Array.from(
        document.querySelectorAll(".lightbox")
      );
      showPrevImage(filteredLightboxElements);
    });
  }

  if (nextButton) {
    nextButton.addEventListener("click", function () {
      const filteredLightboxElements = Array.from(
        document.querySelectorAll(".lightbox")
      );
      showNextImage(filteredLightboxElements);
    });
  }

  // Rafraîchissement des données après un filtrage AJAX
  document.addEventListener("ajaxComplete", function () {
    imageData = updateImageData();
    console.log("Données de la lightbox mises à jour :", imageData);
  });
});
