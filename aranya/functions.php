<?php
/**
 * Aranya theme functions and definitions.
 *
 * @package Aranya
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access.
}

if ( ! defined( 'ARANYA_VERSION' ) ) {
	define( 'ARANYA_VERSION', '1.0.0' );
}

/* =========================================================================
 * 1. Theme setup
 * ========================================================================= */
if ( ! function_exists( 'aranya_setup' ) ) {
	function aranya_setup() {
		// Make the theme available for translation.
		load_theme_textdomain( 'aranya', get_template_directory() . '/languages' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Output valid HTML5 markup for core features.
		add_theme_support(
			'html5',
			array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
		);

		// Featured images (used as product / post thumbnails).
		add_theme_support( 'post-thumbnails' );

		// RSS feed links in <head>.
		add_theme_support( 'automatic-feed-links' );

		// Custom logo — maps to the .site-brand__mark in the header.
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 88,
				'width'       => 88,
				'flex-height' => true,
				'flex-width'  => true,
			)
		);

		// Selective refresh for widgets in the Customizer.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Register navigation menus (matches the original markup).
		register_nav_menus(
			array(
				'primary'     => __( 'Primary Navigation', 'aranya' ),
				'footer-shop' => __( 'Footer — Shop', 'aranya' ),
				'footer-house' => __( 'Footer — The House', 'aranya' ),
				'footer-care' => __( 'Footer — Care', 'aranya' ),
			)
		);
	}
}
add_action( 'after_setup_theme', 'aranya_setup' );

/* =========================================================================
 * 2. Enqueue styles & scripts
 *    Order matters: tokens -> layout -> components -> pages (as in the
 *    original static site).
 * ========================================================================= */
function aranya_enqueue_assets() {
	$uri = get_template_directory_uri();

	// Google Fonts: Cormorant Garamond (headings) + Jost (body).
	wp_enqueue_style(
		'aranya-fonts',
		'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=Jost:wght@300;400;500&display=swap',
		array(),
		null
	);

	wp_enqueue_style( 'aranya-base', $uri . '/assets/css/base.css', array(), ARANYA_VERSION );
	wp_enqueue_style( 'aranya-layout', $uri . '/assets/css/layout.css', array( 'aranya-base' ), ARANYA_VERSION );
	wp_enqueue_style( 'aranya-components', $uri . '/assets/css/components.css', array( 'aranya-layout' ), ARANYA_VERSION );
	wp_enqueue_style( 'aranya-pages', $uri . '/assets/css/pages.css', array( 'aranya-components' ), ARANYA_VERSION );

	// WooCommerce bridge styles (only when the plugin is active).
	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_style( 'aranya-woocommerce', $uri . '/assets/css/woocommerce.css', array( 'aranya-pages' ), ARANYA_VERSION );
	}

	// The main stylesheet (theme header + helpers). Loaded last.
	wp_enqueue_style( 'aranya-style', get_stylesheet_uri(), array( 'aranya-pages' ), ARANYA_VERSION );

	// Shared JS (header state, mobile nav, cart toast placeholder).
	wp_enqueue_script( 'aranya-main', $uri . '/assets/js/main.js', array(), ARANYA_VERSION, true );

	// Page-specific JS.
	if ( aranya_is_shop() ) {
		wp_enqueue_script( 'aranya-shop', $uri . '/assets/js/shop.js', array( 'aranya-main' ), ARANYA_VERSION, true );
	}

	if ( aranya_is_product() ) {
		wp_enqueue_script( 'aranya-product', $uri . '/assets/js/product.js', array( 'aranya-main' ), ARANYA_VERSION, true );
	}

	// Threaded comments where applicable.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'aranya_enqueue_assets' );

/* =========================================================================
 * 3. Template detection helpers
 *    These allow the theme to work WITH or WITHOUT WooCommerce.
 * ========================================================================= */

/**
 * Is the current view the shop / collection archive?
 * True for the WooCommerce shop archive OR the "Shop Collection" page template.
 */
function aranya_is_shop() {
	if ( function_exists( 'is_shop' ) && ( is_shop() || is_product_category() || is_product_tag() ) ) {
		return true;
	}
	return is_page_template( 'page-shop.php' );
}

/**
 * Is the current view a single product?
 * True for the WooCommerce single product OR the "Product Demo" page template.
 */
function aranya_is_product() {
	if ( function_exists( 'is_product' ) && is_product() ) {
		return true;
	}
	return is_page_template( 'page-product.php' );
}

/* =========================================================================
 * 4. WooCommerce support (optional — only active if the plugin is installed)
 * ========================================================================= */
function aranya_woocommerce_support() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'aranya_woocommerce_support' );

/**
 * Output the live cart count for the header bag link when WooCommerce is active.
 * Falls back to 0 for the static demo.
 */
function aranya_cart_count() {
	if ( class_exists( 'WooCommerce' ) && WC()->cart ) {
		return WC()->cart->get_cart_contents_count();
	}
	return 0;
}

/* =========================================================================
 * 5. Footer widget areas (optional customisation points)
 * ========================================================================= */
function aranya_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Footer Newsletter', 'aranya' ),
			'id'            => 'footer-newsletter',
			'description'   => __( 'Optional widget area shown in the journal / newsletter section.', 'aranya' ),
			'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="footer-col__heading">',
			'after_title'   => '</h4>',
		)
	);
}
add_action( 'widgets_init', 'aranya_widgets_init' );

/* =========================================================================
 * 6. Helpers
 * ========================================================================= */

