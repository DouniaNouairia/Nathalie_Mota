<div class="photo-item <?php echo (get_query_var('only_image', false)) ? 'related-photo' : ''; ?>">
    <div class="photo-thumbnail">
        <?php if (has_post_thumbnail()) : ?>
            <?php
            // Vérifie si only_image est défini
            $only_image = get_query_var('only_image', false);

            if ($only_image) {
                // Affiche uniquement l'image avec un lien vers la page de l'article
            ?>
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('full'); ?>
                </a>
            <?php
            } else {
                // Affiche le contenu par défaut avec l'overlay
                the_post_thumbnail('full');
            ?>
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
                                        $categories = get_the_terms(get_the_ID(), 'categorie');
                                        echo !empty($categories) && !is_wp_error($categories) ? esc_html($categories[0]->name) : 'Sans catégorie';
                                        ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Fullscreen.png" alt="plein écran">
                    </a>

                    <!-- Informations sur la photo -->
                    <div class="photo-info-hover">
                        <span class="photo-title"><?php echo esc_html(get_the_title(get_the_ID())); ?></span>
                        <span class="photo-category"><?php
                                                        $categories = get_the_terms(get_the_ID(), 'categorie');
                                                        echo !empty($categories) && !is_wp_error($categories) ? esc_html($categories[0]->name) : 'Sans catégorie';
                                                        ?></span>
                    </div>
                </div>
            <?php
            }
            ?>
        <?php else : ?>
            <p>Aucune image disponible.</p>
        <?php endif; ?>
    </div>
</div>