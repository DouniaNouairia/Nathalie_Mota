<!-- Lightbox Container -->
<div id="lightbox" class="lightbox-container">
    <!-- Image principale et croix de fermeture -->
    <div class="lightbox-image-container">
        <span id="close-lightbox" class="close-lightbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Close-lightbox.png" alt="Icone de fermeture">
        </span>
        <img id="lightbox-image" src="" alt="Image dans Lightbox" />
    </div>

    <!-- Informations sur la photo -->
    <div class="photo-info-lightbox">
        <div class="photo-meta-lightbox">
            <!-- Référence photo -->
            <div class="photo-ref-lightbox">
                <span id="photo-reference"></span>
            </div>
            <!-- Catégorie photo -->
            <div class="photo-cat-lightbox">
                <span id="photo-category"></span>
            </div>
        </div>
    </div>

    <!-- Navigation: flèches gauche et droite avec texte -->
    <div class="lightbox-navigation">
        <span class="lightbox-nav lightbox-prev">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Nav-left.png" alt="fleche gauche"> Précédent
        </span>
        <span class="lightbox-nav lightbox-next">
            Suivant <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Nav-right.png" alt="fleche droite">
        </span>
    </div>
</div>

