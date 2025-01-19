document.addEventListener("DOMContentLoaded", function () {
    const lightbox = document.getElementById("lightbox");
    const lightboxImage = document.getElementById("lightbox-image");
    const photoReference = document.getElementById("photo-reference");
    const photoCategory = document.getElementById("photo-category");
    const closeLightbox = document.getElementById("close-lightbox");
    const prevButton = document.querySelector(".lightbox-prev");
    const nextButton = document.querySelector(".lightbox-next");
    let currentIndex = -1;

    // Récupération des données des images
    function updateImageData() {
        return Array.from(document.querySelectorAll(".lightbox")).map((img) => {
            return {
                src: img.getAttribute("data-image"),
                reference: img.getAttribute("data-reference") || "Référence non définie",
                category: img.getAttribute("data-category") || "Catégorie non définie",
            };
        });
    }

    let imageData = updateImageData();

    // Ouvrir la lightbox
    function openLightbox(index, lightboxElements) {
        if (index < 0) index = lightboxElements.length - 1; // Boucle infinie
        if (index >= lightboxElements.length) index = 0; // Boucle infinie
        currentIndex = index;

        const currentElement = lightboxElements[index];
        const src = currentElement.getAttribute("data-image");
        const reference = currentElement.getAttribute("data-reference") || "Référence non définie";
        const category = currentElement.getAttribute("data-category") || "Catégorie non définie";

        if (!src) {
            console.error("Aucune image valide à afficher.");
            return;
        }

        lightboxImage.src = src;
        photoReference.textContent = reference;
        photoCategory.textContent = category;

        lightbox.classList.add("show");
    }

    // Fermer la lightbox
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
            const filteredLightboxElements = Array.from(document.querySelectorAll(".lightbox")); // Obtenir les lightboxes visibles
            const index = filteredLightboxElements.indexOf(e.target.closest(".lightbox"));
            openLightbox(index, filteredLightboxElements);
        }
    });

    // Gestion des événements
    if (closeLightbox) {
        closeLightbox.addEventListener("click", closeLightboxFunc);
    }

    if (prevButton) {
        prevButton.addEventListener("click", function() {
            const filteredLightboxElements = Array.from(document.querySelectorAll(".lightbox"));
            showPrevImage(filteredLightboxElements);
        });
    }

    if (nextButton) {
        nextButton.addEventListener("click", function() {
            const filteredLightboxElements = Array.from(document.querySelectorAll(".lightbox"));
            showNextImage(filteredLightboxElements);
        });
    }

    // Mettre à jour les données après un filtrage
    document.addEventListener("ajaxComplete", function () {
        imageData = updateImageData(); // Rafraîchit les données
        console.log("Données de la lightbox mises à jour :", imageData);
    });
});