<?php

function my_theme_enqueue_styles() {
    $parent_style = 'twentyfifteen-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
    wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '4.0.0', 'all');
    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '4.0.0', 'all');
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

/*function search_form_autocomplete() {
    global $wpdb;

    $search = like_escape($_REQUEST['q']);

    $query = 'SELECT ID, post_title FROM ' . $wpdb->posts . '
        WHERE post_title LIKE \'' . $search . '%\'
        AND post_type = \'food\'
        AND post_status = \'publish\'
        ORDER BY post_title ASC';
    foreach ($wpdb->get_results($query) as $row) {
        $post_title = $row->post_title;
        $id = $row->ID;

        echo $post_title . "\n";
    }
    die();
}
*/

function query_search($query){

}
