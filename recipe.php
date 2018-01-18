<?php
/*
Plugin Name: Recipe
Description: Food Custom Post Type
Author: Rhoma Cahyanti
Version:1.0.0
*/

/********** CREATE CUSTOM POST TYPE FOOD **********/
function create_custom_post_type_food(){
  $labels = array(
    'name' => 'Foods',
    'singular-name' => 'food',
    'add_new' => 'Add New Food',
    'all_items' => 'All Foods',
    'edit_item' => 'Edit Food',
    'delete_item' => 'Delete Food',
    'new_item' => 'New Food',
    'view_item' => 'View Food',
    'search_item' => 'Search Food',
    'not_found' => 'No Food Found',
    'not_found_in_trash' => 'No Food Found in Trash'
  );

  $args = array(
    'labels' => $labels,
    'public' => true,
    'has_archieve' => true,
    'publicly_queryable' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'show_in_rest' => true,
    'supports' => array(
      'title',
      'editor',
      'excerpt',
      'thumbnail',
      'revisions',

    ),
    //'taxonomies' => array('category', 'post_tag'),
    'menu_position' => 4,
    'exclude_from_search' => false
  );

  register_post_type('food', $args);
}
add_action('init', 'create_custom_post_type_food');

/********** CREATE CUSTOM TAXONOMY TYPE OF FOOD **********/
function create_type_of_food_custom_taxonomy(){
  $labels = array(
    'name' => 'Type of Food',
    'all_items' => 'All Types of Food',
    'search_items' => 'Search Types of Food',
    'edit_item' => 'Edit Type of Food',
    'update_item' => 'Update Type of Food',
    'add_new_item' =>'Add New Type of Food',
    'new_item_name' => 'New Type of Food Name',
    'menu_name' => 'Type of Food'
  );

  $args = array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array('slug' => 'type-of-food'),
  );

  register_taxonomy('type-of-food', array('food'), $args);
}
add_action('init', 'create_type_of_food_custom_taxonomy');

/********** CREATE CUSTOM TAXONOMY ORIGIN OF FOOD **********/
function create_origin_of_food_custom_taxonomy(){
  $labels = array(
    'name' => 'Origin of Food',
    'all_items' => 'All Origins of Food',
    'search_items' => 'Search Origins of Food',
    'edit_item' => 'Edit Origin of Food',
    'update_item' => 'Update Origin of Food',
    'add_new_item' =>'Add New Origin of Food',
    'new_item_name' => 'New Origin of Food Name',
    'menu_name' => 'Origin of Food'
  );

  $args = array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array('slug' => 'origin-of-food'),
  );

  register_taxonomy('origin-of-food', array('food'), $args);
}
add_action('init', 'create_origin_of_food_custom_taxonomy');

function add_my_post_types_to_query( $query ) {
  if ( is_home() && $query->is_main_query() )
    $query->set( 'post_type', array( 'post', 'page', 'food' ) );
  return $query;
}
add_action( 'pre_get_posts', 'add_my_post_types_to_query' );

/********** CREATE PLUGIN **********/
function custom_post_type_food_my_rewrite_flush() {
    create_custom_post_type_food();
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'custom_post_type_food_my_rewrite_flush' );

/********** CREATE YOUTUBE LINK META BOX **********/
function Youtube_Link_Recipe_Meta_Box() {
    add_meta_box(
        'youtube_link_recipe_box_id',       // Unique ID
        'Youtube Link',                    // Box title
        'Youtube_Link_Recipe_Callback',     // Callback
        'food',                       // Post type
        'advanced',
        'high'
    );
}
add_action( 'add_meta_boxes', 'Youtube_Link_Recipe_Meta_Box' );

function Youtube_Link_Recipe_Callback($post)
{
    wp_nonce_field('Save_Youtube_Link_Recipe_Meta', 'youtube_link_recipe_meta_box_nonce');

    $value = get_post_meta($post->ID, 'youtube_link_meta_key', true);
    ?>
    <label for="youtube_link_field">Youtube Link</label>
    <br>
    <input type="text" name="youtube_link_field" id="youtube_link_field" class="youtube_link_field" style="width: 100%; " value="<?php echo $value; ?>">
    <?php
}

function Save_Youtube_Link_Recipe_Meta($post_id)
{
  if (! isset($_POST['youtube_link_recipe_meta_box_nonce'])){
    return;
  }

  if (! wp_verify_nonce($_POST['youtube_link_recipe_meta_box_nonce'], 'Save_Youtube_Link_Recipe_Meta')){
    return;
  }

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
    return;
  }

  if (! current_user_can('edit_post', $post_id)){
    return;
  }

  if (! isset($_POST['youtube_link_field'])){
    return;
  }

  $youtube_link = $_POST['youtube_link_field'];
  update_post_meta($post_id, 'youtube_link_meta_key', $youtube_link);
}
add_action('save_post', 'Save_Youtube_Link_Recipe_Meta');

/********** CREATE LEVEL DIFFICULTY META BOX **********/
function Level_Difficulty_Meta_Box() {
    add_meta_box(
        'level_difficulty_box_id',       // Unique ID
        'Level Difficulty',                    // Box title
        'Level_Difficulty_Callback',     // Callback
        'food',                       // Post type
        'advanced',
        'high'
    );
}
add_action( 'add_meta_boxes', 'Level_Difficulty_Meta_Box' );

