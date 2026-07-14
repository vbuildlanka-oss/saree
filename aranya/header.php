<?php
/**
 * The header: <head> + site header markup.
 *
 * @package Aranya
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />

	<!-- Remove no-js as early as possible for progressive enhancement. -->
	<script>document.documentElement.classList.remove("no-js");</script>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="screen-reader-text" href="#primary-content"><?php esc_html_e( 'Skip to content', 'aranya' ); ?></a>

<!-- ======================================================================
     SITE HEADER
     ====================================================================== -->
<header class="site-header">
	<div class="site-header__inner">

		<!-- Mobile toggle (hidden on desktop) -->
		<button class="nav-toggle" aria-label="<?php esc_attr_e( 'Toggle navigation', 'aranya' ); ?>" aria-expanded="false" aria-controls="primary-nav">
			<span></span><span></span><span></span>
		</button>

		<!-- Primary navigation -->
		<nav class="site-nav" id="primary-nav" aria-label="<?php esc_attr_e( 'Primary', 'aranya' ); ?>">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'menu_class'     => 'site-nav__list',
						'link_before'    => '',
						'depth'          => 2,
						'fallback_cb'    => 'aranya_primary_menu_fallback',
					)
				);
			} else {
				aranya_primary_menu_fallback();
			}
			?>
		</nav>

		<!-- Brand logo -->
		<?php if ( function_exists( 'has_custom_logo' ) && has_custom_logo() ) : ?>
			<div class="site-brand">
				<?php the_custom_logo(); ?>
			</div>
		<?php else : ?>
			<a class="site-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>, home">
				<img class="site-brand__mark" src="<?php echo esc_url( aranya_asset( 'img/logo-mark.png' ) ); ?>" alt="" width="44" height="44" aria-hidden="true" />
				<span class="site-brand__text"><?php echo esc_html( get_bloginfo( 'name' ) ? get_bloginfo( 'name' ) : 'Aranya' ); ?><span class="site-brand__sub"><?php echo esc_html( get_bloginfo( 'description' ) ? get_bloginfo( 'description' ) : __( 'Handwoven Heirlooms', 'aranya' ) ); ?></span></span>
			</a>
		<?php endif; ?>

		<!-- Utility actions -->
		<div class="site-header__actions">
			<?php
			$account_url = home_url( '/my-account/' );
			$cart_url    = home_url( '/cart/' );
			if ( function_exists( 'wc_get_account_endpoint_url' ) ) {
				$account_url = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
				$cart_url    = wc_get_cart_url();
			}
			?>
			<a class="site-header__action site-header__action--account" href="<?php echo esc_url( $account_url ); ?>"><?php esc_html_e( 'Account', 'aranya' ); ?></a>
			<a class="site-header__action" href="<?php echo esc_url( $cart_url ); ?>"><?php esc_html_e( 'Bag', 'aranya' ); ?>&nbsp;(<span class="cart-count"><?php echo esc_html( aranya_cart_count() ); ?></span>)</a>
		</div>
	</div>
</header>

<main id="primary-content">
