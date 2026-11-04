<?php
/**
 * Grundeinrichtung: Styles/Skripte, Design-Variante, Menüs, Divi-Anpassungen.
 *
 * @package easyoriginal
 */

defined( 'ABSPATH' ) || exit;

/**
 * Aktive Design-Variante: buch | journal | bunt.
 * Administratoren können über den Umschalter (Cookie „eo_skin_preview“) oder ?eo_skin=… vorschauen.
 */
function eo_skin() {
	static $skin = null;
	if ( null !== $skin ) {
		return $skin;
	}
	$allowed = array( 'buch', 'journal', 'bunt' );
	$skin    = eo_opt( 'skin' );
	if ( eo_can_preview_skins() ) {
		$try = '';
		if ( isset( $_GET['eo_skin'] ) ) { // phpcs:ignore
			$try = sanitize_key( wp_unslash( $_GET['eo_skin'] ) ); // phpcs:ignore
		} elseif ( isset( $_COOKIE['eo_skin_preview'] ) ) {
			$try = sanitize_key( wp_unslash( $_COOKIE['eo_skin_preview'] ) );
		}
		if ( in_array( $try, $allowed, true ) ) {
			$skin = $try;
		}
	}
	if ( ! in_array( $skin, $allowed, true ) ) {
		$skin = 'buch';
	}
	return $skin;
}

function eo_can_preview_skins() {
	return eo_opt( 'skin_switch' ) && is_user_logged_in() && current_user_can( 'edit_theme_options' );
}

add_action(
	'after_setup_theme',
	function () {
		load_child_theme_textdomain( 'easyoriginal', EO_THEME_DIR . '/languages' );
		register_nav_menus(
			array(
				'eo_primary' => __( 'easyOriginal: Hauptmenü (mit Mega-Menü)', 'easyoriginal' ),
				'eo_service' => __( 'easyOriginal: Servicelinks oben', 'easyoriginal' ),
				'eo_footer_1' => __( 'easyOriginal: Fußzeile Spalte 1', 'easyoriginal' ),
				'eo_footer_2' => __( 'easyOriginal: Fußzeile Spalte 2', 'easyoriginal' ),
				'eo_footer_3' => __( 'easyOriginal: Fußzeile Spalte 3', 'easyoriginal' ),
				'eo_footer_4' => __( 'easyOriginal: Fußzeile Spalte 4', 'easyoriginal' ),
			)
		);
		add_theme_support( 'custom-logo', array( 'height' => 103, 'width' => 500, 'flex-width' => true, 'flex-height' => true ) );
	},
	20
);

/**
 * Styles und Skripte.
 */
add_action(
	'wp_enqueue_scripts',
	function () {
		$v    = EO_THEME_VERSION;
		$deps = wp_style_is( 'divi-style', 'registered' ) ? array( 'divi-style' ) : array();
		wp_enqueue_style( 'eo-fonts', EO_THEME_URI . '/assets/css/fonts.css', array(), $v );
		wp_enqueue_style( 'eo-base', EO_THEME_URI . '/assets/css/base.css', array_merge( $deps, array( 'eo-fonts' ) ), $v );
		$skins = eo_can_preview_skins() ? array( 'buch', 'journal', 'bunt' ) : array( eo_skin() );
		$last  = 'eo-base';
		foreach ( $skins as $s ) {
			wp_enqueue_style( 'eo-skin-' . $s, EO_THEME_URI . '/assets/css/skin-' . $s . '.css', array( 'eo-base' ), $v );
			$last = 'eo-skin-' . $s;
		}
		wp_enqueue_style( 'eo-wp', EO_THEME_URI . '/assets/css/wp.css', array( $last ), $v );

		wp_enqueue_script( 'eo-theme', EO_THEME_URI . '/assets/js/eo-theme.js', array( 'jquery' ), $v, true );
		wp_localize_script(
			'eo-theme',
			'EO',
			array(
				'skin'    => eo_skin(),
				'preview' => eo_can_preview_skins(),
				'i18n'    => array(
					'listen'  => __( 'Anhören', 'easyoriginal' ),
					'pause'   => __( 'Pause', 'easyoriginal' ),
					'noAudio' => __( 'Audio nicht verfügbar', 'easyoriginal' ),
					'book'    => __( 'Buch', 'easyoriginal' ),
					'books'   => __( 'Bücher', 'easyoriginal' ),
					'from'    => __( 'ab', 'easyoriginal' ),
				),
			)
		);
	},
	20
);

