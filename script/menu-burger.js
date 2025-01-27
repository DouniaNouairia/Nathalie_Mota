document.addEventListener("DOMContentLoaded", function () {
  const burgerOpen = document.querySelector(".Burger-open");
  const burgerClose = document.querySelector(".Burger-close");
  const mobileMenuOverlay = document.querySelector(".mobile-menu-overlay");

  // Ouvrir le menu
  burgerOpen.addEventListener("click", function () {
    mobileMenuOverlay.classList.add("active"); // Active l'overlay
    mobileMenuOverlay.classList.remove("closing"); // S'assure qu'on enlève la classe de fermeture
    burgerOpen.style.display = "none"; // Cache l'icône burger
    burgerClose.style.display = "block"; // Affiche la croix
  });

  // Fermer le menu
  burgerClose.addEventListener("click", function () {
    mobileMenuOverlay.classList.remove("active"); // Désactive l'overlay
    mobileMenuOverlay.classList.add("closing"); // Ajoute l'animation de fermeture
    burgerOpen.style.display = "block"; // Affiche l'icône burger
    burgerClose.style.display = "none"; // Cache la croix
  });

  // Supprime la classe "closing" après l'animation
  mobileMenuOverlay.addEventListener("transitionend", function () {
    if (mobileMenuOverlay.classList.contains("closing")) {
      mobileMenuOverlay.classList.remove("closing");
    }
  });
});
