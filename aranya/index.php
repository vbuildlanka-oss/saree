<?php
/**
 * The main template file (fallback for the blog / archives).
 *
 * @package Aranya
 */

get_header();
?>

	<section class="page-hero">
		<div class="container">
			<?php if ( is_home() && ! is_front_page() ) : ?>
				<p class="overline"><?php esc_html_e( 'Journal', 'aranya' ); ?></p>
				<h1 class="page-hero__title"><?php single_post_title(); ?></h1>
			<?php elseif ( is_archive() ) : ?>
				<p class="overline"><?php esc_html_e( 'Archive', 'aranya' ); ?></p>
				<h1 class="page-hero__title"><?php the_archive_title(); ?></h1>
				<?php the_archive_description( '<p class="page-hero__lead">', '</p>' ); ?>
			<?php elseif ( is_search() ) : ?>
				<p class="overline"><?php esc_html_e( 'Search', 'aranya' ); ?></p>
				<h1 class="page-hero__title">
					<?php
					/* translators: %s: search query. */
					printf( esc_html__( 'Results for: %s', 'aranya' ), '<span>' . esc_html( get_search_query() ) . '</span>' );
					?>
				</h1>
			<?php else : ?>
				<h1 class="page-hero__title"><?php bloginfo( 'name' ); ?></h1>
			<?php endif; ?>
		</div>
	</section>

	<section class="section--tight">
		<div class="container">
			<?php if ( have_posts() ) : ?>
				<div class="post-list">
					<?php
					while ( have_posts() ) :
						the_post();
						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>
							<?php if ( has_post_thumbnail() ) : ?>
								<a class="post-card__media" href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail( 'large' ); ?>
								</a>
							<?php endif; ?>
							<div class="post-card__body">
								<p class="overline"><?php echo esc_html( get_the_date() ); ?></p>
								<h2 class="post-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								<div class="post-card__excerpt"><?php the_excerpt(); ?></div>
								<a class="link-underline" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read more', 'aranya' ); ?></a>
							</div>
						</article>
						<?php
					endwhile;
					?>
				</div>

				<div class="pagination">
					<?php
					the_posts_pagination(
						array(
							'mid_size'  => 2,
							'prev_text' => __( '&larr; Previous', 'aranya' ),
							'next_text' => __( 'Next &rarr;', 'aranya' ),
						)
					);
					?>
				</div>
			<?php else : ?>
				<p><?php esc_html_e( 'Nothing has been woven here yet.', 'aranya' ); ?></p>
			<?php endif; ?>
		</div>
	</section>

<?php
get_footer();
