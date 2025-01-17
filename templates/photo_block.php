<div class="photo-item">
    <div class="photo-thumbnail">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('full'); // Afficher la vignette avec la taille appropriée ?>
        <?php endif; ?>

        <!-- Icônes et informations au survol -->
        <div class="photo-hover-overlay">
            <!-- Icône pour accéder à la page single -->
            <a href="<?php the_permalink(); ?>" class="photo-icon-center">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Icon_eye.png" alt="icône oeil">
            </a>

            <!-- Icône pour ouvrir la photo dans une lightbox -->
            <a href="javascript:void(0);" class="lightbox photo-icon-top-right"
               data-image="<?php the_post_thumbnail_url('full'); ?>"
               data-reference="<?php echo esc_attr(get_post_meta(get_the_ID(), 'reference', true)); ?>"
               data-category="<?php
                   $categories = wp_get_post_terms(get_the_ID(), 'categorie');
                   echo !empty($categories) ? esc_html($categories[0]->name) : 'Sans catégorie';
               ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Fullscreen.png" alt="plein ecran">
            </a>

            <!-- Informations sur la photo -->
            <div class="photo-info-hover">
                <span class="photo-reference"><?php echo esc_html(get_post_meta(get_the_ID(), 'reference', true)); ?></span>
                <span class="photo-category"><?php
                    $categories = wp_get_post_terms(get_the_ID(), 'categorie');
                    echo !empty($categories) ? esc_html($categories[0]->name) : 'Sans catégorie';
                ?></span>
            </div>
        </div>
    </div>
</div>
