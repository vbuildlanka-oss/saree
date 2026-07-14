<?php
/**
 * Template Name: Product Demo
 *
 * Front-end single-product page. Reproduces the original product.html layout
 * (gallery + summary + variation selectors + accordions + related weaves),
 * powered by assets/js/product.js.
 *
 * NOTE: When WooCommerce is installed, real products use
 * woocommerce/single-product.php instead. This template is a self-contained
 * demo for the front-end showcase.
 *
 * @package Aranya
 */

get_header();

$demo    = aranya_get_demo_products();
$related = array( $demo[1], $demo[3], $demo[8], $demo[7] ); // Champa, Vana, Rani Legacy, Mor
?>

	<div class="single-product">
		<div class="container">
			<!-- Breadcrumb -->
			<nav class="breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'aranya' ); ?>">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'aranya' ); ?></a><span>/</span>
				<a href="<?php echo esc_url( aranya_shop_url() ); ?>"><?php esc_html_e( 'Collection', 'aranya' ); ?></a><span>/</span>
				<?php echo esc_html( get_the_title() ? get_the_title() : 'Rani' ); ?>
			</nav>

			<div class="product-layout">
				<!-- PRODUCT GALLERY -->
				<div class="product-gallery" data-gallery>
					<div class="product-gallery__stage" data-gallery-stage>
						<img class="product-gallery__image" data-gallery-main
							src="<?php echo esc_url( aranya_asset( 'img/product-1-a.svg' ) ); ?>"
							alt="<?php esc_attr_e( 'Rani Kanjivaram silk saree — full drape', 'aranya' ); ?>" />
					</div>
					<div class="product-gallery__thumbs" role="tablist" aria-label="<?php esc_attr_e( 'Product images', 'aranya' ); ?>">
						<?php
						$thumbs = array(
							array( 'img/product-1-a.svg', __( 'Rani — full drape', 'aranya' ) ),
							array( 'img/product-1-b.svg', __( 'Rani — pallu detail', 'aranya' ) ),
							array( 'img/product-1-c.svg', __( 'Rani — border zari detail', 'aranya' ) ),
							array( 'img/product-1-d.svg', __( 'Rani — draped on model', 'aranya' ) ),
						);
						foreach ( $thumbs as $i => $thumb ) :
							$src = aranya_asset( $thumb[0] );
							?>
							<button class="product-gallery__thumb<?php echo 0 === $i ? ' is-active' : ''; ?>" role="tab" aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>" data-gallery-thumb="<?php echo esc_url( $src ); ?>">
								<img src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $thumb[1] ); ?>" />
							</button>
						<?php endforeach; ?>
					</div>
				</div>

				<!-- PRODUCT SUMMARY -->
				<div class="product-summary">
					<p class="overline"><?php esc_html_e( 'Kanjivaram Silk · Handwoven', 'aranya' ); ?></p>
					<h1 class="product-summary__title"><?php echo esc_html( get_the_title() ? get_the_title() : 'Rani' ); ?></h1>
					<p class="product-summary__price">&#8377;&nbsp;48,000</p>

					<p class="product-summary__excerpt">
						<?php esc_html_e( 'A deep madder-dyed Kanjivaram with a contrast pallu and real gold zari woven along the border. Four months on a single loom, signed by its weaver. One of eight.', 'aranya' ); ?>
					</p>

					<!-- VARIATION SELECTORS -->
					<form class="product-form" action="#" method="post" onsubmit="return false;">
						<div class="product-option" data-option="color">
							<span class="product-option__label">
								<?php esc_html_e( 'Colour', 'aranya' ); ?> <span class="selected-value" data-selected><?php esc_html_e( 'Maroon', 'aranya' ); ?></span>
							</span>
							<div class="swatches" role="radiogroup" aria-label="<?php esc_attr_e( 'Colour', 'aranya' ); ?>">
								<button type="button" class="swatch is-selected" role="radio" aria-checked="true" data-value="Maroon" style="background:#5b1a24" aria-label="Maroon"></button>
								<button type="button" class="swatch" role="radio" aria-checked="false" data-value="Emerald" style="background:#1f4034" aria-label="Emerald"></button>
								<button type="button" class="swatch" role="radio" aria-checked="false" data-value="Indigo" style="background:#28324f" aria-label="Indigo"></button>
								<button type="button" class="swatch" role="radio" aria-checked="false" data-value="Ivory" style="background:#efe8dc" aria-label="Ivory"></button>
							</div>
						</div>

						<div class="product-option" data-option="fabric">
							<span class="product-option__label">
								<?php esc_html_e( 'Fabric', 'aranya' ); ?> <span class="selected-value" data-selected><?php esc_html_e( 'Pure Silk', 'aranya' ); ?></span>
							</span>
							<div class="pills" role="radiogroup" aria-label="<?php esc_attr_e( 'Fabric', 'aranya' ); ?>">
								<button type="button" class="pill is-selected" role="radio" aria-checked="true" data-value="Pure Silk">Pure Silk</button>
								<button type="button" class="pill" role="radio" aria-checked="false" data-value="Silk Blend">Silk Blend</button>
							</div>
						</div>

						<div class="product-option" data-option="size">
							<span class="product-option__label">
								<?php esc_html_e( 'Blouse piece', 'aranya' ); ?> <span class="selected-value" data-selected>0.8m</span>
							</span>
							<div class="pills" role="radiogroup" aria-label="<?php esc_attr_e( 'Blouse piece', 'aranya' ); ?>">
								<button type="button" class="pill is-selected" role="radio" aria-checked="true" data-value="0.8m">0.8m</button>
								<button type="button" class="pill" role="radio" aria-checked="false" data-value="1.0m">1.0m</button>
								<button type="button" class="pill" role="radio" aria-checked="false" data-value="None">None</button>
							</div>
						</div>

						<div class="product-cart-row">
							<div class="qty-stepper" data-qty>
								<button type="button" data-qty-decrease aria-label="<?php esc_attr_e( 'Decrease quantity', 'aranya' ); ?>">&minus;</button>
								<label class="visually-hidden" for="quantity"><?php esc_html_e( 'Quantity', 'aranya' ); ?></label>
								<input id="quantity" type="number" value="1" min="1" inputmode="numeric" />
								<button type="button" data-qty-increase aria-label="<?php esc_attr_e( 'Increase quantity', 'aranya' ); ?>">+</button>
							</div>
							<button class="btn btn--primary btn--block" data-add-to-cart data-product-name="<?php echo esc_attr( get_the_title() ? get_the_title() : 'Rani' ); ?>"><?php esc_html_e( 'Add to bag', 'aranya' ); ?></button>
						</div>
					</form>

					<!-- PRODUCT DETAIL ACCORDIONS -->
					<div class="product-accordion" data-accordion>
						<div class="accordion-item is-open">
							<button class="accordion-trigger" aria-expanded="true">
								<?php esc_html_e( 'Description', 'aranya' ); ?> <span class="icon">+</span>
							</button>
							<div class="accordion-panel">
								<div class="accordion-panel__inner">
									<p><?php esc_html_e( 'Rani is woven from pure mulberry silk, dyed with madder root for its characteristic depth. The contrast pallu carries a traditional temple border in genuine gold zari. Because each saree is dyed in a small batch, slight variation in tone is a signature of the hand, not a flaw.', 'aranya' ); ?></p>
								</div>
							</div>
						</div>
						<div class="accordion-item">
							<button class="accordion-trigger" aria-expanded="false">
								<?php esc_html_e( 'Fabric &amp; weave', 'aranya' ); ?> <span class="icon">+</span>
							</button>
							<div class="accordion-panel">
								<div class="accordion-panel__inner">
									<p><?php esc_html_e( 'Pure Kanjivaram mulberry silk · genuine gold-dipped zari · 6.3m length + blouse piece · approx. 780g.', 'aranya' ); ?></p>
								</div>
							</div>
						</div>
						<div class="accordion-item">
							<button class="accordion-trigger" aria-expanded="false">
								<?php esc_html_e( 'Care &amp; shipping', 'aranya' ); ?> <span class="icon">+</span>
							</button>
							<div class="accordion-panel">
								<div class="accordion-panel__inner">
									<p><?php esc_html_e( 'Dry clean only. Store folded in muslin, away from light. Insured shipping worldwide; 7-day returns on unworn pieces.', 'aranya' ); ?></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- RELATED PRODUCTS -->
			<section class="related">
				<div class="section-header section-header--center">
					<p class="overline"><?php esc_html_e( 'You may also love', 'aranya' ); ?></p>
					<h2 class="section-header__title"><?php esc_html_e( 'Related Weaves', 'aranya' ); ?></h2>
					<hr class="rule-gold" />
				</div>

				<ul class="products-grid products-grid--featured">
					<?php
					foreach ( $related as $product ) {
						get_template_part(
							'template-parts/product-card',
							null,
							array(
								'product' => $product,
								'heading' => 'h3',
							)
						);
					}
					?>
				</ul>
			</section>
		</div>
	</div>

<?php
get_footer();
