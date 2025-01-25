<?php

// Ajouter la prise en charge des images mises en avant
add_theme_support('post-thumbnails');



// Ajouter - FontAwesome
// function enqueue_font_awesome()
// {
//     wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css', array(), null);
// }
// add_action('wp_enqueue_scripts', 'enqueue_font_awesome');

// Ajouter automatiquement le titre du site dans l'en-tête du site
add_theme_support('title-tag');

// Ajout de la feuille du style
function my_theme_enqueue_styles()
{
    wp_enqueue_style('theme-style', get_stylesheet_uri());
}

add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');

// Ajout du script
function mon_theme_enqueue_scripts()
{
    // Enqueue les styles et scripts nécessaires
    wp_enqueue_script('jquery'); // Assurez-vous que jQuery est chargé
    wp_enqueue_script('modal-script', get_template_directory_uri() . '/script/modal.js', array('jquery'), null, true);
    wp_enqueue_script('lightbox-script', get_template_directory_uri() . '/script/lightbox.js', array('jquery'), null, true);
    wp_enqueue_script('filtres-ajax-script', get_template_directory_uri() . '/script/filtres_ajax.js', array('jquery'), null, true);
    wp_enqueue_script('load-more-script', get_template_directory_uri() . '/script/load_more.js', array('jquery'), null, true);
    wp_enqueue_script('menu-burger-script', get_template_directory_uri() . '/script/menu-burger.js', array('jquery'), null, true);

    // Localiser les données pour les scripts
    wp_localize_script('filtres-ajax-script', 'filtres_ajax_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('filtres_ajax_nonce'),
        'template_url' => get_template_directory_uri(), // URL du répertoire du thème
    ));
    wp_localize_script('load-more-script', 'wp_data', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('load_more_nonce'),
        'template_url' => get_template_directory_uri(), // URL du répertoire du thème

    ));
}
add_action('wp_enqueue_scripts', 'mon_theme_enqueue_scripts');




// Ajout des emplacements menu
function register_my_menus()
{
    register_nav_menus(array(
        'header-menu' => __('Header Menu', 'text-domain'),
        'footer-menu' => __('Footer Menu', 'text-domain')
    ));
}
add_action('after_setup_theme', 'register_my_menus');

// Modification du menu
class Custom_Walker_Nav_Menu extends Walker_Nav_Menu
{

    // Commence l'élément (ajout des classes)
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
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
    function end_el(&$output, $item, $depth = 0, $args = null)
    {
        // Pas de fermeture particulière ici
    }
}

// ****HERO****
function get_random_hero_image()
{
    // Initialiser les arguments de la requête pour le CPT "photo"
    $args = array(
        'post_type'      => 'photo', // Nom de votre Custom Post Type
        'posts_per_page' => -1,      // Récupérer tous les posts
        'post_status'    => 'publish', // Seulement les posts publiés
    );

    // Effectuer la requête
    $query = new WP_Query($args);

    $images = array();

    // Parcourir les posts et récupérer les images à la une
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            // Récupérer l'URL de l'image à la une
            $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');

            // Ajouter l'image au tableau si elle existe
            if ($image_url) {
                $images[] = $image_url;
            }
        }
        wp_reset_postdata(); // Réinitialiser les données de post
    }

    // Vérifier si des images ont été trouvées
    if (!empty($images)) {
        // Sélectionner une image aléatoire
        $random_image = $images[array_rand($images)];
        return $random_image;
    }

    // Retourner une image par défaut si aucune image n'est trouvée
    return get_template_directory_uri() . '/assets/images/nathalie-0.jpeg';
}

// **RECUPERER LE CHAMPDE REFERENCE**

function get_reference()
{
    // Récupérer la valeur du champ SCF
    $reference = get_post_meta(get_the_ID(), 'reference', true);

    // Retourner la valeur récupérée
    return $reference;
}
add_shortcode('get_reference', 'get_reference');

// ****FILTRE****

add_action('wp_ajax_filter_photos', 'filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');

function filter_photos()
{
    $category = isset($_GET['category']) ? $_GET['category'] : '';
    $format = isset($_GET['format']) ? $_GET['format'] : '';
    $date = isset($_GET['date']) ? $_GET['date'] : '';

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'tax_query' => array(),
    );

    if ($category && $category !== 'ALL') {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field' => 'slug',
            'terms' => $category,
        );
    }

    if ($format && $format !== 'ALL') {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format,
        );
    }

    if (!empty($args['tax_query'])) {
        $args['tax_query']['relation'] = 'AND';
    }

    if ($date && $date !== 'ALL') {
        $args['orderby'] = 'date';
        $args['order'] = ($date === 'ASC') ? 'ASC' : 'DESC';
    }

    $query = new WP_Query($args);

    $photos = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $categories = get_the_terms(get_the_ID(), 'categorie');
            $category_name = $categories ? $categories[0]->name : '';

            // Ici, ajouter la référence (utilisation de get_the_ID() comme référence)
            $photos[] = array(
                'image' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'),
                'reference' => get_post_meta(get_the_ID(), 'reference', true),
                'title' => get_the_title() ?: 'Titre non défini',
                'category' => $category_name ?: 'Sans catégorie',   // Vérifier si la catégorie est vide
                'link' => get_permalink(), // Ajouter le lien de la page de l'image
            );
        }
    }

    wp_reset_postdata();

    wp_send_json_success(array('photos' => $photos));
}


// ***LOAD MORE***

add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');

function load_more_posts()
{
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $category = isset($_GET['category']) ? $_GET['category'] : 'ALL';
    $format = isset($_GET['format']) ? $_GET['format'] : 'ALL';
    $dateSort = isset($_GET['dateSort']) ? $_GET['dateSort'] : 'ALL';

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $page,
    );

    if ($category !== 'ALL') {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field'    => 'slug',
            'terms'    => $category,
        );
    }

    if ($format !== 'ALL') {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field'    => 'slug',
            'terms'    => $format,
        );
    }

    if ($dateSort !== 'ALL') {
        $args['orderby'] = 'date';
        $args['order'] = ($dateSort === 'ASC') ? 'ASC' : 'DESC';
    }

    $query = new WP_Query($args);
    $posts = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $categories = get_the_terms(get_the_ID(), 'categorie');
            $category_name = !empty($categories) ? $categories[0]->name : 'Sans catégorie';

            // On ajoute aussi ici la référence
            $posts[] = array(
                'id'       => get_the_ID(),
                'image'    => get_the_post_thumbnail_url(get_the_ID(), 'medium'), // Image miniature
                'title'    => get_the_title(),
                'reference' => get_post_meta(get_the_ID(), 'reference', true),    // Référence personnalisée
                'category' => $category_name,
                'link'     => get_permalink(get_the_ID()),                      // Lien vers la publication
            );
        }
    }

    wp_reset_postdata();

    wp_send_json(array('posts' => $posts));
}
