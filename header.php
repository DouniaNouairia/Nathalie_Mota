<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <!-- Header principal -->
    <header class="header">
        <a href="<?php echo home_url('/'); ?>">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Logo.png" alt="Logo">
        </a>
        <!-- menu burger -->
        <div class="burger-menu">
            <img class="Burger-open" src="<?php echo get_template_directory_uri(); ?>/assets/images/Burger-icon.png" alt="Icône burger">
        </div>
        <?php
        wp_nav_menu(array(
            'theme_location' => 'header-menu',
            'walker'         => new Custom_Walker_Nav_Menu(),
            'container'      => 'nav',
            'container_class' => 'header-nav',
            'items_wrap'     => '%3$s',
            'menu_class'     => 'header-nav-item',
        ));
        ?>
    </header>

    <!-- Panneau coulissant du menu mobile -->
    <div class="mobile-menu-overlay">
        <div class="mobile-menu-content">
            <div class="menu-overlay-header">
                <a href="<?php echo home_url('/'); ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Logo.png" alt="Logo">
                </a>
                <img class="Burger-close" src="<?php echo get_template_directory_uri(); ?>/assets/images/Close-burger.png" alt="Icône croix fermeture burger">
            </div>
            <div class="menu-overlay-nav">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'header-menu',
                    'container'      => false,
                    'menu_class'     => 'mobile-nav-list',
                ));
                ?>
            </div>
        </div>
    </div>

    <?php wp_body_open(); ?>