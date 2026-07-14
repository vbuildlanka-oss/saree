<?php
/**
 * Front page (homepage).
 *
 * Converted from the original index.html. Featured products are pulled from
 * WooCommerce when available, otherwise from the demo dataset.
 *
 * @package Aranya
 */

get_header();

// Build the featured product list (first 4).
$featured = array();
if ( class_exists( 'WooCommerce' ) ) {
	$q = new WP_Query(
		array(
			'post_type'      => 'product',
			'posts_per_page' => 4,
			'meta_key'       => '_featured',
			'orderby'        => 'date',
			'order'          => 'DESC',
		)
	);
	// If no explicitly featured products, just grab the latest 4.
	if ( ! $q->have_posts() ) {
		$q = new WP_Query(
			array(
				'post_type'      => 'product',
				'posts_per_page' => 4,
			)
		);
	}
	while ( $q->have_posts() ) {
		$q->the_post();
		global $product;
		$wc_product = wc_get_product( get_the_ID() );
		$featured[] = array(
			'name'  => get_the_title(),
			'meta'  => wc_get_product_category_list( get_the_ID() ) ? wp_strip_all_tags( wc_get_product_category_list( get_the_ID() ) ) : '',
			'price' => $wc_product ? $wc_product->get_price_html() : '',
			'image' => '', // handled below via link/thumb.
			'link'  => get_permalink(),
			'badge' => '',
		);
	}
	wp_reset_postdata();
}

