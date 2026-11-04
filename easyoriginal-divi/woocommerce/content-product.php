<?php
/**
 * Produktkarte in Listen (Shop, Kategorien, Divi-Modul „Shop“, ähnliche Produkte).
 *
 * Überschreibt woocommerce/templates/content-product.php.
 *
 * @package easyoriginal
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( 'eo-li', $product ); ?>>
	<?php echo eo_card( $product, array( 'heading' => 'h2' ) ); // phpcs:ignore ?>
</li>
