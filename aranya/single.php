<?php
/**
 * The template for displaying single posts (Journal entries).
 *
 * @package Aranya
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>

	<section class="page-hero">
		<div class="container">
			<p class="overline"><?php echo esc_html( get_the_date() ); ?></p>
			<h1 class="page-hero__title"><?php the_title(); ?></h1>
		</div>
	</section>

	<section class="section--tight">
		<div class="container">
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-content' ); ?>>
				<?php
				if ( has_post_thumbnail() ) {
					the_post_thumbnail( 'large' );
				}
				the_content();

				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'aranya' ),
						'after'  => '</div>',
					)
				);

				the_post_navigation(
					array(
						'prev_text' => '<span class="overline">' . esc_html__( 'Previous', 'aranya' ) . '</span> %title',
						'next_text' => '<span class="overline">' . esc_html__( 'Next', 'aranya' ) . '</span> %title',
					)
				);

				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
				?>
			</article>
		</div>
	</section>

	<?php
endwhile;

get_footer();
