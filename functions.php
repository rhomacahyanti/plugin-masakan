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

function my_theme_enqueue_scripts() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-ui-autocomplete' );
	wp_register_style( 'jquery-ui-styles','http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css' );
	wp_enqueue_style( 'jquery-ui-styles' );
	wp_register_script( 'my-autocomplete', get_template_directory_uri() . '/js/mysite.js', array( 'jquery', 'jquery-ui-autocomplete' ), '1.0', false );
	wp_localize_script( 'my-autocomplete', 'MyAutocomplete', array( 'url' => admin_url( 'admin-ajax.php' ) ) );
	wp_enqueue_script( 'my-autocomplete' );
}

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_scripts' );

function my_search() {
		$term = strtolower( $_GET['term'] );
		$suggestions = array();

    global $wpdb;
  	$food = $wpdb->esc_like(stripslashes($term)).'%'; //escape for use in LIKE statement
  	$sql = "SELECT post_title
  		FROM $wpdb->posts
  		WHERE post_title LIKE %s
  		AND post_type = 'food'
      AND post_status = 'publish'
      ORDER BY post_title";

  	//$sql = $wpdb->prepare($sql, $food);

  	$results = $wpdb->get_results($sql);

  	$suggestions = array();
  	foreach( $results as $r ){
  		$suggestions['label'] = addslashes($r->post_title);
      $suggestions['link'] = addslashes($r->ID);
    }

  	echo json_encode($suggestions);
  	die();

    /*
    $loop = new WP_Query( 'searchinput=' . $term );
    $loop = new WP_Query( array(
  		'post_type'     => array('food'),
  		'post_status'   => 'publish',
  		'posts_per_page'=> 5,
  		'searchinput'   => $term,
      'orderby'     => 'title',
      'order'       => 'ASC',
      'meta_query' => array(
      		'key'     => '_my_custom_key',
      		'value'   => $term,
      		'compare' => 'LIKE'
  	   )));

		while( $loop->have_posts() ) {
			$loop->the_post();
			$suggestion = array();
			$suggestion['label'] = get_the_title();
			$suggestion['link'] = get_permalink();

			$suggestions[] = $suggestion;
		}

		wp_reset_query();
  	$response = json_encode( $suggestions );
  	echo $response;
  	exit();*/

}

add_action( 'wp_ajax_my_search', 'my_search' );
add_action( 'wp_ajax_nopriv_my_search', 'my_search' );

/*function ja_rest_api_register_routes() {
	register_rest_route( 'wp/v2', '/food', array(
		'methods'  => 'GET',
		'callback' => 'ja_rest_api_search',
	) );
}
add_action( 'rest_api_init', 'ja_rest_api_register_routes' );

function ja_rest_api_search( $request ) {
	if ( empty( $request['term'] ) ) {
		return;
	}
	$results = new WP_Query( array(
		'post_type'     => array( 'food' ),
		'post_status'   => 'publish',
		'posts_per_page'=> 30,
		's'             => $request['term'],
	) );
	if ( !empty( $results->posts ) ) {
		return $results->posts;
	}
}*/

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

/*add_action('wp_ajax_nopriv_get_listing_names', 'ajax_listings');
add_action('wp_ajax_get_listing_names', 'ajax_listings');

function ajax_listings() {
	global $wpdb; //get access to the WordPress database object variable

	//get names of all businesses
	$food = $wpdb->esc_like(stripslashes($_GET['searchinput'])).'%'; //escape for use in LIKE statement
	$sql = "select post_title
		from $wpdb->posts
		where post_title like %s
		and post_type='food' and post_status='publish'";

	$sql = $wpdb->prepare($sql, $food);

	$results = $wpdb->get_results($sql);

	//copy the business titles to a simple array
	$titles = array();
	foreach( $results as $r )
		$titles[] = addslashes($r->post_title);

	echo json_encode($titles); //encode into JSON format and output

	die(); //stop "0" from being output
}*/
