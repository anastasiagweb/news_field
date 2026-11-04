<?php
/**
 * easyOriginal 2026 – Child-Theme für Divi 4.
 *
 * Aufbau:
 *   inc/helpers.php      Hilfsfunktionen (Titel teilen, Sprache/Niveau erkennen, Cover-Farbe, Produktkarte)
 *   inc/setup.php        Skripte/Styles, Design-Variante, Menüs, Body-Klassen, Divi-Anpassungen
 *   inc/customizer.php   Einstellungen unter „Design → Customizer → easyOriginal“
 *   inc/nav.php          Hauptmenü mit Mega-Menü (Walker) und Fallback-Menüs
 *   inc/home.php         Bausteine der Startseite (auch als Shortcodes nutzbar)
 *   inc/woocommerce.php  Produktkarten, Kategorie-Kopf, Niveau-Filter, Produktseite, Leseprobe
 *   inc/metabox.php      Zusatzfelder am Produkt (Untertitel, Autor, Leseprobe, Audio)
 *
 * @package easyoriginal
 */

defined( 'ABSPATH' ) || exit;

define( 'EO_THEME_VERSION', '1.0.0' );
define( 'EO_THEME_DIR', get_stylesheet_directory() );
define( 'EO_THEME_URI', get_stylesheet_directory_uri() );

require_once EO_THEME_DIR . '/inc/helpers.php';
require_once EO_THEME_DIR . '/inc/setup.php';
require_once EO_THEME_DIR . '/inc/customizer.php';
require_once EO_THEME_DIR . '/inc/nav.php';
require_once EO_THEME_DIR . '/inc/home.php';
require_once EO_THEME_DIR . '/inc/metabox.php';

if ( class_exists( 'WooCommerce' ) ) {
	require_once EO_THEME_DIR . '/inc/woocommerce.php';
}