function Level_Difficulty_Callback($post)
{
    wp_nonce_field('Save_Level_Difficulty_Meta', 'level_difficulty_meta_box_nonce');

    $value = get_post_meta($post->ID, 'level_difficulty_meta_key', true);
    ?>
    <label for="level_difficulty_label">Level Difficulty</label>
    <br>
    <select name="level_difficulty_field" id="level_difficulty_field" class="postbox">
        <option value="">Difficulty Level</option>
        <option value="1" <?php selected($value, '1'); ?>>1</option>
        <option value="2" <?php selected($value, '2'); ?>>2</option>
        <option value="3" <?php selected($value, '3'); ?>>3</option>
        <option value="4" <?php selected($value, '4'); ?>>4</option>
        <option value="5" <?php selected($value, '5'); ?>>5</option>
        <option value="6" <?php selected($value, '6'); ?>>6</option>
        <option value="7" <?php selected($value, '7'); ?>>7</option>
        <option value="8" <?php selected($value, '8'); ?>>8</option>
        <option value="9" <?php selected($value, '9'); ?>>9</option>
        <option value="10" <?php selected($value, '10'); ?>>10</option>
    </select>
    <?php
}

function Save_Level_Difficulty_Meta($post_id)
{
  if (! isset($_POST['level_difficulty_meta_box_nonce'])){
    return;
  }

  if (! wp_verify_nonce($_POST['level_difficulty_meta_box_nonce'], 'Save_Level_Difficulty_Meta')){
    return;
  }

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
    return;
  }

  if (! current_user_can('edit_post', $post_id)){
    return;
  }

  if (! isset($_POST['level_difficulty_field'])){
    return;
  }

  $youtube_link = $_POST['level_difficulty_field'];
  update_post_meta($post_id, 'level_difficulty_meta_key', $youtube_link);
}
add_action('save_post', 'Save_Level_Difficulty_Meta');

/********** INGRIDIENTS META BOX ***********/
//This function initializes the ingridients meta box.
function Ingridients_Meta_Box() {
 add_meta_box (
 	  'ingridients_meta_box_id',
 	  __('Ingridients', 'text-domain') ,
 	  'Ingridients_Meta_Box_Callback',
 	  'food'
 );
}
add_action('admin_init', 'Ingridients_Meta_Box');

//Displaying the meta box
function Ingridients_Meta_Box_Callback($post) {
        echo "<h3>Add The Ingridients Here</h3>";
        $content = get_post_meta($post->ID, 'ingridients', true);

        //This function adds the WYSIWYG Editor
        wp_editor (
         $content ,
         'ingridients',
         array ( "media_buttons" => true )
        );
}

//This function saves the data you put in the meta box
function Save_Ingridients_Meta($post_id) {
  if( isset( $_POST['ingridients_meta_box_nonce'] ) && isset( $_POST['food'] ) ) {
    //Not save if the user hasn't submitted changes
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
      return;
    }

    // Verifying whether input is coming from the proper form
    if ( ! wp_verify_nonce ( $_POST['ingridients'] ) ) {
      return;
    }

    // Making sure the user has permission
    if( 'post' == $_POST['food'] ) {
      if( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
      }
    }
  }

  if (!empty($_POST['ingridients'])) {
    $data = $_POST['ingridients'];
    update_post_meta($post_id, 'ingridients', $data);
  }
}
add_action('save_post', 'Save_Ingridients_Meta');

/********* HOW TO COOK META BOX **********/
//This function initializes the ho to cook meta box.
function How_To_Cook_Meta_Box() {
 add_meta_box (
 	  'how_to_cook_meta_box_id',
 	  __('How To Cook', 'text-domain') ,
 	  'How_To_Cook_Meta_Box_Callback',
 	  'food'
 );
}
add_action('admin_init', 'How_To_Cook_Meta_Box');

//Displaying the meta box
function How_To_Cook_Meta_Box_Callback($post) {
        echo "<h3>Write the Step to Cook the Food Here</h3>";
        $content = get_post_meta($post->ID, 'how_to_cook', true);

        //This function adds the WYSIWYG Editor
        wp_editor (
         $content ,
         'how_to_cook',
         array ( "media_buttons" => true )
        );
}

//This function saves the data you put in the meta box
function Save_How_To_Cook_Meta($post_id) {
  if( isset( $_POST['how_to_cook_meta_box_nonce'] ) && isset( $_POST['food'] ) ) {
    //Not save if the user hasn't submitted changes
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
      return;
    }

    // Verifying whether input is coming from the proper form
    if ( ! wp_verify_nonce ( $_POST['how_to_cook'] ) ) {
      return;
    }

    // Making sure the user has permission
    if( 'post' == $_POST['food'] ) {
      if( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
      }
    }
  }

  if (!empty($_POST['how_to_cook'])) {
    $data = $_POST['how_to_cook'];
    update_post_meta($post_id, 'how_to_cook', $data);
  }
}
add_action('save_post', 'Save_How_To_Cook_Meta');
