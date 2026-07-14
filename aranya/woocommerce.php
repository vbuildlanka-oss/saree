<?php
/**
 * WooCommerce wrapper template.
 *
 * WooCommerce automatically uses this file (when present in the theme) to
 * render ALL of its pages — shop archive, single product, cart, checkout and
 * account — inside the theme's header/footer. This is the lightweight,
 * upgrade-safe way to integrate WooCommerce without overriding each template.
 *
 * The design classes (.products-grid, .product-card, .page-hero, .btn, etc.)
 * are bridged onto WooCommerce's default markup in assets/css/woocommerce.css.
 *
 * @package Aranya
 */

get_header();
?>

	<section class="page-hero">
		<div class="container">
			<?php if ( is_shop() || is_product_taxonomy() ) : ?>
				<p class="overline"><?php esc_html_e( 'The Collection', 'aranya' ); ?></p>
				<h1 class="page-hero__title"><?php woocommerce_page_title(); ?></h1>
			<?php elseif ( is_product() ) : ?>
				<p class="overline"><?php esc_html_e( 'Handwoven', 'aranya' ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<section class="section--tight woocommerce-wrapper">
		<div class="container">
			<?php woocommerce_content(); ?>
		</div>
	</section>

<?php
get_footer();
