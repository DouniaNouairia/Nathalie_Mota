<section class="related-photos">
    <h3>VOUS AIMEREZ AUSSI</h3>
    <div class="related-photos-wrapper">
        <?php
        // Récupérer les catégories associées à l'article actuel
        $categories = wp_get_post_terms(get_the_ID(), 'categorie', array('fields' => 'ids'));

        if (!empty($categories)) {
            // Arguments de la requête pour récupérer les articles liés
            $args = array(
                'post_type'      => 'photo',
                'posts_per_page' => 2, // Limiter à 2 articles liés
                'post__not_in'   => array(get_the_ID()), // Exclure l'article actuel
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
                while ($related_photos->have_posts()) : $related_photos->the_post();
                    // Passer une variable pour désactiver l'overlay dans photoblock.php
                    set_query_var('only_image', true);
                    get_template_part('templates/photo_block');
                endwhile;
                // Réinitialiser les données globales après la boucle
                wp_reset_postdata();
            else :
                echo '<p>Aucune photo apparentée trouvée.</p>';
            endif;
        } else {
            echo '<p>Aucune catégorie associée.</p>';
        }
        ?>
    </div>
</section>