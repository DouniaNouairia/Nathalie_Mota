<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<header class="header">
    <a href="<?php echo home_url('/'); ?>">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Logo.png" alt="Logo">
    </a>  
    <!-- Icône du menu burger -->
    <div class="burger-menu">
        <img class="Burger-open" src="<?php echo get_template_directory_uri(); ?>/assets/images/Burger-icon.png" alt="Icône burger">
        <img class="Burger-close" src="<?php echo get_template_directory_uri(); ?>/assets/images/Close-burger.png" alt="Icône croix fermeture burger" style="display: none;">
    </div>
    <?php
    wp_nav_menu(array(
        'theme_location' => 'header-menu',
        'walker'         => new Custom_Walker_Nav_Menu(),
        'container'      => 'nav', // Ajoute une balise <nav> comme conteneur principal
        'container_class'=> 'header-nav', // Classe CSS pour le conteneur <nav>
        'items_wrap'     => '%3$s', // Supprime les balises <ul> générées
        'menu_class'     => 'header-nav-item', // Classe CSS pour les liens du menu
    ));
    ?>
</header>

<!-- Panneau coulissant du menu mobile -->
<div class="mobile-menu-overlay">
    <div class="mobile-menu-content">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'header-menu',
            'container'      => false,
            'menu_class'     => 'mobile-nav-list',
        ));
        ?>
    </div>
</div>


<?php wp_body_open(); ?>   


