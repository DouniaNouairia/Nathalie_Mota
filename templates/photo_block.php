<!-- Lightbox Container -->
<div id="lightbox" class="lightbox-container">
    <span id="close-lightbox" class="close-lightbox">&times;</span> <!-- Croix de fermeture -->
    <img id="lightbox-image" src="" alt="Image dans Lightbox" />

    <!-- Informations sur la photo -->
    <div class="photo-info-lightbox">
        <span id="photo-reference" class="photo-reference"></span>
        <span id="photo-category" class="photo-category"></span>
    </div>

    <!-- Navigation: flèches gauche et droite avec texte -->
    <span class="lightbox-nav lightbox-prev">
        <i class="fa-solid fa-arrow-left-long"></i> Précédent
    </span>
    <span class="lightbox-nav lightbox-next">
        Suivant <i class="fa-solid fa-arrow-right-long"></i>
    </span>
</div>

<!-- Photo Item avec la possibilité d'ouvrir dans la lightbox -->
<div class="photo-item">
    <div class="photo-thumbnail">
        <?php
        if (has_post_thumbnail()) {
            the_post_thumbnail('full'); // Assurez-vous d'utiliser la taille appropriée
        }
        ?>
        <!-- Icônes et informations au survol -->
        <div class="photo-hover-overlay">
            <!-- Icône pour accéder à la page single -->
            <a href="<?php the_permalink(); ?>" class="photo-icon-center">
                <i class="fa-regular fa-eye"></i>
            </a>

            <!-- Icône pour ouvrir la photo dans une lightbox -->
            <a href="javascript:void(0);" class="lightbox photo-icon-top-right" 
               data-image="<?php the_post_thumbnail_url('full'); ?>" 
               data-reference="<?php echo get_post_meta(get_the_ID(), 'reference', true); ?>" 
               data-category="<?php
                   $categories = wp_get_post_terms(get_the_ID(), 'categorie');
                   echo (!empty($categories)) ? esc_html($categories[0]->name) : 'Sans catégorie';
               ?>">
                <i class="fa-solid fa-expand"></i>
            </a>

            <!-- Informations sur la photo -->
            <div class="photo-info-hover">
                <span class="photo-reference"><?php echo get_post_meta(get_the_ID(), 'reference', true); ?></span>
                <span class="photo-category"><?php
                    $categories = wp_get_post_terms(get_the_ID(), 'categorie');
                    echo (!empty($categories)) ? esc_html($categories[0]->name) : 'Sans catégorie';
                ?></span>
            </div>
        </div>
    </div>
</div>
