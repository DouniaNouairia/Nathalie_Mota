<?php
// Définir la page actuelle
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// Arguments de la requête WP pour récupérer des photos (avec pagination)
$args = array(
    'post_type' => 'photo',  // Le type de publication personnalisé 'photo'
    'posts_per_page' => 8,   // Nombre de photos à afficher
    'paged' => $paged,       // Pagination de la page actuelle
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
        get_template_part('templates/photo_block'); // Charge le modèle pour chaque photo
        ?>

    <?php
    endwhile;
    echo '</div>';

    // Ajout de la pagination via AJAX
    ?>
    <div class="load-more">
        <button id="load-more-btn">Charger plus</button>
    </div>

    <input type="hidden" name="page" value="<?php echo $paged; ?>" /> <!-- Champ caché pour la page -->

<?php
    wp_reset_postdata(); // Réinitialise les données de la requête
else :
    echo 'Aucune photo disponible.';
endif;
?>