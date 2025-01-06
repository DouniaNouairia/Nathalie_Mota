document.addEventListener('DOMContentLoaded', function () {
    // Sélectionner l'élément de menu et la modale
    const modal = document.getElementById('modal');
    const openModalTrigger = document.querySelector('.open-contact-modal');
    
    if (modal && openModalTrigger) {
        // Ouvrir la modale au clic sur l'élément de menu
        openModalTrigger.addEventListener('click', function (e) {
            e.preventDefault(); // Empêche le comportement par défaut du lien
            modal.style.display = 'flex'; // Affiche la modale
        });

        // Fermer la modale en cliquant à l'extérieur du contenu
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                modal.style.display = 'none'; // Masque la modale
            }
        });
    }
});

