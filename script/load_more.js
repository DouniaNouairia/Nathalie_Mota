jQuery(document).ready(function ($) {
    let loading = false; // Indique si le chargement est en cours ou non
    const $loadMoreButton = $('#load-more-btn'); // Sélectionne le bouton "Charger plus"
    const $container = $('.photo-gallery'); // Sélectionne le conteneur des photos
    let page = $('input[name="page"]').val(); // Récupère la page à partir du champ caché

    $loadMoreButton.on('click', function () {
        if (!loading) {
            loading = true;  // Met le drapeau de chargement à true pour empêcher les clics multiples
            $loadMoreButton.text('Chargement en cours...');
            
            // On incrémente la page pour charger la page suivante
            page++;

            $.ajax({
                url: filtres_ajax_params.ajax_url,
                type: 'GET',
                data: {
                    action: 'load_more_posts', // Action AJAX dans functions.php
                    page: page, // Page suivante
                    category: $('select[name="category-filter"]').val(), // Filtre catégorie
                    format: $('select[name="format-filter"]').val(), // Filtre format
                    dateSort: $('select[name="date-sort"]').val() // Filtre tri
                },
                success: function (response) {
                    if (response && response.posts) {
                        // Ajoute les nouvelles photos à la galerie
                        $.each(response.posts, function (index, post) {
                            $container.append(`
                                <div class="photo-item">
                                    <img class="photo-thumbnail" src="${post.image}" alt="${post.title}">
                                </div>
                            `);
                        });

                        // Si plus de photos sont disponibles, on met à jour la page et le texte du bouton
                        $('input[name="page"]').val(page);
                        if (response.posts.length < 8) {
                            $loadMoreButton.text('Fin des publications').prop('disabled', true); // Plus de photos à charger
                        } else {
                            $loadMoreButton.text('Charger plus');
                        }
                    } else {
                        $loadMoreButton.text('Fin des publications').prop('disabled', true);
                    }
                    loading = false;
                },
                error: function () {
                    $loadMoreButton.text('Erreur, essayez de nouveau').prop('disabled', false);
                    loading = false;
                }
            });
        }
    });
});