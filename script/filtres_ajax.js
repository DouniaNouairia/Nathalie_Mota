jQuery(document).ready(function ($) {
    // Appliquer un style hover pour les options
    $('.custom-select .option').hover(
        function () {
            $(this).css({
                'background-color': '#FFD6D6', // Couleur de fond au survol
                'color': 'black'          // Couleur du texte au survol
            });
        },
        function () {
            if (!$(this).hasClass('selected')) {
                $(this).css({
                    'background-color': '', // Réinitialisation de la couleur de fond
                    'color': ''         // Réinitialisation de la couleur du texte
                });
            }
        }
    );

    // Lorsqu'on clique sur une option
    $('.custom-select .option').on('click', function () {
        var value = $(this).data('value');
        var text = $(this).text();

        // Mettre à jour l'affichage de l'option sélectionnée
        var selectContainer = $(this).closest('.custom-select');
        selectContainer.find('.selected-option').text(text);
        selectContainer.find('.selected-option').data('value', value);

        // Ajouter la classe "selected" à l'option cliquée et la retirer des autres
        $(this).addClass('selected').siblings().removeClass('selected');

        // Réinitialiser les styles des autres options
        $(this).siblings().css({
            'background-color': '', // Réinitialisation des couleurs
            'color': ''
        });

        // Appliquer le style rouge à l'option sélectionnée
        $(this).css({
            'background-color': 'red', // Fond rouge pour l'option sélectionnée
            'color': 'white'            // Texte blanc
        });

        // Fermer la liste déroulante après la sélection
        selectContainer.removeClass('open');

        // Déclencher un changement de valeur pour appliquer les filtres
        selectContainer.trigger('change');
    });

    // Ouvrir/fermer la liste des options au clic sur l'élément sélectionné
    $('.custom-select .selected-option').on('click', function () {
        var selectContainer = $(this).closest('.custom-select');
        $('.custom-select').not(selectContainer).removeClass('open'); // Fermer les autres listes
        selectContainer.toggleClass('open');
    });

    // Fermer la liste déroulante si on clique ailleurs sur la page
    $(document).on('click', function (e) {
        if (!$(e.target).closest('.custom-select').length) {
            $('.custom-select').removeClass('open');
        }
    });

    // Appliquer les filtres (on déclenche l'événement lors du changement)
    function applyFilters() {
        if (typeof filtres_ajax_params !== 'undefined') {
            var category = $('#category-filter .selected-option').data('value');
            var format = $('#format-filter .selected-option').data('value');
            var date = $('#date-filter .selected-option').data('value');

            $.ajax({
                url: filtres_ajax_params.ajax_url,
                type: 'GET',
                data: {
                    action: 'filter_photos',
                    category: category,
                    format: format,
                    date: date,
                    nonce: filtres_ajax_params.nonce,
                },
                beforeSend: function () {
                    $(".photo-gallery").html('<p>Chargement...</p>');
                },
                success: function (response) {
                    if (response.success) {
                        $(".photo-gallery").html(""); // Réinitialiser la galerie

                        if (response.data.photos.length > 0) {
                            // Ajouter les nouvelles photos à la galerie
                            $.each(response.data.photos, function (index, photo) {
                                $(".photo-gallery").append(`
                                    <div class="photo-item">
                                        <div class="photo-thumbnail">
                                            <a href="#" class="lightbox" 
                                               data-image="${photo.image}" 
                                               data-reference="${photo.reference || 'Référence non définie'}" 
                                               data-category="${photo.category || 'Sans catégorie'}">
                                                <img src="${photo.image}" alt="" />
                                            </a>

                                            <!-- Overlay au survol -->
                                            <div class="photo-hover-overlay">
                                                <!-- Icône "oeil" pour la page single -->
                                                <a href="${photo.link}" class="photo-icon-center">
                                                    <img src="${wp_data.template_url}/assets/images/Icon_eye.png" alt="icône oeil">
                                                </a>

                                                <!-- Icône "plein écran" pour la lightbox -->
                                                <a href="javascript:void(0);" class="lightbox photo-icon-top-right"
                                                   data-image="${photo.image}"
                                                   data-reference="${photo.reference || 'Référence non définie'}"
                                                   data-category="${photo.category || 'Sans catégorie'}">
                                                    <img src="${wp_data.template_url}/assets/images/Fullscreen.png" alt="plein écran">
                                                </a>

                                                <!-- Informations au survol -->
                                                <div class="photo-info-hover">
                                                    <span class="photo-reference">${photo.reference || 'Référence non définie'}</span>
                                                    <span class="photo-category">${photo.category || 'Sans catégorie'}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `);
                            });

                            // Réinitialiser les styles d'image
                            resetImageStyles();

                            // Initialiser le hover et la lightbox
                            resetLightboxAndHover();
                        } else {
                            $(".photo-gallery").html('<p>Aucune photo trouvée pour ces critères.</p>');
                        }
                    } else {
                        $(".photo-gallery").html('<p>Une erreur est survenue. Veuillez réessayer.</p>');
                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                    $(".photo-gallery").html('<p>Une erreur est survenue lors de la récupération des photos.</p>');
                },
            });
        }
    }

    // Réinitialiser les styles des images
    function resetImageStyles() {
        $(".photo-thumbnail img").css({
            transform: "", // Réinitialisation de l'effet de zoom
            opacity: "",   // Réinitialisation de l'opacité
        });
    }

    // Réinitialiser les événements pour le hover et la lightbox
    function resetLightboxAndHover() {
        // Réinitialiser les événements pour la lightbox
        $(".lightbox").off("click").on("click", function (e) {
            e.preventDefault();

            const index = $(".lightbox").index(this); // Trouver l'index de l'élément cliqué
            const imageSrc = $(this).data("image");
            const reference = $(this).data("reference");
            const category = $(this).data("category");

            openLightboxFromData(imageSrc, reference, category, index);
        });

        // Réinitialiser les événements pour le hover
        $(".photo-thumbnail").off("mouseenter mouseleave").hover(
            function () {
                $(this).find(".photo-hover-overlay").fadeIn(200);
            },
            function () {
                $(this).find(".photo-hover-overlay").fadeOut(200);
            }
        );
    }

    // Ajouter les événements pour ouvrir la lightbox
    $(".lightbox").on("click", function (e) {
        e.preventDefault();
        console.log("Lightbox cliquée");
        const imageSrc = $(this).data("image");
        const reference = $(this).data("reference");
        const category = $(this).data("category");

        openLightboxFromData(imageSrc, reference, category);
    });

    // Appliquer les filtres à chaque changement
    $('.custom-select').on('change', function () {
        applyFilters();
    });
});
