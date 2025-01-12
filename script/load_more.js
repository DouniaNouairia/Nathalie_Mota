console.log('load_more.js chargé');

(function($) {
    let loading = false; // Indique si le chargement est en cours ou non
    const $loadMoreButton = $('#load-more'); // Sélectionne le bouton "Charger plus"
    const $container = $('.photo-gallery'); // Sélectionne le conteneur de vignettes

    $loadMoreButton.on('click', function () {
        get_more_posts(true); // Appelle la fonction pour obtenir plus de publications
    });

    function get_more_posts(load) {
        let inputPage = $('input[name="page"]');
        let page = parseInt(inputPage.val());
        page = load ? page + 1 : 1; // Incrémente le numéro de page si "load" est vrai, sinon réinitialise à 1.
        const category = $('select[name="category-filter"]').val();
        const format = $('select[name="format-filter"]').val();
        const dateSort = $('select[name="date-sort"]').val();

        console.log(category, format, dateSort, page);

        $.ajax({
            type: 'GET',
            url: load_more_params.ajax_url, // Utilise l'URL définie dans wp_localize_script
            data: {
                action: 'load_more_posts',
                page,
                category,
                format,
                dateSort,
                nonce: load_more_params.nonce // Ajoute le nonce pour sécuriser la requête
            },
            success: function (response) {
                if (response) {
                    if (load) {
                        $container.append(response); // Ajoute la réponse (nouvelles publications) au conteneur
                    } else {
                        $container.html(response); // Remplace le contenu du conteneur par la réponse (nouvelles publications)
                    }
                    $loadMoreButton.text('Charger plus'); // Remet le texte du bouton à "Charger plus"
                    inputPage.val(page); // Met à jour le numéro de page
                    loading = false; // Indique que le chargement est terminé
                } else {
                    if (load) {
                        $loadMoreButton.text('Fin des publications'); // Change le texte du bouton en "Fin des publications"
                    } else {
                        let txt = '<div style="text-align:center;width:100%; color: #000;font-family: Space Mono, monospace;font-size: 16px;"><p>Aucun résultat ne correspond aux filtres de recherche.<br>';
                        $container.html(txt); // Affiche un message si aucune réponse n'est trouvée
                    }
                }
            },
            error: function(xhr, status, error) {
                console.log(error); // Affiche l'erreur dans la console
            }
        });

        if (!loading) {
            loading = true;
            $loadMoreButton.text('Chargement en cours...'); // Change le texte du bouton en "Chargement en cours..."
        }
    }

    function recursive_change(selectId) {
        $('#' + selectId).change(function () {
            get_more_posts(false); // Appelle la fonction pour obtenir plus de publications sans "load"
        });
    }

    if ($('#category-filter').length) {
        recursive_change('category-filter'); // Applique la fonction de changement aux filtres de catégorie
    }

    if ($('#format-filter').length) {
        recursive_change('format-filter'); // Applique la fonction de changement aux filtres de format
    }

    if ($('#date-sort').length) {
        recursive_change('date-sort'); // Applique la fonction de changement aux filtres de tri par date
    }
})(jQuery);
