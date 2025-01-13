document.addEventListener("DOMContentLoaded", function () {
    const burgerMenu = document.querySelector(".burger-menu");
    const mobileMenuOverlay = document.querySelector(".mobile-menu-overlay");
    const closeMenu = document.querySelector(".close-menu");

    // Ouvrir le menu mobile
    burgerMenu.addEventListener("click", function () {
        mobileMenuOverlay.classList.add("active");
    });

    // Fermer le menu mobile
    closeMenu.addEventListener("click", function () {
        mobileMenuOverlay.classList.remove("active");
    });

    // Fermer le menu en cliquant à l'extérieur
    mobileMenuOverlay.addEventListener("click", function (e) {
        if (e.target === mobileMenuOverlay) {
            mobileMenuOverlay.classList.remove("active");
        }
    });
});
