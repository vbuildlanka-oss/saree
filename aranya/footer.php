<?php
/**
 * The footer: closes <main>, outputs the site footer + toast + wp_footer.
 *
 * @package Aranya
 */
?>
</main><!-- #primary-content -->

<!-- ======================================================================
     SITE FOOTER
     ====================================================================== -->
<footer class="site-footer">
	<div class="container">
		<div class="site-footer__top">
			<div class="site-footer__brand-col">
				<img class="site-footer__mark" src="<?php echo esc_url( aranya_asset( 'img/logo-mark.png' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ? get_bloginfo( 'name' ) : 'Aranya' ); ?>" width="56" height="56" />
				<p class="site-footer__brand"><?php echo esc_html( get_bloginfo( 'name' ) ? get_bloginfo( 'name' ) : 'Aranya' ); ?></p>
				<p class="site-footer__tagline">
					<?php echo esc_html( get_bloginfo( 'description' ) ? get_bloginfo( 'description' ) : __( 'Handwoven luxury sarees. Made slowly, meant to be kept.', 'aranya' ) ); ?>
				</p>
			</div>

			<div class="footer-col">
				<h4 class="footer-col__heading"><?php esc_html_e( 'Shop', 'aranya' ); ?></h4>
				<?php aranya_footer_menu( 'footer-shop', 'aranya_footer_shop_fallback' ); ?>
			</div>

			<div class="footer-col">
				<h4 class="footer-col__heading"><?php esc_html_e( 'The house', 'aranya' ); ?></h4>
				<?php aranya_footer_menu( 'footer-house', 'aranya_footer_house_fallback' ); ?>
			</div>

			<div class="footer-col">
				<h4 class="footer-col__heading"><?php esc_html_e( 'Care', 'aranya' ); ?></h4>
				<?php aranya_footer_menu( 'footer-care', 'aranya_footer_care_fallback' ); ?>
			</div>
		</div>

		<div class="site-footer__bottom">
			<span>&copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ? get_bloginfo( 'name' ) : 'Aranya Weaves' ); ?></span>
			<span><?php esc_html_e( 'Handwoven in India', 'aranya' ); ?></span>
		</div>
	</div>
</footer>

<!-- "Added to bag" toast (front-end placeholder / WooCommerce AJAX target). -->
<div class="toast" role="status" aria-live="polite">
	<span class="dot" aria-hidden="true"></span>
	<span class="toast__message"></span>
</div>

<?php wp_footer(); ?>
</body>
</html>
