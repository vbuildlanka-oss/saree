<?php
/**
 * The template for displaying 404 (not found) pages.
 *
 * @package Aranya
 */

get_header();
?>

	<section class="page-hero">
		<div class="container">
			<p class="overline"><?php esc_html_e( 'Lost the thread', 'aranya' ); ?></p>
			<h1 class="page-hero__title"><?php esc_html_e( 'This page has come off the loom', 'aranya' ); ?></h1>
			<p class="page-hero__lead">
				<?php esc_html_e( 'The page you were looking for cannot be found. Perhaps return to the collection.', 'aranya' ); ?>
			</p>
			<p style="margin-top: var(--space-md);">
				<a class="btn btn--primary" href="<?php echo esc_url( aranya_shop_url() ); ?>"><?php esc_html_e( 'Explore the collection', 'aranya' ); ?></a>
				<a class="btn btn--ghost" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to home', 'aranya' ); ?></a>
			</p>
		</div>
	</section>

<?php
get_footer();
