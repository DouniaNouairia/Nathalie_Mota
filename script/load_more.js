jQuery(document).ready(function ($) {
    let loading = false; // Indique si le chargement est en cours ou non
    const $loadMoreButton = $('#load-more-btn'); // Bouton "Load More"
    const $container = $('.photo-gallery'); // Conteneur des photos
    let page = $('input[name="page"]').val(); // Page actuelle

    // Fonction pour réinitialiser les événements (hover et lightbox)
    function resetLightboxAndHover() {
        // Gestion de la lightbox
        $(".lightbox").off("click").on("click", function (e) {
            e.preventDefault();

            const imageSrc = $(this).data("image");
            const reference = $(this).data("reference");
            const category = $(this).data("category");

            // Implémentez la fonction pour ouvrir la lightbox ici
            openLightboxFromData(imageSrc, reference, category);
        });

        // Gestion du hover
        $(".photo-thumbnail").off("mouseenter mouseleave").hover(
            function () {
                $(this).find(".photo-hover-overlay").fadeIn(200);
            },
            function () {
                $(this).find(".photo-hover-overlay").fadeOut(200);
            }
        );
    }

    // Fonction pour gérer le bouton "Load More"
    $loadMoreButton.on('click', function () {
        if (!loading) {
            loading = true;
            $loadMoreButton.text('Chargement en cours...');

            // Incrémenter la page
            page++;

            $.ajax({
                url: filtres_ajax_params.ajax_url,
                type: 'GET',
                data: {
                    action: 'load_more_posts',
                    page: page,
                    category: $('select[name="category-filter"]').val(),
                    format: $('select[name="format-filter"]').val(),
                    dateSort: $('select[name="date-sort"]').val()
                },
                success: function (response) {
                    if (response && response.posts) {
                        $.each(response.posts, function (index, post) {
                            $container.append(`
                                <div class="photo-item">
                                    <div class="photo-thumbnail">
                                        <img src="${post.image}" alt="${post.title}" />

                                        <!-- Overlay au survol -->
                                        <div class="photo-hover-overlay">
                                            <!-- Icône "oeil" pour la page single -->
                                            <a href="${post.link}" class="photo-icon-center">
                                                <img src="${wp_data.template_url}/assets/images/Icon_eye.png" alt="icône oeil">
                                            </a>

                                            <!-- Icône "plein écran" pour la lightbox -->
                                            <a href="javascript:void(0);" class="lightbox photo-icon-top-right"
                                               data-image="${post.image}"
                                               data-reference="${post.reference || 'Référence non définie'}"
                                               data-category="${post.category || 'Sans catégorie'}">
                                                <img src="${wp_data.template_url}/assets/images/Fullscreen.png" alt="plein écran">
                                            </a>

                                            <!-- Informations au survol -->
                                            <div class="photo-info-hover">
                                                <span class="photo-reference">${post.reference || 'Référence non définie'}</span>
                                                <span class="photo-category">${post.category || 'Sans catégorie'}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `);
                        });

                        // Si moins de 8 photos sont retournées, désactiver le bouton "Load More"
                        if (response.posts.length < 8) {
                            $loadMoreButton.text('Fin des publications').prop('disabled', true);
                        } else {
                            $loadMoreButton.text('Charger plus');
                        }

                        // Réinitialiser les événements
                        resetLightboxAndHover();
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

    // Réinitialiser les événements au chargement initial
    resetLightboxAndHover();
});
