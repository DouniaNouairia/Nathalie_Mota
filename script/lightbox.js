document.addEventListener("DOMContentLoaded", function () {
    const lightbox = document.getElementById("lightbox");
    const lightboxImage = document.getElementById("lightbox-image");
    const photoReference = document.getElementById("photo-reference");
    const photoCategory = document.getElementById("photo-category");
    const closeLightbox = document.getElementById("close-lightbox");
    const prevButton = document.querySelector(".lightbox-prev");
    const nextButton = document.querySelector(".lightbox-next");
    let currentIndex = -1;

    // Récupération des images pour la lightbox
    const images = Array.from(document.querySelectorAll(".lightbox"));
    const imageData = images.map((img, index) => {
        const src = img.getAttribute("data-image");
        const reference = img.getAttribute("data-reference") || "Référence non définie";
        const category = img.getAttribute("data-category") || "Catégorie non définie";

        return {
            src: src,
            reference: reference,
            category: category,
        };
    });

    // Ouvrir la lightbox
    function openLightbox(index) {
        if (index < 0 || index >= imageData.length) return;
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

    // Afficher image précédente
    function showPrevImage() {
        if (currentIndex > 0) {
            openLightbox(currentIndex - 1);
        }
    }

    // Afficher image suivante
    function showNextImage() {
        if (currentIndex < imageData.length - 1) {
            openLightbox(currentIndex + 1);
        }
    }

    // Écouteurs d'événements
    images.forEach((img, index) => {
        img.addEventListener("click", () => openLightbox(index));
    });

    closeLightbox.addEventListener("click", closeLightboxFunc);
    prevButton.addEventListener("click", showPrevImage);
    nextButton.addEventListener("click", showNextImage);

    lightbox.addEventListener("click", (e) => {
        if (e.target === lightbox) {
            closeLightboxFunc();
        }
    });

    // Navigation clavier
    document.addEventListener("keydown", (e) => {
        if (!lightbox.classList.contains("show")) return;

        if (e.key === "Escape") {
            closeLightboxFunc();
        } else if (e.key === "ArrowLeft") {
            showPrevImage();
        } else if (e.key === "ArrowRight") {
            showNextImage();
        }
    });
});