/**
 * Return a theme asset URL.
 *
 * @param string $path Relative path inside /assets.
 * @return string
 */
function aranya_asset( $path ) {
	return get_template_directory_uri() . '/assets/' . ltrim( $path, '/' );
}

/**
 * Load the demo product dataset (used by the front-end-only templates).
 *
 * @return array
 */
function aranya_get_demo_products() {
	return include get_template_directory() . '/inc/demo-products.php';
}

/**
 * Add sensible body classes.
 */
function aranya_body_classes( $classes ) {
	if ( aranya_is_shop() ) {
		$classes[] = 'aranya-shop';
	}
	if ( aranya_is_product() ) {
		$classes[] = 'aranya-single-product';
	}
	return $classes;
}
add_filter( 'body_class', 'aranya_body_classes' );


/* =========================================================================
 * 7. Menu fallbacks
 *    These reproduce the original static navigation so the theme looks
 *    correct on first activation, before the user assigns real menus.
 * ========================================================================= */

/**
 * Primary navigation fallback (mirrors the original header markup).
 */
function aranya_primary_menu_fallback() {
	$shop_url = aranya_shop_url();
	?>
	<ul class="site-nav__list">
		<li><a class="site-nav__link" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Collection', 'aranya' ); ?></a></li>
		<li><a class="site-nav__link" href="<?php echo esc_url( home_url( '/#craft' ) ); ?>"><?php esc_html_e( 'Craft', 'aranya' ); ?></a></li>
		<li><a class="site-nav__link" href="<?php echo esc_url( home_url( '/#story' ) ); ?>"><?php esc_html_e( 'Our Story', 'aranya' ); ?></a></li>
		<li><a class="site-nav__link" href="<?php echo esc_url( home_url( '/#journal' ) ); ?>"><?php esc_html_e( 'Journal', 'aranya' ); ?></a></li>
	</ul>
	<?php
}

/**
 * Render a footer menu with a fallback callback.
 *
 * @param string $location    Registered menu location.
 * @param string $fallback_cb Fallback function name.
 */
function aranya_footer_menu( $location, $fallback_cb ) {
	if ( has_nav_menu( $location ) ) {
		wp_nav_menu(
			array(
				'theme_location' => $location,
				'container'      => false,
				'menu_class'     => 'footer-col__list',
				'depth'          => 1,
				'fallback_cb'    => $fallback_cb,
			)
		);
	} elseif ( is_callable( $fallback_cb ) ) {
		call_user_func( $fallback_cb );
	}
}

function aranya_footer_shop_fallback() {
	$shop_url = aranya_shop_url();
	?>
	<ul class="footer-col__list">
		<li><a href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'All sarees', 'aranya' ); ?></a></li>
		<li><a href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Silk', 'aranya' ); ?></a></li>
		<li><a href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Handloom cotton', 'aranya' ); ?></a></li>
		<li><a href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Bridal', 'aranya' ); ?></a></li>
	</ul>
	<?php
}

function aranya_footer_house_fallback() {
	?>
	<ul class="footer-col__list">
		<li><a href="<?php echo esc_url( home_url( '/#story' ) ); ?>"><?php esc_html_e( 'Our story', 'aranya' ); ?></a></li>
		<li><a href="<?php echo esc_url( home_url( '/#craft' ) ); ?>"><?php esc_html_e( 'Craftsmanship', 'aranya' ); ?></a></li>
		<li><a href="<?php echo esc_url( home_url( '/#journal' ) ); ?>"><?php esc_html_e( 'Journal', 'aranya' ); ?></a></li>
		<li><a href="#"><?php esc_html_e( 'Stockists', 'aranya' ); ?></a></li>
	</ul>
	<?php
}

function aranya_footer_care_fallback() {
	?>
	<ul class="footer-col__list">
		<li><a href="#"><?php esc_html_e( 'Shipping &amp; returns', 'aranya' ); ?></a></li>
		<li><a href="#"><?php esc_html_e( 'Saree care', 'aranya' ); ?></a></li>
		<li><a href="#"><?php esc_html_e( 'Contact', 'aranya' ); ?></a></li>
		<li><a href="#"><?php esc_html_e( 'FAQ', 'aranya' ); ?></a></li>
	</ul>
	<?php
}

/**
 * Resolve the best URL for the "Collection" / shop link.
 * Prefers the WooCommerce shop, then a page using the Shop template, then home.
 */
function aranya_shop_url() {
	if ( function_exists( 'wc_get_page_id' ) ) {
		$shop_id = wc_get_page_id( 'shop' );
		if ( $shop_id && $shop_id > 0 ) {
			return get_permalink( $shop_id );
		}
	}

	$shop_page = get_pages(
		array(
			'meta_key'   => '_wp_page_template',
			'meta_value' => 'page-shop.php',
			'number'     => 1,
		)
	);
	if ( ! empty( $shop_page ) ) {
		return get_permalink( $shop_page[0]->ID );
	}

	return home_url( '/' );
}


/**
 * Resolve the URL for the demo single-product page (page-product.php template).
 * Falls back to the shop URL, then home.
 */
function aranya_product_demo_url() {
	$product_page = get_pages(
		array(
			'meta_key'   => '_wp_page_template',
			'meta_value' => 'page-product.php',
			'number'     => 1,
		)
	);
	if ( ! empty( $product_page ) ) {
		return get_permalink( $product_page[0]->ID );
	}
	return aranya_shop_url();
}
