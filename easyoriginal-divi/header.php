<?php
/**
 * Kopfbereich (ersetzt die Divi-Kopfzeile).
 *
 * Hinweis: Ist in „Divi → Theme Builder“ eine globale Kopfzeile aktiv, zeigt Divi diese
 * statt dieser Datei. Dann dort die globale Kopfzeile ausschalten.
 *
 * @package easyoriginal
 */

defined( 'ABSPATH' ) || exit;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
wp_body_open();
get_template_part( 'template-parts/sprite' );
$eo_cart_count = ( function_exists( 'WC' ) && WC()->cart ) ? WC()->cart->get_cart_contents_count() : 0;
$eo_search_pt  = class_exists( 'WooCommerce' ) ? 'product' : '';
?>
<a class="skip-link" href="#main-content"><?php esc_html_e( 'Zum Inhalt springen', 'easyoriginal' ); ?></a>
<div id="page-container">

<div class="topbar">
	<div class="container">
		<p><?php echo eo_icon( 'truck' ); // phpcs:ignore ?> <?php echo esc_html( eo_opt( 'topbar_text' ) ); ?></p>
		<nav aria-label="<?php esc_attr_e( 'Service', 'easyoriginal' ); ?>">
			<?php foreach ( eo_service_items() as $eo_item ) : ?>
				<a<?php echo eo_link_attrs( $eo_item ); // phpcs:ignore ?>><?php echo esc_html( $eo_item['title'] ); ?></a>
			<?php endforeach; ?>
		</nav>
	</div>
</div>

<header class="header">
	<div class="container header__inner">
		<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) . ' – ' . __( 'Startseite', 'easyoriginal' ) ); ?>">
			<img src="<?php echo esc_url( eo_logo_url() ); ?>" width="500" height="103" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
		</a>

		<?php eo_render_primary_nav(); ?>

		<div class="header__actions">
			<form class="site-search" role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
				<?php echo eo_icon( 'search' ); // phpcs:ignore ?>
				<label class="sr-only" for="eo-s-top"><?php esc_html_e( 'Bücher suchen', 'easyoriginal' ); ?></label>
				<input id="eo-s-top" type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Titel, Autor, Sprache …', 'easyoriginal' ); ?>">
				<?php if ( $eo_search_pt ) : ?><input type="hidden" name="post_type" value="product"><?php endif; ?>
			</form>
			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
				<a class="icon-btn" href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" aria-label="<?php esc_attr_e( 'Mein Konto', 'easyoriginal' ); ?>"><?php echo eo_icon( 'user' ); // phpcs:ignore ?></a>
				<a class="icon-btn" href="<?php echo esc_url( wc_get_cart_url() ); ?>" aria-label="<?php esc_attr_e( 'Warenkorb', 'easyoriginal' ); ?>"><?php echo eo_icon( 'bag' ); // phpcs:ignore ?><span class="cart-count" data-count="<?php echo (int) $eo_cart_count; ?>"><?php echo (int) $eo_cart_count; ?></span></a>
			<?php endif; ?>
			<button class="icon-btn burger" type="button" data-drawer-open aria-controls="drawer" aria-label="<?php esc_attr_e( 'Menü öffnen', 'easyoriginal' ); ?>"><?php echo eo_icon( 'menu' ); // phpcs:ignore ?></button>
		</div>
	</div>
</header>

<div class="drawer" id="drawer" aria-hidden="true">
	<div class="drawer__backdrop" data-drawer-close></div>
	<div class="drawer__panel" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Menü', 'easyoriginal' ); ?>">
		<div class="drawer__top">
			<img src="<?php echo esc_url( eo_logo_url() ); ?>" width="130" height="27" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
			<button class="icon-btn drawer__close" type="button" data-drawer-close aria-label="<?php esc_attr_e( 'Menü schließen', 'easyoriginal' ); ?>"><?php echo eo_icon( 'close' ); // phpcs:ignore ?></button>
		</div>
		<form class="site-search" role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
			<?php echo eo_icon( 'search' ); // phpcs:ignore ?>
			<label class="sr-only" for="eo-s-drawer"><?php esc_html_e( 'Bücher suchen', 'easyoriginal' ); ?></label>
			<input id="eo-s-drawer" type="search" name="s" placeholder="<?php esc_attr_e( 'Titel, Autor, Sprache …', 'easyoriginal' ); ?>">
			<?php if ( $eo_search_pt ) : ?><input type="hidden" name="post_type" value="product"><?php endif; ?>
		</form>
		<?php eo_render_drawer_nav(); ?>
	</div>
</div>

<div id="et-main-area">
