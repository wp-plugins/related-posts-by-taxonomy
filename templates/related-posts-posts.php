<?php
/**
 * Template for Related Posts by Taxonomy widget and shortcode - posts template
 *
 * @package related posts by taxonomy
 *
 * the following variables are available:
 * @var array $related_posts array with related posts objects or empty array
 */
?>

<?php if ( $related_posts ) : ?>
	<?php foreach ( $related_posts as $post ) :
		setup_postdata( $post ); ?>

		<h2><a href="<?php the_permalink() ?>" title="<?php echo esc_attr( get_the_title() ? get_the_title() : get_the_ID() ); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a></h2>
		<?php the_content(); ?>

	<?php endforeach; ?>
<?php else : ?>
<p><?php _e('No related posts found', 'related-posts-by-taxonomy'); ?></p>
<?php endif ?>

<?php 
/**
 * note: wp_reset_postdata(); is run after this template by the widget and the shortcode
 */
?>