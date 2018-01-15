<?php

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php

		$searchinput = $_GET['searchinput'];
    $typeOfFood = $_GET['type-of-food'];
    $originOfFood = $_GET['origin-of-food'];
    $difficultyLevelBottom = $_GET['difficulty-level-bottom'];
    $difficultyLevelUp = $_GET['difficulty-level-up'];

    global $wpdb;
    $search_results = $wpdb->get_results("
        SELECT DISTINCT posts.*
        FROM $wpdb->posts posts
        INNER JOIN $wpdb->term_relationships term_relationship
          ON term_relationship.object_id = posts.ID
        INNER JOIN $wpdb->terms term
          ON term_relationship.term_taxonomy_id = term.term_id
        INNER JOIN (
          SELECT post_meta.post_id
          FROM $wpdb->postmeta post_meta
          WHERE post_meta.meta_value BETWEEN '" . $difficultyLevelBottom . "' AND '" . $difficultyLevelUp . "'
          ) meta ON meta.post_id = posts.ID
        WHERE posts.post_type = 'food'
          AND ((term.name IN ('" . $typeOfFood . "', '" . $originOfFood . "')) OR posts.post_title = '" . $searchinput . "')"
        );

		if ($searchinput != ""){
			$search_results = $wpdb->get_results("
	        SELECT DISTINCT posts.*
	        FROM $wpdb->posts posts
	        INNER JOIN $wpdb->postmeta post_meta
	          ON post_meta.post_id = posts.ID
	        WHERE posts.post_type = 'food' AND posts.post_status = 'publish'
	          AND (posts.post_content LIKE '%" . $searchinput . "%'
						OR posts.post_title LIKE '%" . $searchinput . "%'
						OR post_meta.meta_value LIKE '%" . $searchinput . "%')"
	        );
		}

    foreach ($search_results as $post) { ?>
      <h2>
    		<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permalink: <?php the_title(); ?>">
    			<?php the_title(); ?>
    		</a>
    	</h2> <?php
    }

    foreach ($search_results as $post) {
      setup_postdata($post);
      get_template_part( 'content', 'search' );
    }

		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
