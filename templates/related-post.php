<section class="related-photos">
    <h3>VOUS AIMEREZ AUSSI</h3>
    <div class="related-photos-wrapper">
        <?php
        // Récupérer les catégories associées à la photo actuelle
        $categories = wp_get_post_terms(get_the_ID(), 'categorie', array('fields' => 'ids'));

        if ($categories) {
            $args = array(
                'post_type'      => 'photo',
                'posts_per_page' => 2, // Limiter à 2 photos
                'post__not_in'   => array(get_the_ID()), // Exclure la photo actuelle
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'categorie',
                        'field'    => 'term_id',
                        'terms'    => $categories,
                    ),
                ),
            );

            $related_photos = new WP_Query($args);

            if ($related_photos->have_posts()) :
                while ($related_photos->have_posts()) : $related_photos->the_post(); ?>
                    <div class="related-photo">
                        <a href="<?php the_permalink(); ?>">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium', ['class' => 'related-photo-img']); ?>
                            <?php else : ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/default-photo.jpg" alt="Photo par défaut" class="related-photo-img">
                            <?php endif; ?>
                        </a>
                    </div>
                <?php endwhile;
                wp_reset_postdata();
            else : ?>
                <p>Aucune photo apparentée trouvée.</p>
            <?php endif;
        } else {
            echo '<p>Aucune catégorie associée.</p>';
        }
        ?>
    </div>
</section>
