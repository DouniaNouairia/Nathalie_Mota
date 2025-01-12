
jQuery(document).ready(function($) {
    function applyFilters() {
        if (typeof filtres_ajax_params !== 'undefined') {
            // Récupérer les valeurs des filtres
            var category = $('#category-filter').val();
            var format = $('#format-filter').val();
            var date = $('#date-filter').val();

            $.ajax({
                url: filtres_ajax_params.ajax_url,
                type: 'GET',
                data: {
                    action: 'filter_photos',  // Action de filtrage
                    category: category,  // Catégorie sélectionnée
                    format: format,  // Format sélectionné
                    date: date,  // Date sélectionnée
                    nonce: filtres_ajax_params.nonce  // Nonce pour sécuriser la requête
                },
                beforeSend: function() {
                    // Ajouter un indicateur de chargement
                    $(".photo-gallery").html('<p>Chargement...</p>');
                },
                success: function(response) {
                    if (response.success) {
                        // Effacer les anciennes photos de la galerie
                        $(".photo-gallery").html("");

                        // Vérifier si des photos sont renvoyées
                        if (response.data.photos.length > 0) {
                            // Ajouter les nouvelles photos dans la galerie
                            $.each(response.data.photos, function(index, photo) {
                                $(".photo-gallery").append(`
                                    <div class="photo-item">
                                        <div class="photo-thumbnail">
                                            <img src="${photo.image}" alt="" />
                                        </div>
                                    </div>
                                `);
                            });

                            // Réappliquer les styles CSS si nécessaire
                            resetImageStyles();
                        } else {
                            $(".photo-gallery").html('<p>Aucune photo trouvée pour ces critères.</p>');
                        }
                    } else {
                        $(".photo-gallery").html('<p>Une erreur est survenue. Veuillez réessayer.</p>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    $(".photo-gallery").html('<p>Une erreur est survenue lors de la récupération des photos.</p>');
                }
            });
        }
    }

    // Fonction pour réinitialiser les styles des images après filtrage
    function resetImageStyles() {
        $(".photo-thumbnail img").css({
            "width": "100%",
            "height": "100%",
            "object-fit": "cover",
            "transition": "transform 0.3s ease"
        });
    }

    // Appliquer les filtres à chaque changement
    $('#category-filter, #format-filter, #date-filter').on('change', function() {
        applyFilters();
    });
});


