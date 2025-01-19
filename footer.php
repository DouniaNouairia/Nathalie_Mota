<div class="footer">
    <?php
    wp_nav_menu(array(
        'theme_location' => 'footer-menu',
        'walker'         => new Custom_Walker_Nav_Menu(),
        'container'      => 'nav', // Ajoute une balise <nav> comme conteneur principal
        'container_class' => 'footer-nav', // Classe pour le conteneur <nav>
        'items_wrap'     => '%3$s', // Supprime les balises <ul> générées
        'menu_class'      => 'footer-nav-item', // Classe CSS pour les liens du menu
    ));
    ?>

</div>

<?php get_template_part('templates/contact_modal'); ?>
<?php get_template_part('templates/lightbox'); ?>
<?php wp_footer(); ?>



</body>

</html>