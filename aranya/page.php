<?php
/**
 * The template for displaying single pages.
 *
 * @package Aranya
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>

	<section class="page-hero">
		<div class="container">
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
