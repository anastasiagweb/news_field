<?php
/**
 * Navigation: WordPress-Menüs als Baum, Mega-Menü und Fallbacks.
 *
 * Mega-Menü im Hauptmenü: Geben Sie einem Menüpunkt der obersten Ebene die CSS-Klasse „eo-mega“
 * (Design → Menüs → Ansicht-Optionen → CSS-Klassen). Seine Unterpunkte werden zu Spalten;
 * mit der Klasse „lang-en“, „lang-fr“ … erhält eine Spalte Farbe und Sprachkürzel.
 *
 * @package easyoriginal
 */

defined( 'ABSPATH' ) || exit;

/**
 * Menü einer Position als Baum: [ ['title','url','classes','desc','target','current','children'=>[…]] ].
 */
function eo_menu_tree( $location ) {
	$locations = get_nav_menu_locations();
	if ( empty( $locations[ $location ] ) ) {
		return null;
	}
	$items = wp_get_nav_menu_items( $locations[ $location ] );
	if ( ! $items ) {
		return null;
	}
	_wp_menu_item_classes_by_context( $items );
	$by_parent = array();
	foreach ( $items as $it ) {
		$by_parent[ (int) $it->menu_item_parent ][] = $it;
	}
	$build = function ( $parent ) use ( &$build, $by_parent ) {
		$out = array();
		if ( empty( $by_parent[ $parent ] ) ) {
			return $out;
		}
		foreach ( $by_parent[ $parent ] as $it ) {
			$classes = array_filter( (array) $it->classes );
			$out[]   = array(
				'title'    => $it->title,
				'url'      => $it->url,
				'classes'  => $classes,
				'desc'     => $it->description,
				'target'   => $it->target,
				'current'  => in_array( 'current-menu-item', $classes, true ) || in_array( 'current-menu-ancestor', $classes, true ),
				'children' => $build( (int) $it->ID ),
			);
		}
		return $out;
	};
	return $build( 0 );
}

function eo_menu_name( $location ) {
	$locations = get_nav_menu_locations();
	if ( empty( $locations[ $location ] ) ) {
		return '';
	}
	$menu = wp_get_nav_menu_object( $locations[ $location ] );
	return $menu ? $menu->name : '';
}

/** Kurzform für Fallback-Einträge. */
function eo_mi( $title, $url, $children = array(), $classes = array(), $desc = '' ) {
	return array( 'title' => $title, 'url' => eo_url( $url ), 'classes' => $classes, 'desc' => $desc, 'target' => '', 'current' => false, 'children' => $children );
}

/**
 * Fallback-Hauptmenü (wenn noch kein Menü zugewiesen ist).
 */
function eo_default_primary() {
	$cols = array();
	foreach ( eo_langs() as $code => $l ) {
		$subs = array();
		foreach ( $l['links'] as $link ) {
			$subs[] = eo_mi( $link[0], $link[1] );
		}
		$cols[] = eo_mi( $l['name'], $l['url'], $subs, array( 'lang-' . $code ) );
	}
	return array(
		eo_mi( __( 'Sprachen', 'easyoriginal' ), '#', $cols, array( 'eo-mega' ) ),
		eo_mi(
			__( 'Lesemethode', 'easyoriginal' ),
			'/frank-lesemethode/',
			array(
				eo_mi( 'Die Frank-Lesemethode', '/frank-lesemethode/', array(), array(), 'Wie und warum sie funktioniert' ),
				eo_mi( 'Wie lese ich ein easyOriginal-Buch?', '/wie-lese-ich-das-easyoriginal-buch/', array(), array(), 'Schritt für Schritt erklärt' ),
				eo_mi( 'Ilya Frank über seine Methode', '/ilya-frank-ueber-seine-lesemethode/' ),
				eo_mi( 'Ilya Frank – wer ist das?', '/ilya-frank-wer-ist-das/' ),
				eo_mi( 'Fremdsprachen lernen', '/fremdsprachen-lernen/' ),
			)
		),
		eo_mi( __( 'Geschenksets', 'easyoriginal' ), '/geschenksets/' ),
		eo_mi(
			__( 'Schreibwaren', 'easyoriginal' ),
			'/schreibsets/',
			array( eo_mi( 'Schreibsets', '/schreibsets/' ), eo_mi( 'Notizbücher', '/notizbuecher/' ) )
		),
	);
}

