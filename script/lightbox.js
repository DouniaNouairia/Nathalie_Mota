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
    function openLightbox(index) {
        if (index < 0) index = imageData.length - 1; // Boucle infinie
        if (index >= imageData.length) index = 0; // Boucle infinie
        currentIndex = index;

        const { src, reference, category } = imageData[currentIndex];

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
    function showPrevImage() {
        openLightbox(currentIndex - 1);
    }

    // Afficher l'image suivante
    function showNextImage() {
        openLightbox(currentIndex + 1);
    }

    // Gestion des clics sur les miniatures
    document.addEventListener("click", function (e) {
        if (e.target.closest(".lightbox")) {
            const index = Array.from(document.querySelectorAll(".lightbox")).indexOf(e.target.closest(".lightbox"));
            openLightbox(index);
        }
    });

    // Gestion des événements
    if (closeLightbox) {
        closeLightbox.addEventListener("click", closeLightboxFunc);
    }

    if (prevButton) {
        prevButton.addEventListener("click", showPrevImage);
    }

    if (nextButton) {
        nextButton.addEventListener("click", showNextImage);
    }

    // Mettre à jour les données après chargement ou filtrage
    document.addEventListener("ajaxComplete", function () {
        imageData = updateImageData();
    });
});
