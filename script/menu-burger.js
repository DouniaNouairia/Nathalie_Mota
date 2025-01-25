document.addEventListener("DOMContentLoaded", function () {
  const burgerOpen = document.querySelector(".Burger-open");
  const burgerClose = document.querySelector(".Burger-close");
  const mobileMenuOverlay = document.querySelector(".mobile-menu-overlay");

  // Ouvrir le menu
  burgerOpen.addEventListener("click", function () {
      mobileMenuOverlay.classList.add("active"); // Active l'overlay
      burgerOpen.style.display = "none"; // Cache l'icône burger
      burgerClose.style.display = "block"; // Affiche la croix
  });

  // Fermer le menu
  burgerClose.addEventListener("click", function () {
      mobileMenuOverlay.classList.remove("active"); // Désactive l'overlay
      burgerOpen.style.display = "block"; // Affiche l'icône burger
      burgerClose.style.display = "none"; // Cache la croix
  });
});