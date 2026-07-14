<?php
/**
 * Template Name: Shop Collection
 *
 * Front-end collection/archive page. Reproduces the original shop.html grid
 * with the filter + sort toolbar (powered by assets/js/shop.js).
 *
 * NOTE: When WooCommerce is installed, its own shop archive
 * (woocommerce/archive-product.php) is used for the real product catalogue.
 * This template is a self-contained demo grid for the front-end showcase.
 *
 * @package Aranya
 */

get_header();

$products = aranya_get_demo_products();
$count    = count( $products );
?>

	<!-- ARCHIVE HEADER -->
	<section class="page-hero">
		<div class="container">
			<p class="overline"><?php esc_html_e( 'The Collection', 'aranya' ); ?></p>
			<h1 class="page-hero__title">
				<?php echo esc_html( get_the_title() ? get_the_title() : __( 'Every Weave We Make', 'aranya' ) ); ?>
			</h1>
			<p class="page-hero__lead">
				<?php esc_html_e( 'Handloom silk and cotton sarees, woven in small numbers. When a piece is gone, it is often gone for good.', 'aranya' ); ?>
			</p>
		</div>
	</section>

	<section class="section--tight">
		<div class="container">
			<!-- SHOP TOOLBAR -->
			<div class="shop-toolbar">
				<p class="shop-toolbar__count">
					<?php
					/* translators: 1: number shown, 2: total */
					printf( esc_html__( 'Showing %1$d of %2$d weaves', 'aranya' ), (int) $count, (int) $count );
					?>
				</p>

				<div class="shop-toolbar__filters" role="group" aria-label="<?php esc_attr_e( 'Filter by fabric', 'aranya' ); ?>">
					<button class="shop-filter is-active" data-filter="all"><?php esc_html_e( 'All', 'aranya' ); ?></button>
					<button class="shop-filter" data-filter="silk"><?php esc_html_e( 'Silk', 'aranya' ); ?></button>
					<button class="shop-filter" data-filter="cotton"><?php esc_html_e( 'Cotton', 'aranya' ); ?></button>
					<button class="shop-filter" data-filter="bridal"><?php esc_html_e( 'Bridal', 'aranya' ); ?></button>
				</div>

				<div class="shop-order">
					<label class="visually-hidden" for="orderby"><?php esc_html_e( 'Sort by', 'aranya' ); ?></label>
					<select id="orderby" name="orderby">
						<option value="menu_order"><?php esc_html_e( 'Featured', 'aranya' ); ?></option>
						<option value="price"><?php esc_html_e( 'Price: low to high', 'aranya' ); ?></option>
						<option value="price-desc"><?php esc_html_e( 'Price: high to low', 'aranya' ); ?></option>
						<option value="date"><?php esc_html_e( 'Newest', 'aranya' ); ?></option>
					</select>
				</div>
			</div>

			<!-- PRODUCT GRID -->
			<ul class="products-grid products-grid--shop">
				<?php
				foreach ( $products as $product ) {
					get_template_part(
						'template-parts/product-card',
						null,
						array(
							'product' => $product,
							'heading' => 'h2',
						)
					);
				}
				?>
			</ul>
		</div>
	</section>

<?php
get_footer();
