<?php 

// Ajouter la prise en charge des images mises en avant
add_theme_support( 'post-thumbnails' );



// Ajouter - FontAwesome
function enqueue_font_awesome() {
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'); // You can change the version URL as needed.
}
add_action('wp_enqueue_scripts', 'enqueue_font_awesome');

// Ajouter automatiquement le titre du site dans l'en-tête du site
add_theme_support( 'title-tag' );

// Ajout de la feuille du style
function my_theme_enqueue_styles() {
    wp_enqueue_style('theme-style', get_stylesheet_uri());
}

add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');

// Ajout du script
function mon_theme_enqueue_scripts() {
    // Enqueue les scripts
    wp_enqueue_script('modal-script', get_template_directory_uri() . '/script/modal.js', array(), null, true);
    wp_enqueue_script('filtres-ajax-script', get_template_directory_uri() . '/script/filtres_ajax.js', array('jquery'), null, true);
    wp_enqueue_script('load-more-script', get_template_directory_uri() . '/script/load_more.js', array('jquery'), null, true);
    // Localiser le script pour passer les variables de PHP à JS
    wp_localize_script('filtres-ajax-script', 'filtres_ajax_params', 'load-more-script', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('filtres_ajax_nonce')
    ));
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

// ****HERO****
function get_random_hero_image() {
    $images = [
        get_template_directory_uri() . '/assets/images/nathalie-0.jpeg',
        get_template_directory_uri() . '/assets/images/nathalie-1.jpeg',
        get_template_directory_uri() . '/assets/images/nathalie-2.jpeg',
        get_template_directory_uri() . '/assets/images/nathalie-3.jpeg',
        get_template_directory_uri() . '/assets/images/nathalie-4.jpeg',
        get_template_directory_uri() . '/assets/images/nathalie-5.jpeg',
        get_template_directory_uri() . '/assets/images/nathalie-6.jpeg',
        get_template_directory_uri() . '/assets/images/nathalie-7.jpeg',
        get_template_directory_uri() . '/assets/images/nathalie-8.jpeg',
        get_template_directory_uri() . '/assets/images/nathalie-9.jpeg',
        get_template_directory_uri() . '/assets/images/nathalie-10.jpeg',
        get_template_directory_uri() . '/assets/images/nathalie-11.jpeg',
        get_template_directory_uri() . '/assets/images/nathalie-12.jpeg',
        get_template_directory_uri() . '/assets/images/nathalie-13.jpeg',
        get_template_directory_uri() . '/assets/images/nathalie-14.jpeg',
        get_template_directory_uri() . '/assets/images/nathalie-15.jpeg',
        
    ];

    // Sélectionner une image aléatoire
    $random_image = $images[array_rand($images)];

    return $random_image;
}

// **recuperer le champs reference**

function get_reference() {
    // Récupérer la valeur du champ SCF
    $reference = get_post_meta(get_the_ID(), 'reference', true);
    
    // Retourner la valeur récupérée
    return $reference;
}
add_shortcode('get_reference', 'get_reference');

// ****FILTRE****

add_action('wp_ajax_filter_photos', 'filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');

function filter_photos() {
    $category = isset($_GET['category']) ? $_GET['category'] : '';
    $format = isset($_GET['format']) ? $_GET['format'] : '';
    $date = isset($_GET['date']) ? $_GET['date'] : '';

    // Configuration de base de la requête
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'tax_query' => array(), // Initialise la tax_query comme un tableau vide
    );

    // Ajouter le filtre de catégorie si défini
    if ($category && $category !== 'ALL') {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field' => 'slug',
            'terms' => $category,
        );
    }

    // Ajouter le filtre de format si défini
    if ($format && $format !== 'ALL') {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format,
        );
    }

    // Si plusieurs taxonomies sont ajoutées, préciser la relation entre elles
    if (!empty($args['tax_query'])) {
        $args['tax_query']['relation'] = 'AND'; // Combine les filtres avec une relation "ET"
    }

    // Ajouter le tri par date si défini
    if ($date && $date !== 'ALL') {
        $args['orderby'] = 'date';
        $args['order'] = ($date === 'ASC') ? 'ASC' : 'DESC';
    }

    // Exécution de la requête
    $query = new WP_Query($args);

    $photos = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $photos[] = array(
                'image' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'),
            );
        }
    }

    wp_reset_postdata();

    // Retour de la réponse JSON
    wp_send_json_success(array('photos' => $photos));
}

// ***LOAD MORE***

add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');

function load_more_posts() {
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
    $format = isset($_GET['format']) ? sanitize_text_field($_GET['format']) : '';
    $dateSort = isset($_GET['dateSort']) ? sanitize_text_field($_GET['dateSort']) : 'DESC';

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $page,
    );

    if ($category && $category !== 'ALL') {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field'    => 'slug',
            'terms'    => $category,
        );
    }

    if ($format && $format !== 'ALL') {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field'    => 'slug',
            'terms'    => $format,
        );
    }

    if ($dateSort && in_array($dateSort, ['ASC', 'DESC'])) {
        $args['orderby'] = 'date';
        $args['order'] = $dateSort;
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            // Remplacez par votre structure HTML
            echo '<div class="photo-item">';
            echo '<div class="photo-thumbnail">';
            echo get_the_post_thumbnail(get_the_ID(), 'medium');
            echo '</div>';
            echo '<h2>' . get_the_title() . '</h2>';
            echo '</div>';
        }
    } else {
        echo ''; // Aucun résultat
    }

    wp_reset_postdata();
    wp_die();
}

  
  



