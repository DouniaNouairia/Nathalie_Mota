// // *****MODAL*****

// document.addEventListener('DOMContentLoaded', function () {
    
//     const modal = document.getElementById('modal'); // Modale
//     const openModalTriggers = document.querySelectorAll('.open-contact-modal, .modal_cnt_single_photo'); // "Boutons" pour ouvrir la modale
//     const referenceField = document.getElementById('reference'); // Champ de référence dans la modale
//     const refPhotoElement = document.querySelector('.ref_photo'); // Élément contenant la référence de la photo

//     if (modal) {
//         // Ajouter l'événement à chaque élément déclencheur
//         openModalTriggers.forEach(trigger => {
//             trigger.addEventListener('click', function (e) {
//                 e.preventDefault(); // Empêche le comportement par défaut si c'est un lien
//                 modal.style.display = 'flex'; // Affiche la modale
                

//                 // Récupérer la référence de la photo et l'ajouter au champ de référence
//                 if (refPhotoElement && referenceField) {
//                     const refPhoto = refPhotoElement.innerHTML.trim(); // Contenu de l'élément ref_photo
//                     referenceField.value = refPhoto; // Insère la référence dans le champ
//                 }
//             });
//         });

//         // Fermer la modale en cliquant à l'extérieur
//         modal.addEventListener('click', function (e) {
//             if (e.target === modal) {
//                 modal.style.display = 'none'; // Masque la modale
//             }
//         });
//     }
// });
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('modal'); // Modale
    const openModalTriggers = document.querySelectorAll('.open-contact-modal, .modal_cnt_single_photo'); // "Boutons" pour ouvrir la modale
    const referenceField = document.getElementById('reference'); // Champ de référence dans la modale
    const refPhotoElement = document.querySelector('.ref_photo'); // Élément contenant la référence de la photo
  
    if (modal) {
      // Ajouter l'événement à chaque élément déclencheur
      openModalTriggers.forEach(trigger => {
        trigger.addEventListener('click', function (e) {
          e.preventDefault(); // Empêche le comportement par défaut si c'est un lien
          modal.classList.add('active'); // Ajoute la classe active pour l'ouverture
          modal.classList.remove('closing'); // Retire la classe closing s'il y en avait
  
          // Récupérer la référence de la photo et l'ajouter au champ de référence
          if (refPhotoElement && referenceField) {
            const refPhoto = refPhotoElement.innerHTML.trim(); // Contenu de l'élément ref_photo
            referenceField.value = refPhoto; // Insère la référence dans le champ
          }
        });
      });
  
      // Fermer la modale en cliquant à l'extérieur
      modal.addEventListener('click', function (e) {
        if (e.target === modal) {
          modal.classList.add('closing'); // Ajoute la classe closing pour l'animation de fermeture
          modal.style.pointerEvents = 'none'; // Désactive temporairement les interactions
          setTimeout(() => {
            modal.classList.remove('active', 'closing'); // Retire les classes après l'animation
            modal.style.pointerEvents = ''; // Réactive les interactions
          }, 300); // Durée de l'animation (0.3s)
        }
      });
    }
  });
  