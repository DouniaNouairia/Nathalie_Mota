<?php get_header(); ?>

<?php get_template_part('templates/hero'); ?>

<form method="GET" action="<?php echo esc_url(home_url('/')); ?>">
    <!-- Filtre par catégorie -->
    <label for="category_filter">Catégories</label>
    <?php
    wp_dropdown_categories(array(
        'show_option_all' => 'Toutes les catégories',
        'taxonomy' => 'categorie', // Remplacer par la taxonomie des catégories de photos si tu utilises une taxonomie personnalisée
        'name' => 'category_filter',
        'orderby' => 'name',
        'selected' => isset($_GET['category_filter']) ? $_GET['category_filter'] : ''
    ));
    ?>

    <!-- Filtre par format (type de photo) -->
    <label for="format_filter">Formats</label>
    <select name="format_filter" id="format_filter">
        <option value="">Tous les formats</option>
        <option value="paysage" <?php echo (isset($_GET['format_filter']) && $_GET['format_filter'] === 'paysage') ? 'selected' : ''; ?>>Paysage</option>
        <option value="portrait" <?php echo (isset($_GET['format_filter']) && $_GET['format_filter'] === 'portrait') ? 'selected' : ''; ?>>Portrait</option>
    </select>

    <!-- Filtre par tri (date) -->
    <label for="sort_filter">Trier par</label>
    <select name="sort_filter" id="sort_filter">
        <option value="desc" <?php echo (isset($_GET['sort_filter']) && $_GET['sort_filter'] === 'desc') ? 'selected' : ''; ?>>Les plus récents</option>
        <option value="asc" <?php echo (isset($_GET['sort_filter']) && $_GET['sort_filter'] === 'asc') ? 'selected' : ''; ?>>Les plus anciens</option>
    </select>

    <!-- Soumettre le formulaire -->
    <input type="submit" value="Filtrer">
</form>


<?php get_footer(); ?>