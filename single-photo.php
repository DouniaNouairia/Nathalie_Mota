<?php get_header(); ?>


<?php
/**
 * Template for displaying a single photo.
 *
 * @package WordPress
 * @subpackage Nathalie_Mota
 */

get_header();
?>

<section id="single-photo" class="single-photo-container">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <div class="single-photo-wrapper">
            <!-- Bloc de métadonnées et image -->
            <div class="single-photo-meta">
                <h3 class="photo-title"><?php the_title(); ?></h3>
                <?php
                // Récupération des champs personnalisés
                $reference = get_post_meta(get_the_ID(), 'reference', true);
                $type = get_post_meta(get_the_ID(), 'type', true);
                $annee = get_post_meta(get_the_ID(), 'annee', true);
                $categories = get_the_terms(get_the_ID(), 'categorie');
                $formats = get_the_terms(get_the_ID(), 'format');
                ?>

                <ul class="photo-meta">
                    <?php if ($reference) : ?>
                        <li>Référence : 
                            <span class="ref_photo"><?php echo esc_html($reference); ?></span>
                        </li>
                    <?php endif; ?>
                    <?php if ($categories) : ?>
                        <li>Catégorie : <?php echo esc_html(join(', ', wp_list_pluck($categories, 'name'))); ?></li>
                    <?php endif; ?>
                    <?php if ($formats) : ?>
                        <li>Format : <?php echo esc_html(join(', ', wp_list_pluck($formats, 'name'))); ?></li>
                    <?php endif; ?>
                    <?php if ($type) : ?>
                        <li>Type : <?php echo esc_html($type); ?></li>
                    <?php endif; ?>
                    <?php if ($annee) : ?>
                        <li>Année : <?php echo esc_html($annee); ?></li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="single-photo-image">
                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('large', ['class' => 'photo-full']); ?>
                <?php else : ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/default-photo.jpg" alt="Image par défaut" class="photo-full">
                <?php endif; ?>
            </div>
        </div>

        <div  class="single-photo-cnt">
            <p>Cette photo vous interesse?</p>
            <button class="modal_cnt_single_photo">Contact</button>
        </div>

        <!-- Photos apparentées -->
        <div class="related-photos">
            <h4>Vous aimerez aussi</h4>
            <div class="photo-list">
                <?php
                $related_photos = new WP_Query([
                    'post_type' => 'photo',
                    'posts_per_page' => 4,
                    'post__not_in' => [get_the_ID()],
                    'tax_query' => [
                        [
                            'taxonomy' => 'categorie',
                            'field' => 'id',
                            'terms' => wp_get_post_terms(get_the_ID(), 'categorie', ['fields' => 'ids']),
                        ],
                    ],
                ]);

                if ($related_photos->have_posts()) :
                    while ($related_photos->have_posts()) : $related_photos->the_post();
                        get_template_part('template_parts/photo_block');
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p>Aucune photo apparentée trouvée.</p>';
                endif;
                ?>
            </div>
        </div>

    <?php endwhile; endif; ?>
</section>



<?php get_footer(); ?>