function eo_default_service() {
	return array(
		eo_mi( 'Über uns', '/ueber-easyoriginal/' ),
		eo_mi( 'Blog', '/blog/' ),
		eo_mi( 'Partnerprogramm', '/partnerprogramm/' ),
		eo_mi( 'Kontakt', '/kontakt/' ),
	);
}

function eo_default_footer_cols() {
	$langs = array();
	foreach ( eo_langs() as $code => $l ) {
		$langs[] = eo_mi( 'de' === $code ? 'Deutsch–Englisch' : $l['name'] . '–Deutsch', $l['url'] );
	}
	return array(
		array( __( 'Sprachen', 'easyoriginal' ), $langs ),
		array(
			__( 'Lesemethode', 'easyoriginal' ),
			array(
				eo_mi( 'Frank-Lesemethode', '/frank-lesemethode/' ),
				eo_mi( 'So lesen Sie ein Buch', '/wie-lese-ich-das-easyoriginal-buch/' ),
				eo_mi( 'Wer ist Ilya Frank?', '/ilya-frank-wer-ist-das/' ),
				eo_mi( 'Fremdsprachen lernen', '/fremdsprachen-lernen/' ),
				eo_mi( 'Über easyOriginal', '/ueber-easyoriginal/' ),
				eo_mi( 'Blog', '/blog/' ),
			),
		),
		array(
			__( 'Service', 'easyoriginal' ),
			array(
				eo_mi( 'Mein Konto', function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : '/mein-konto/' ),
				eo_mi( 'Warenkorb', function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : '/warenkorb/' ),
				eo_mi( 'Versand & Lieferung', '/versand__lieferung/' ),
				eo_mi( 'Zahlungsweisen', '/zahlungsweisen/' ),
				eo_mi( 'Partnerprogramm', '/partnerprogramm/' ),
				eo_mi( 'Kontakt', '/kontakt/' ),
			),
		),
		array(
			__( 'Rechtliches', 'easyoriginal' ),
			array(
				eo_mi( 'AGB', '/allgemeine_geschaeftsbedingungen/' ),
				eo_mi( 'Widerruf', '/widerruf/' ),
				eo_mi( 'Withdrawal (English)', '/withdrawal-of-contract/' ),
				eo_mi( 'Datenschutz', '/datenschutz/' ),
				eo_mi( 'Impressum', '/impressum/' ),
			),
		),
	);
}

function eo_link_attrs( $item ) {
	$a = ' href="' . esc_url( $item['url'] ) . '"';
	if ( ! empty( $item['target'] ) ) {
		$a .= ' target="' . esc_attr( $item['target'] ) . '" rel="noopener"';
	}
	if ( ! empty( $item['current'] ) ) {
		$a .= ' aria-current="page"';
	}
	return $a;
}

function eo_item_lang( $item ) {
	foreach ( (array) $item['classes'] as $c ) {
		if ( preg_match( '/^lang-([a-z]{2})$/', $c, $m ) ) {
			return $m[1];
		}
	}
	return '';
}

/**
 * Desktop-Hauptnavigation.
 */
