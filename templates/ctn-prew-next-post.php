<section class="arrows-cnt">
            <div class="single-photo-cnt">
                <p class="ctn-prew-next-post-p">Cette photo vous intéresse ?</p>
                <button class="modal_cnt_single_photo">Contact</button>
            </div>
            <div class="arrows">
    <?php 
    // Récupérer les posts précédent et suivant
    $prev_post = get_previous_post();
    $next_post = get_next_post();

    // Si aucun précédent, récupérer le dernier post (boucle infinie)
    if (!$prev_post) {
        $prev_post = get_posts(array(
            'post_type' => 'photo',
            'posts_per_page' => 1,
            'orderby' => 'date',
            'order' => 'DESC'
        ));
        $prev_post = $prev_post ? $prev_post[0] : null;
    }

    // Si aucun suivant, récupérer le premier post (boucle infinie)
    if (!$next_post) {
        $next_post = get_posts(array(
            'post_type' => 'photo',
            'posts_per_page' => 1,
            'orderby' => 'date',
            'order' => 'ASC'
        ));
        $next_post = $next_post ? $next_post[0] : null;
    }

    // Flèche gauche (précédente)
    if ($prev_post) : 
        $prev_thumb = get_the_post_thumbnail_url($prev_post->ID, 'thumbnail') ?: get_template_directory_uri() . '/assets/images/default-photo.jpg'; 
    ?>
        <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" class="photo-prev" title="<?php echo esc_attr(get_the_title($prev_post->ID)); ?>">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Left-hover.png" alt="fleche gauche">
        <div class="photo-thumb-left" style="background-image: url('<?php echo esc_url($prev_thumb); ?>');"></div>
        </a>
    <?php endif; ?>

    <!-- Flèche droite (suivante) -->
    <?php if ($next_post) : 
        $next_thumb = get_the_post_thumbnail_url($next_post->ID, 'thumbnail') ?: get_template_directory_uri() . '/assets/images/default-photo.jpg'; 
    ?>
        <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" class="photo-next" title="<?php echo esc_attr(get_the_title($next_post->ID)); ?>">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Right-hover.png" alt="fleche droite">
            <div class="photo-thumb-right" style="background-image: url('<?php echo esc_url($next_thumb); ?>');"></div>
        </a>
    <?php endif; ?>
</div>

        </section>