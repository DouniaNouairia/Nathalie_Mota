<div class="filters-container">
    <!-- Filtre | Catégorie -->
    <div class="custom-flex">
        <div class="custom-select" id="category-filter">
            <div class="selected-option">CATÉGORIE</div>
            <ul class="options-list">
                <li class="option-title">CATÉGORIE</li>
                <?php
                $photo_categories = get_terms('categorie');
                foreach ($photo_categories as $category) {
                    echo '<li class="option" data-value="' . $category->slug . '">' . $category->name . '</li>';
                }
                ?>
            </ul>
        </div>

        <!-- Filtre | Format -->
        <div class="custom-select" id="format-filter">
            <div class="selected-option">FORMATS</div>
            <ul class="options-list">
                <li class="option-title">FORMAT</li>
                <?php
                $photo_formats = get_terms('format');
                foreach ($photo_formats as $format) {
                    echo '<li class="option" data-value="' . $format->slug . '">' . $format->name . '</li>';
                }
                ?>
            </ul>
        </div>
    </div>

    <!-- Filtre | Trier par date -->
    <div class="custom-select" id="date-filter">
        <div class="selected-option">TRIER PAR</div>
        <ul class="options-list">
            <li class="option-title">TRIER PAR</li>
            <li class="option" data-value="DESC">Du plus récent au plus ancien</li>
            <li class="option" data-value="ASC">Du plus ancien au plus récent</li>
        </ul>
    </div>
</div>