if ( empty( $featured ) ) {
	$demo     = aranya_get_demo_products();
	$featured = array_slice(
		array( $demo[0], $demo[1], $demo[3], $demo[4] ), // Rani, Champa, Vana, Neel
		0,
		4
	);
}
?>

	<!-- HERO -->
	<section class="hero">
		<div class="hero__media">
			<video autoplay muted loop playsinline poster="<?php echo esc_url( aranya_asset( 'img/hero.svg' ) ); ?>"></video>
		</div>
		<div class="hero__overlay" aria-hidden="true"></div>

		<div class="container">
			<div class="hero__content">
				<p class="overline hero__overline"><?php esc_html_e( 'The Winter Weaves — 2026', 'aranya' ); ?></p>
				<h1 class="hero__title"><?php esc_html_e( 'Woven for the ones who notice', 'aranya' ); ?></h1>
				<p class="hero__lead">
					<?php esc_html_e( 'Heirloom sarees, made slowly on the handloom. Rare silks, natural dyes, and a restraint you can feel in the drape.', 'aranya' ); ?>
				</p>
				<div class="hero__actions">
					<a class="btn btn--primary" href="<?php echo esc_url( aranya_shop_url() ); ?>"><?php esc_html_e( 'Explore the collection', 'aranya' ); ?></a>
					<a class="btn btn--ghost" href="#craft"><?php esc_html_e( 'The craft', 'aranya' ); ?></a>
				</div>
			</div>
		</div>

		<div class="hero__scroll-cue" aria-hidden="true">
			<span><?php esc_html_e( 'Scroll', 'aranya' ); ?></span>
			<span class="line"></span>
		</div>
	</section>

	<!-- INTRO / BRAND STATEMENT -->
	<section class="section intro">
		<div class="container">
			<p class="overline"><?php esc_html_e( 'Aranya — meaning "of the forest"', 'aranya' ); ?></p>
			<p class="intro__statement">
				<?php echo wp_kses_post( __( 'A saree is not bought. It is <em>chosen</em>, kept, and passed on.', 'aranya' ) ); ?>
			</p>
		</div>
	</section>

	<!-- FEATURED COLLECTION -->
	<section class="section bg-ivory-deep" id="featured">
		<div class="container">
			<div class="section-header section-header--center">
				<p class="overline"><?php esc_html_e( 'Newly on the loom', 'aranya' ); ?></p>
				<h2 class="section-header__title"><?php esc_html_e( 'The Featured Weaves', 'aranya' ); ?></h2>
				<hr class="rule-gold" />
			</div>

			<ul class="products-grid products-grid--featured">
				<?php
				foreach ( $featured as $product ) {
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

			<div class="text-center" style="margin-top: var(--space-lg);">
				<a class="link-underline" href="<?php echo esc_url( aranya_shop_url() ); ?>"><?php esc_html_e( 'View the full collection', 'aranya' ); ?></a>
			</div>
		</div>
	</section>

	<!-- CRAFTSMANSHIP -->
	<section class="story" id="craft">
		<div class="container">
			<div class="story__inner">
				<div class="story__aside">
					<p class="overline story__eyebrow"><?php esc_html_e( 'The making', 'aranya' ); ?></p>
					<h2 class="story__heading"><?php esc_html_e( 'Four hands, four months, one saree', 'aranya' ); ?></h2>
					<p class="text-muted">
						<?php esc_html_e( 'Every Aranya weave passes through a small circle of artisans. Nothing is rushed; the loom keeps its own time.', 'aranya' ); ?>
					</p>
				</div>

				<div class="story__panels">
					<article class="story-panel">
						<span class="story-panel__index">01</span>
						<h3 class="story-panel__title"><?php esc_html_e( 'The yarn is dyed by hand', 'aranya' ); ?></h3>
						<p class="story-panel__text">
							<?php esc_html_e( 'Mulberry silk is steeped in small batches of natural dye — madder root for maroon, marigold for gold. No two lots are identical, and that is the point.', 'aranya' ); ?>
						</p>
					</article>
					<article class="story-panel">
						<span class="story-panel__index">02</span>
						<h3 class="story-panel__title"><?php esc_html_e( 'The zari is real', 'aranya' ); ?></h3>
						<p class="story-panel__text">
							<?php esc_html_e( 'Fine threads of silver are gilded and wound by hand before a single row is woven. You can feel the weight of it in the pallu.', 'aranya' ); ?>
						</p>
					</article>
					<article class="story-panel">
						<span class="story-panel__index">03</span>
						<h3 class="story-panel__title"><?php esc_html_e( 'The loom does the rest — slowly', 'aranya' ); ?></h3>
						<p class="story-panel__text">
							<?php esc_html_e( 'A master weaver sets perhaps two inches a day. Four months later, a saree leaves the loom that will outlast its maker.', 'aranya' ); ?>
						</p>
					</article>
				</div>
			</div>
		</div>
	</section>

	<!-- EDITORIAL SPLIT BANNER -->
	<section class="editorial" id="story">
		<div class="editorial__media">
			<img src="<?php echo esc_url( aranya_asset( 'img/editorial-1.svg' ) ); ?>" alt="<?php esc_attr_e( 'Detail of a handwoven maroon and gold saree pallu', 'aranya' ); ?>" loading="lazy" />
		</div>
		<div class="editorial__body">
			<p class="overline"><?php esc_html_e( 'Our story', 'aranya' ); ?></p>
			<h2><?php esc_html_e( 'Begun in a weaving town you have never heard of', 'aranya' ); ?></h2>
			<p>
				<?php esc_html_e( 'Aranya works with fewer than forty looms across three villages. We buy no more than they can make well, and we sign every saree with the name of the hands that wove it.', 'aranya' ); ?>
			</p>
			<a class="link-underline" href="#"><?php esc_html_e( 'Read the full story', 'aranya' ); ?></a>
		</div>
	</section>

	<!-- JOURNAL TEASER + NEWSLETTER -->
	<section class="section text-center invite" id="journal">
		<div class="container">
			<p class="overline"><?php esc_html_e( 'Stay close to the loom', 'aranya' ); ?></p>
			<h2 class="section-header__title"><?php esc_html_e( 'Letters from Aranya', 'aranya' ); ?></h2>
			<p class="text-muted" style="margin-inline:auto;">
				<?php esc_html_e( 'New weaves, quiet drops, and the occasional note on caring for silk.', 'aranya' ); ?>
			</p>
			<form class="invite__form" action="#" method="post" onsubmit="return false;">
				<label class="visually-hidden" for="email"><?php esc_html_e( 'Email address', 'aranya' ); ?></label>
				<input class="invite__input" id="email" type="email" placeholder="<?php esc_attr_e( 'Your email address', 'aranya' ); ?>" required />
				<button class="btn btn--primary" type="submit"><?php esc_html_e( 'Subscribe', 'aranya' ); ?></button>
			</form>
		</div>
	</section>

<?php
get_footer();
