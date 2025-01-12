<?php
// Arguments de la requête WP pour récupérer 8 photos
$args = array(
    'post_type' => 'photo',  // Le type de publication personnalisé 'photo'
    'posts_per_page' => 8,   // Nombre de photos à afficher
    'orderby' => 'date',     // Trier par date (les plus récentes en premier)
    'order' => 'DESC'        // Ordre décroissant
);

// La requête WP
$photo_query = new WP_Query($args);

if ($photo_query->have_posts()) :
    echo '<div class="photo-gallery">';
    while ($photo_query->have_posts()) : $photo_query->the_post();
        ?>
        
            <?php
            get_template_part('templates/photo_block');
            ?>

        <?php
    endwhile;
    echo '</div>';
    wp_reset_postdata(); // Réinitialise les données de la requête
else :
    echo 'Aucune photo disponible.';
endif;
?>

<!-- Ajouter un lien pour afficher toutes les publications personnalisées -->
<div class="load-all">
        <button id="load-more-btn">Charger plus</button>
    </div>