<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
		// Post thumbnail.
		twentyfifteen_post_thumbnail();
	?>

	<header class="entry-header">
		<?php
			if ( is_single() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
			endif;
		?>

		<small>
		<?php
			$type_of_food_list = wp_get_post_terms($post->ID, 'type-of-food');
			$i = 0;

			foreach ($type_of_food_list as $type_of_food) {
				$i++;
				if ($i > 1){
					echo ", ";
				}
				echo $type_of_food->name;
			}
		?> ||
		<?php
			$origin_of_food_list = wp_get_post_terms($post->ID, 'origin-of-food');
			$i = 0;

			foreach ($origin_of_food_list as $origin_of_food) {
				$i++;
				if ($i > 1){
					echo ", ";
				}
				echo $origin_of_food->name;
			}
		?>
		</small>
		<br>
		<small>Diifficulty Level: <?php echo get_post_meta(get_the_ID(), 'level_difficulty_meta_key', true); ?></small>

	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			/* translators: %s: Name of current post */
			the_content( sprintf(
				__( 'Continue reading %s', 'twentyfifteen' ),
				the_title( '<span class="screen-reader-text">', '</span>', false )
			) );

			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentyfifteen' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		?>
		<h2>Ingridients</h2>
		<p><?php echo get_post_meta(get_the_ID(), 'ingridients', true); ?></p>
		<br>
		<h2>How to Cook</h2>
		<p><?php echo get_post_meta(get_the_ID(), 'how_to_cook', true); ?></p>
	</div><!-- .entry-content -->

	<?php
		// Author bio.
		if ( is_single() && get_the_author_meta( 'description' ) ) :
			get_template_part( 'author-bio' );
		endif;
	?>

	<footer class="entry-footer">
		<?php twentyfifteen_entry_meta(); ?>
		<?php edit_post_link( __( 'Edit', 'twentyfifteen' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
