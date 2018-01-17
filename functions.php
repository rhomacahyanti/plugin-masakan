<?php

function my_theme_enqueue_styles() {
    $parent_style = 'twentyfifteen-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
    wp_enqueue_style('mysite-css', get_stylesheet_directory_uri() . '/css/mysite.css', array(), '1.0.0', 'all');
    wp_enqueue_script('bootstrap-js', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '4.0.0', 'all');

    wp_enqueue_script('autocomplete', get_stylesheet_directory_uri().'/js/jquery.auto-complete.js', array('jquery'));
  	wp_enqueue_script('mysite-js2', get_stylesheet_directory_uri().'/js/my-site.js', array('jquery', 'autocomplete'));
  	wp_enqueue_style('autocomplete-css', get_stylesheet_directory_uri().'/css/jquery.auto-complete.css');
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

/*function my_theme_enqueue_scripts() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-ui-autocomplete' );
	wp_register_style( 'jquery-ui-styles','http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css' );
	wp_enqueue_style( 'jquery-ui-styles' );
	//wp_register_script( 'my-autocomplete', get_template_directory_uri() . '/js/mysite.js', array( 'jquery', 'jquery-ui-autocomplete' ), '1.0', false );
	wp_localize_script( 'my-autocomplete', 'MyAutocomplete', array( 'url' => admin_url( 'admin-ajax.php' ) ) );
	wp_enqueue_script( 'my-autocomplete' );
}

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_scripts' );

function my_search() {
		$term = ( $_GET['term'] );

    global $wpdb;

  	$food = $wpdb->esc_like(stripslashes($term)).'%'; //escape for use in LIKE statement
  	$sql = "SELECT post_title
  		FROM $wpdb->posts
  		WHERE post_title LIKE %s
  		AND post_type = 'food'
      AND post_status = 'publish'
      ORDER BY post_title
      LIMIT 5";

  	$sql = $wpdb->prepare($sql, $food);

  	$results = $wpdb->get_results($sql);

  	$suggestion = array();
  	foreach( $results as $r ){
  		$suggestion['label'] = addslashes($r->post_title);
      $suggestion['link'] = addslashes($r->guid);
      $suggestions[] = $suggestion;

    }

  	echo json_encode($suggestions);

  	die();
}

add_action( 'wp_ajax_my_search', 'my_search' );
add_action( 'wp_ajax_nopriv_my_search', 'my_search' );*/
