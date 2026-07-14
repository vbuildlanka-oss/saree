<?php
/**
 * Demo product dataset.
 *
 * Used by the front-end-only page templates (page-shop.php, page-product.php,
 * front-page.php) so the theme renders a complete storefront immediately,
 * before WooCommerce is installed. Once WooCommerce is active, its own loops
 * and templates take over via /woocommerce/*.php.
 *
 * @package Aranya
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	array(
		'name'     => 'Rani',
		'meta'     => 'Kanjivaram Silk',
		'price'    => '&#8377;&nbsp;48,000',
		'image'    => 'img/saree-1.svg',
		'alt'      => 'Rani — deep maroon Kanjivaram silk saree with gold zari border',
		'badge'    => 'New',
		'category' => 'silk',
	),
	array(
		'name'     => 'Champa',
		'meta'     => 'Banarasi Silk',
		'price'    => '&#8377;&nbsp;52,500',
		'image'    => 'img/saree-2.svg',
		'alt'      => 'Champa — ivory Banarasi silk saree with soft gold motifs',
		'badge'    => '',
		'category' => 'silk',
	),
	array(
		'name'     => 'Raat',
		'meta'     => 'Handloom Cotton',
		'price'    => '&#8377;&nbsp;16,900',
		'image'    => 'img/saree-3.svg',
		'alt'      => 'Raat — charcoal handloom saree with silver border',
		'badge'    => '',
		'category' => 'cotton',
	),
	array(
		'name'     => 'Vana',
		'meta'     => 'Mysore Silk',
		'price'    => '&#8377;&nbsp;39,000',
		'image'    => 'img/saree-4.svg',
		'alt'      => 'Vana — emerald green silk saree with gold zari',
		'badge'    => 'Bridal',
		'category' => 'silk bridal',
	),
	array(
		'name'     => 'Neel',
		'meta'     => 'Chanderi',
		'price'    => '&#8377;&nbsp;28,500',
		'image'    => 'img/saree-5.svg',
		'alt'      => 'Neel — indigo Chanderi saree with silver detailing',
		'badge'    => 'Limited',
		'category' => 'cotton',
	),
	array(
		'name'     => 'Gulaab',
		'meta'     => 'Tussar &amp; Linen',
		'price'    => '&#8377;&nbsp;21,000',
		'image'    => 'img/saree-6.svg',
		'alt'      => 'Gulaab — dusty rose linen saree',
		'badge'    => '',
		'category' => 'cotton',
	),
	array(
		'name'     => 'Haldi',
		'meta'     => 'Handloom Cotton',
		'price'    => '&#8377;&nbsp;14,500',
		'image'    => 'img/saree-7.svg',
		'alt'      => 'Haldi — ochre mustard handloom saree',
		'badge'    => '',
		'category' => 'cotton',
	),
	array(
		'name'     => 'Mor',
		'meta'     => 'Tussar Silk',
		'price'    => '&#8377;&nbsp;33,000',
		'image'    => 'img/saree-8.svg',
		'alt'      => 'Mor — teal silk saree with gold zari',
		'badge'    => '',
		'category' => 'silk',
	),
	array(
		'name'     => 'Rani Legacy',
		'meta'     => 'Bridal Kanjivaram',
		'price'    => '&#8377;&nbsp;86,000',
		'image'    => 'img/saree-1.svg',
		'alt'      => 'Rani Legacy — deep maroon bridal Kanjivaram',
		'badge'    => 'Bridal',
		'category' => 'silk bridal',
	),
	array(
		'name'     => 'Champa Ivory',
		'meta'     => 'Banarasi Silk',
		'price'    => '&#8377;&nbsp;54,000',
		'image'    => 'img/saree-2.svg',
		'alt'      => 'Champa Ivory — pale gold Banarasi',
		'badge'    => '',
		'category' => 'silk',
	),
	array(
		'name'     => 'Vana Emerald',
		'meta'     => 'Mysore Silk',
		'price'    => '&#8377;&nbsp;41,500',
		'image'    => 'img/saree-4.svg',
		'alt'      => 'Vana Emerald — deep green Mysore silk',
		'badge'    => '',
		'category' => 'silk',
	),
	array(
		'name'     => 'Neel Deep',
		'meta'     => 'Chanderi',
		'price'    => '&#8377;&nbsp;30,000',
		'image'    => 'img/saree-5.svg',
		'alt'      => 'Neel Deep — dark indigo Chanderi',
		'badge'    => '',
		'category' => 'cotton',
	),
);
