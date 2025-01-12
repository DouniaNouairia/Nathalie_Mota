<div class="filters-container">
    <!-- Filtre | Categorie -->
    <label for="category-filter"></label>
    <select name="category-filter" id="category-filter">
        <option value="ALL">CATÉGORIE</option>
        <?php
        $photo_categories = get_terms('categorie');
        foreach ($photo_categories as $category) {
            echo '<option value="' . $category->slug . '">' . $category->name . '</option>';
        }
        ?>
    </select>

    <!-- Filtre | Format -->
    <label for="format-filter"></label>
    <select name="format-filter" id="format-filter">
        <option value="ALL">FORMAT</option>
        <?php
        $photo_formats = get_terms('format');
        foreach ($photo_formats as $format) {
            echo '<option value="' . $format->slug . '">' . $format->name . '</option>';
        }
        ?>
    </select>

    <!-- Filtre | Trier par date -->
    <label for="date-filter"></label>
    <select name="date-filter" id="date-filter">
        <option value="ALL">TRIER PAR</option>
        <option value="DESC">Du plus récent au plus ancien</option>
        <option value="ASC">Du plus ancien au plus récent</option>
    </select>
</div>

