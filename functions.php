<?php 

// Ajouter la prise en charge des images mises en avant
add_theme_support( 'post-thumbnails' );

// Ajouter automatiquement le titre du site dans l'en-tête du site
add_theme_support( 'title-tag' );

// Ajout de la feuille du style
function my_theme_enqueue_styles() {
    wp_enqueue_style('theme-style', get_stylesheet_uri());
}

add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');

// Ajout du script
function mon_theme_enqueue_scripts() {
  
    wp_enqueue_script('mon-script', get_template_directory_uri() . '/script.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'mon_theme_enqueue_scripts');


// Ajout des emplacements menu
function register_my_menus() {
    register_nav_menus( array(
        'header-menu' => __( 'Header Menu', 'text-domain' ), 
        'footer-menu' => __( 'Footer Menu', 'text-domain' )  
    ));
}
add_action( 'after_setup_theme', 'register_my_menus' );

// Modification du menu
class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
    
    // Commence l'élément (ajout des classes)
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        // Récupérer les classes existantes de l'élément
        $classes = !empty($item->classes) ? implode(' ', $item->classes) : '';

        // Ajouter une classe personnalisée en fonction de l'emplacement du menu
        if (isset($args->theme_location)) {
            // Si le menu est dans le header
            if ($args->theme_location === 'header-menu') {
                $classes .= ' header-nav-item'; // Classe pour les éléments du menu du header
            }
            // Si le menu est dans le footer
            elseif ($args->theme_location === 'footer-menu') {
                $classes .= ' footer-nav-item'; // Classe pour les éléments du menu du footer
            }
        }

        // Appliquer les classes et ajouter le lien
        $output .= sprintf(
            '<a href="%s" class="%s">%s</a>',
            esc_url($item->url), // URL du lien
            esc_attr($classes),  // Classes CSS appliquées
            esc_html($item->title) // Titre du lien
        );
    }

    // Terminer l'élément (vide pour ne rien ajouter après chaque lien)
    function end_el(&$output, $item, $depth = 0, $args = null) {
        // Pas de fermeture particulière ici
    }
}



