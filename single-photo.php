<?php
get_header();
?>

<section id="single-photo" class="single-photo-container">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>

            <div class="single-photo-wrapper">
                <!-- Bloc de métadonnées et image -->
                <div class="single-photo-meta">
                    <h2><?php the_title(); ?></h2>
                    <?php
                    $reference = get_post_meta(get_the_ID(), 'reference', true);
                    $type = get_post_meta(get_the_ID(), 'type', true);
                    $annee = get_post_meta(get_the_ID(), 'annee', true);
                    $categories = get_the_terms(get_the_ID(), 'categorie');
                    $formats = get_the_terms(get_the_ID(), 'format');
                    ?>

                    <ul class="photo-meta">
                        <?php if ($reference) : ?>
                            <li class="meta-list">RÉFÉRENCE :
                                <span class="ref_photo"><?php echo esc_html($reference); ?></span>
                            </li>
                        <?php endif; ?>
                        <?php if ($categories) : ?>
                            <li class="meta-list">CATÉGORIE : <?php echo esc_html(join(', ', wp_list_pluck($categories, 'name'))); ?></li>
                        <?php endif; ?>
                        <?php if ($formats) : ?>
                            <li class="meta-list">FORMAT : <?php echo esc_html(join(', ', wp_list_pluck($formats, 'name'))); ?></li>
                        <?php endif; ?>
                        <?php if ($type) : ?>
                            <li class="meta-list">TYPE : <?php echo esc_html($type); ?></li>
                        <?php endif; ?>
                        <?php if ($annee) : ?>
                            <li class="meta-list">ANNÉE : <?php echo esc_html($annee); ?></li>
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

            <!-- Section contact et flèches de navigation -->
            <?php get_template_part('templates/ctn-prew-next-post'); ?>

            <?php get_template_part('templates/related-post'); ?>
        <?php endwhile; ?>
    <?php endif; ?>
</section>

<?php
get_footer();
?>