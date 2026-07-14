<?php
/**
 * Reusable product card (front-end demo).
 *
 * Mirrors WooCommerce's content-product.php loop item so the same markup can
 * later be produced by the_loop(). Expects $args['product'] (array) and
 * optionally $args['heading'] ('h2' | 'h3', default 'h3').
 *
 * @package Aranya
 */

$product = isset( $args['product'] ) ? $args['product'] : null;
if ( ! $product ) {
	return;
}

$heading  = isset( $args['heading'] ) ? $args['heading'] : 'h3';
$link     = isset( $product['link'] ) ? $product['link'] : aranya_product_demo_url();
$image    = isset( $product['image'] ) ? aranya_asset( $product['image'] ) : aranya_asset( 'img/saree-1.svg' );
$category = isset( $product['category'] ) ? $product['category'] : '';
?>
<li class="product-card"<?php echo $category ? ' data-category="' . esc_attr( $category ) . '"' : ''; ?>>
	<div class="product-card__media">
		<?php if ( ! empty( $product['badge'] ) ) : ?>
			<span class="product-card__badge"><?php echo esc_html( $product['badge'] ); ?></span>
		<?php endif; ?>

		<a href="<?php echo esc_url( $link ); ?>" aria-label="<?php echo esc_attr( sprintf( 'View %s', $product['name'] ) ); ?>">
			<img class="product-card__image" src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( isset( $product['alt'] ) ? $product['alt'] : $product['name'] ); ?>" loading="lazy" />
		</a>

		<div class="product-card__actions">
			<button class="btn btn--primary btn--block" data-add-to-cart data-product-name="<?php echo esc_attr( $product['name'] ); ?>"><?php esc_html_e( 'Add to bag', 'aranya' ); ?></button>
		</div>
	</div>

	<div class="product-card__body">
		<span class="product-card__meta"><?php echo wp_kses_post( $product['meta'] ); ?></span>
		<<?php echo esc_html( $heading ); ?> class="product-card__title"><a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $product['name'] ); ?></a></<?php echo esc_html( $heading ); ?>>
		<p class="product-card__price"><?php echo wp_kses_post( $product['price'] ); ?></p>
	</div>
</li>