/**
 * <html data-skin="…"> und JS-Klasse so früh wie möglich (kein Flackern).
 */
add_filter(
	'language_attributes',
	function ( $out ) {
		return is_admin() ? $out : $out . ' data-skin="' . esc_attr( eo_skin() ) . '"';
	}
);
add_action(
	'wp_head',
	function () {
		echo "<script>document.documentElement.className+=' js';</script>\n";
		if ( ! has_site_icon() ) {
			echo '<link rel="icon" href="' . esc_url( EO_THEME_URI . '/assets/img/favicon.png' ) . '">' . "\n";
		}
	},
	1
);

/**
 * Body-Klassen: eigene ergänzen, Divi-Kopfzeilen-Klassen entfernen
 * (sonst reserviert Divi Platz für seine fixe Navigation).
 */
add_filter(
	'body_class',
	function ( $classes ) {
		$remove  = array( 'et_fixed_nav', 'et_show_nav', 'et_secondary_nav_enabled', 'et_secondary_nav_two_panels', 'et_primary_nav_dropdown_animation_fade', 'et_secondary_nav_dropdown_animation_fade' );
		$classes = array_values(
			array_filter(
				$classes,
				function ( $c ) use ( $remove ) {
					return ! in_array( $c, $remove, true ) && 0 !== strpos( $c, 'et_header_style_' );
				}
			)
		);
		$classes[] = 'eo-theme';
		$classes[] = 'eo-skin-' . eo_skin();
		return $classes;
	},
	99
);

/**
 * Logo-URL: WordPress-Logo → Divi-Logo → mitgeliefertes Logo.
 */
function eo_logo_url() {
	$id = get_theme_mod( 'custom_logo' );
	if ( $id ) {
		$src = wp_get_attachment_image_src( $id, 'full' );
		if ( $src ) {
			return $src[0];
		}
	}
	if ( function_exists( 'et_get_option' ) ) {
		$divi = et_get_option( 'divi_logo' );
		if ( $divi ) {
			return $divi;
		}
	}
	return EO_THEME_URI . '/assets/img/logo.png';
}

/**
 * Warenkorb-Zähler per AJAX aktuell halten.
 */
add_filter(
	'woocommerce_add_to_cart_fragments',
	function ( $fragments ) {
		$n = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
		$fragments['span.cart-count'] = '<span class="cart-count" data-count="' . (int) $n . '">' . (int) $n . '</span>';
		return $fragments;
	}
);

/**
 * Hinweis nach der Aktivierung: Divi-Theme-Builder-Kopf/Fuß abschalten.
 */
add_action(
	'after_switch_theme',
	function () {
		set_transient( 'eo_activation_notice', 1, WEEK_IN_SECONDS );
	}
);
add_action(
	'admin_notices',
	function () {
		if ( ! get_transient( 'eo_activation_notice' ) || ! current_user_can( 'edit_theme_options' ) ) {
			return;
		}
		echo '<div class="notice notice-info is-dismissible"><p><strong>easyOriginal 2026:</strong> ';
		echo esc_html__( 'Damit die neue Kopf- und Fußzeile erscheint, schalten Sie in „Divi → Theme Builder“ beim Standard-Website-Template die globale Kopf- und Fußzeile aus (Augen-Symbol). Die Design-Variante wählen Sie unter „Design → Customizer → easyOriginal“.', 'easyoriginal' );
		echo '</p></div>';
	}
);
add_action(
	'customize_save_after',
	function () {
		delete_transient( 'eo_activation_notice' );
	}
);