function eo_render_primary_nav() {
	$tree = eo_menu_tree( 'eo_primary' );
	if ( null === $tree ) {
		$tree = eo_default_primary();
	}
	$i = 0;
	echo '<nav class="nav" aria-label="' . esc_attr__( 'Hauptnavigation', 'easyoriginal' ) . '">';
	foreach ( $tree as $item ) {
		$i++;
		if ( empty( $item['children'] ) ) {
			echo '<a class="nav__link"' . eo_link_attrs( $item ) . '>' . esc_html( $item['title'] ) . '</a>'; // phpcs:ignore
			continue;
		}
		$id   = 'eo-menu-' . $i;
		$mega = in_array( 'eo-mega', (array) $item['classes'], true );
		echo '<div class="nav__item" data-menu>';
		echo '<button class="nav__link" type="button" aria-expanded="false" aria-controls="' . esc_attr( $id ) . '">' . esc_html( $item['title'] ) . ' ' . eo_icon( 'chev' ) . '</button>'; // phpcs:ignore
		if ( $mega ) {
			echo '<div class="mega" id="' . esc_attr( $id ) . '">';
			foreach ( $item['children'] as $col ) {
				$lang = eo_item_lang( $col );
				echo '<div class="mega__lang' . ( $lang ? ' lang-' . esc_attr( $lang ) : '' ) . '">';
				echo '<h3>' . ( $lang ? '<span class="lang-dot">' . esc_html( strtoupper( $lang ) ) . '</span>' : '' ) . '<a' . eo_link_attrs( $col ) . '>' . esc_html( $col['title'] ) . '</a></h3>'; // phpcs:ignore
				if ( $col['children'] ) {
					echo '<ul>';
					foreach ( $col['children'] as $sub ) {
						echo '<li><a' . eo_link_attrs( $sub ) . '>' . esc_html( $sub['title'] ) . '</a></li>'; // phpcs:ignore
					}
					echo '</ul>';
				}
				echo '</div>';
			}
			if ( '#' !== $item['url'] && '' !== $item['url'] ) {
				echo '<div class="mega__foot"><span></span><a class="link-arrow"' . eo_link_attrs( $item ) . '>' . esc_html__( 'Alle ansehen', 'easyoriginal' ) . '</a></div>'; // phpcs:ignore
			}
			echo '</div>';
		} else {
			echo '<div class="mega mega--small" id="' . esc_attr( $id ) . '">';
			foreach ( $item['children'] as $sub ) {
				echo '<a' . eo_link_attrs( $sub ) . '>' . esc_html( $sub['title'] ) . ( $sub['desc'] ? '<small>' . esc_html( $sub['desc'] ) . '</small>' : '' ) . '</a>'; // phpcs:ignore
			}
			echo '</div>';
		}
		echo '</div>';
	}
	echo '</nav>';
}

/**
 * Mobile Navigation im Drawer.
 */
function eo_render_drawer_nav() {
	$tree = eo_menu_tree( 'eo_primary' );
	if ( null === $tree ) {
		$tree = eo_default_primary();
	}
	$first = true;
	foreach ( $tree as $item ) {
		if ( empty( $item['children'] ) ) {
			echo '<a class="drawer__link"' . eo_link_attrs( $item ) . '>' . esc_html( $item['title'] ) . '</a>'; // phpcs:ignore
			continue;
		}
		echo '<details' . ( $first ? ' open' : '' ) . '><summary>' . esc_html( $item['title'] ) . '</summary><ul>';
		foreach ( $item['children'] as $sub ) {
			$lang = eo_item_lang( $sub );
			echo '<li' . ( $lang ? ' class="lang-' . esc_attr( $lang ) . '"' : '' ) . '><a' . eo_link_attrs( $sub ) . '>' . ( $lang ? '<span class="lang-dot">' . esc_html( strtoupper( $lang ) ) . '</span> ' : '' ) . esc_html( $sub['title'] ) . '</a></li>'; // phpcs:ignore
		}
		echo '</ul></details>';
		$first = false;
	}
	foreach ( eo_service_items() as $item ) {
		echo '<a class="drawer__link"' . eo_link_attrs( $item ) . '>' . esc_html( $item['title'] ) . '</a>'; // phpcs:ignore
	}
}

function eo_service_items() {
	$tree = eo_menu_tree( 'eo_service' );
	return null === $tree ? eo_default_service() : $tree;
}

/**
 * Spalten der Fußzeile: [ [Überschrift, [Einträge]] ].
 */
function eo_footer_columns() {
	$cols = array();
	$any  = false;
	for ( $i = 1; $i <= 4; $i++ ) {
		$tree = eo_menu_tree( 'eo_footer_' . $i );
		if ( null !== $tree ) {
			$any    = true;
			$cols[] = array( eo_menu_name( 'eo_footer_' . $i ), $tree );
		}
	}
	return $any ? $cols : eo_default_footer_cols();
}
