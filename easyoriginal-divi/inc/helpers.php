<?php
/**
 * Hilfsfunktionen.
 *
 * @package easyoriginal
 */

defined( 'ABSPATH' ) || exit;

// Fallbacks, falls die PHP-Erweiterung mbstring fehlt (WordPress liefert nur mb_substr/mb_strlen nach).
if ( ! function_exists( 'mb_strtolower' ) ) {
	function mb_strtolower( $s ) { return strtolower( $s ); } // phpcs:ignore
}
if ( ! function_exists( 'mb_strtoupper' ) ) {
	function mb_strtoupper( $s ) { return strtoupper( $s ); } // phpcs:ignore
}
if ( ! function_exists( 'mb_stripos' ) ) {
	function mb_stripos( $h, $n ) { return stripos( $h, $n ); } // phpcs:ignore
}

/**
 * SVG-Icon aus dem Sprite im Header.
 */
function eo_icon( $name, $class = '' ) {
	return '<svg aria-hidden="true"' . ( $class ? ' class="' . esc_attr( $class ) . '"' : '' ) . '><use href="#i-' . esc_attr( $name ) . '"/></svg>';
}

/**
 * Theme-Einstellung (Customizer) mit Standardwert aus eo_defaults().
 */
function eo_opt( $key ) {
	$defaults = eo_defaults();
	$default  = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
	return get_theme_mod( 'eo_' . $key, $default );
}

/**
 * Relativer Pfad → URL dieser Website; absolute URLs bleiben.
 */
function eo_url( $path ) {
	if ( '' === $path || null === $path ) {
		return '';
	}
	if ( preg_match( '#^(https?:)?//#', $path ) || 0 === strpos( $path, '#' ) || 0 === strpos( $path, 'mailto:' ) ) {
		return $path;
	}
	return home_url( '/' . ltrim( $path, '/' ) );
}

/**
 * Konfiguration der Sprachen. Links und Kategorien sind im Customizer änderbar.
 */
function eo_langs() {
	static $langs = null;
	if ( null !== $langs ) {
		return $langs;
	}
	$base  = array(
		'en' => array(
			'name'     => 'Englisch',
			'hello'    => 'Hello!',
			'quote'    => '„Marley was dead: to begin with.“',
			'cite'     => 'Charles Dickens, A Christmas Carol',
			'keys'     => array( 'englisch' ),
			'links'    => array(
				array( 'Klassiker', '/englisch-klassiker-frank-lesemethode/' ),
				array( 'Moderne Lektüre', '/englisch-moderne-lektuere/' ),
				array( 'Readable Classics', '/readable-classics-english/' ),
			),
		),
		'fr' => array(
			'name'  => 'Französisch',
			'hello' => 'Bonjour !',
			'quote' => '„L’étrange voyage ! Il avait si bien commencé cependant !“',
			'cite'  => 'Maurice Leblanc, L’Arrestation d’Arsène Lupin',
			'keys'  => array( 'franzoesisch', 'franzosisch' ),
			'links' => array(
				array( 'Klassiker', '/franzoesisch-klassiker-frank-lesemethode/' ),
				array( 'Moderne Lektüre', '/franzoesisch-moderne-lektuere/' ),
				array( 'Readable Classics', '/readable-classics-franzoesisch/' ),
			),
		),
		'it' => array(
			'name'  => 'Italienisch',
			'hello' => 'Ciao!',
			'quote' => '„C’era una volta …“',
			'cite'  => 'Es war einmal …',
			'keys'  => array( 'italienisch' ),
			'links' => array(
				array( 'Krimis & Humor', '/italienisch-lernen/' ),
				array( 'Readable Classics', '/readable-classics-italienisch/' ),
			),
		),
		'es' => array(
			'name'  => 'Spanisch',
			'hello' => '¡Hola!',
			'quote' => '„Érase una vez …“',
			'cite'  => 'Es war einmal …',
			'keys'  => array( 'spanisch' ),
			'links' => array(
				array( 'Klassiker', '/spanisch-klassiker-frank-lesemethode/' ),
				array( 'Moderne Lektüre', '/spanisch-moderne-lektuere/' ),
			),
		),
		'ru' => array(
			'name'  => 'Russisch',
			'hello' => 'Привет!',
			'quote' => '„После венчания не было даже лёгкой закуски …“',
			'cite'  => 'Anton Tschechow, Anna am Halse',
			'keys'  => array( 'russisch' ),
			'links' => array(
				array( 'Puschkin, Tschechow, Gogol', '/russisch-lernen/' ),
				array( 'Readable Classics', '/readable-classics-russian/' ),
			),
		),
		'de' => array(
			'name'  => 'Deutsch',
			'hello' => 'Hallo!',
			'quote' => '„Es war einmal …“',
			'cite'  => 'Once upon a time … · for English speakers',
			'keys'  => array( 'deutsch-englisch' ),
			'links' => array(
				array( 'German–English books', '/deutsch-englisch/' ),
			),
		),
	);
	$langs = array();
	foreach ( $base as $code => $l ) {
		$l['code'] = strtoupper( $code );
		$l['url']  = eo_url( eo_opt( 'lang_' . $code . '_url' ) );
		$l['cats'] = array_filter( array_map( 'trim', explode( ',', (string) eo_opt( 'lang_' . $code . '_cats' ) ) ) );
		$langs[ $code ] = $l;
	}
	return apply_filters( 'eo_langs', $langs );
}

/**
 * Sprache eines Kategorie-Slugs (en, fr, it, es, ru, de) oder ''.
 * „franzoesisch-englisch“ usw. sind Ausgaben für Englischsprachige → Sprache des Originals.
 */
function eo_lang_from_slug( $slug ) {
	$slug = strtolower( $slug );
	if ( 0 === strpos( $slug, 'deutsch-englisch' ) ) {
		return 'de';
	}
	foreach ( eo_langs() as $code => $l ) {
		if ( 'de' === $code ) {
			continue;
		}
		foreach ( $l['keys'] as $k ) {
			if ( false !== strpos( $slug, $k ) ) {
				return $code;
			}
		}
	}
	return '';
}

/**
 * Kategorie-IDs einer Sprache (Customizer-Slugs, sonst automatisch per Schlüsselwort).
 */
function eo_lang_cat_ids( $code ) {
	static $cache = array();
	if ( isset( $cache[ $code ] ) ) {
		return $cache[ $code ];
	}
	$langs = eo_langs();
	$ids   = array();
	if ( ! empty( $langs[ $code ]['cats'] ) ) {
		foreach ( $langs[ $code ]['cats'] as $slug ) {
			$t = get_term_by( 'slug', $slug, 'product_cat' );
			if ( $t ) {
				$ids[] = (int) $t->term_id;
			}
		}
	}
	if ( ! $ids && taxonomy_exists( 'product_cat' ) ) {
		$terms = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => true, 'fields' => 'id=>slug' ) );
		if ( ! is_wp_error( $terms ) ) {
			foreach ( $terms as $id => $slug ) {
				if ( eo_lang_from_slug( $slug ) === $code ) {
					$ids[] = (int) $id;
				}
			}
		}
	}
	$cache[ $code ] = $ids;
	return $ids;
}

/**
 * Titel „Original / Deutsch A1-A2“ → [Original, Deutsch, Niveau].
 */
function eo_split_title( $title ) {
	$title = trim( preg_replace( '/\s+/u', ' ', str_replace( "\xE2\x81\xA0", '', wp_strip_all_tags( $title ) ) ) );
	$level = '';
	if ( preg_match( '/\s*\b([ABC][12])\s*[-–]\s*([ABC][12])\b/u', $title, $m ) ) {
		$level = $m[1] . '–' . $m[2];
		$title = trim( str_replace( $m[0], '', $title ) );
		$title = trim( preg_replace( '/\s*[–—-]\s*$/u', '', $title ) );
	}
	$de = '';
	if ( false !== strpos( $title, ' / ' ) ) {
		list( $title, $de ) = array_map( 'trim', explode( ' / ', $title, 2 ) );
	} else {
		foreach ( array( ' — ', ' – ' ) as $sep ) {
			if ( false !== strpos( $title, $sep ) ) {
				list( $a, $b ) = array_map( 'trim', explode( $sep, $title, 2 ) );
				if ( ! preg_match( '/^(Teil|Teile|Staffel|Band|Frank-Lesemethode)\b/u', $b ) && ':' !== substr( $a, -1 ) && mb_strlen( $a ) > 3 ) {
					$title = $a;
					$de    = $b;
				}
				break;
			}
		}
	}
	return array( $title, $de, $level );
}

/**
 * Produkt → Sprache.
 */
function eo_product_lang( $product ) {
	$product = wc_get_product( $product );
	if ( ! $product ) {
		return '';
	}
	$id = $product->get_parent_id() ? $product->get_parent_id() : $product->get_id();
	$sp = $product->get_attribute( 'pa_sprache' );
	if ( $sp ) {
		$code = eo_lang_from_slug( sanitize_title( $sp ) );
		if ( $code ) {
			return $code;
		}
	}
	$slugs = wp_get_post_terms( $id, 'product_cat', array( 'fields' => 'slugs' ) );
	if ( ! is_wp_error( $slugs ) ) {
		foreach ( $slugs as $slug ) {
			$code = eo_lang_from_slug( $slug );
			if ( $code ) {
				return $code;
			}
		}
	}
	return '';
}

/**
 * Produkt → Niveau („A1–A2“, „Original“ oder '').
 */
function eo_product_level( $product ) {
	$product = wc_get_product( $product );
	if ( ! $product ) {
		return '';
	}
	$attr = $product->get_attribute( 'pa_niveau' );
	if ( $attr ) {
		return str_replace( '-', '–', $attr );
	}
	list( , , $level ) = eo_split_title( $product->get_name() );
	if ( $level ) {
		return $level;
	}
	$slugs = wp_get_post_terms( $product->get_id(), 'product_cat', array( 'fields' => 'slugs' ) );
	if ( is_wp_error( $slugs ) ) {
		return '';
	}
	foreach ( $slugs as $slug ) {
		foreach ( array( '-a1-a2' => 'A1–A2', '-a2-b1' => 'A2–B1', '-b1-b2' => 'B1–B2' ) as $suffix => $l ) {
			if ( substr( $slug, -strlen( $suffix ) ) === $suffix ) {
				return $l;
			}
		}
		if ( preg_match( '/^modern-[a-z]+-frank$/', $slug ) ) {
			return 'A2–B1';
		}
	}
	foreach ( $slugs as $slug ) {
		if ( preg_match( '/^(englisch|franzoesisch|franzosisch|italienisch|spanisch|russisch)-deutsch$/', $slug ) ) {
			return __( 'Original', 'easyoriginal' );
		}
	}
	return '';
}

/**
 * Autor: Produktfeld → Attribut pa_autor → Dateiname des Covers.
 */
function eo_product_author( $product ) {
	$product = wc_get_product( $product );
	if ( ! $product ) {
		return '';
	}
	$a = get_post_meta( $product->get_id(), '_eo_autor', true );
	if ( ! $a ) {
		$a = $product->get_attribute( 'pa_autor' );
	}
	if ( ! $a && $product->get_image_id() ) {
		$file = strtolower( basename( (string) get_attached_file( $product->get_image_id() ) ) );
		$map  = array(
			'wilde' => 'Oscar Wilde', 'saki' => 'Saki', 'doyle' => 'Arthur Conan Doyle', 'dickens' => 'Charles Dickens',
			'carroll' => 'Lewis Carroll', 'austen' => 'Jane Austen', 'chesterton' => 'G. K. Chesterton', 'wells' => 'H. G. Wells',
			'poe' => 'Edgar Allan Poe', 'irving' => 'Washington Irving', 'ruskin' => 'John Ruskin', 'twain' => 'Mark Twain',
			'fitzgerald' => 'F. Scott Fitzgerald', 'orwell' => 'George Orwell', 'baum' => 'L. Frank Baum', 'leblanc' => 'Maurice Leblanc',
			'tschechow' => 'Anton Tschechow', 'puschkin' => 'Alexander Puschkin', 'gogol' => 'Nikolai Gogol', 'turgenew' => 'Iwan Turgenew',
			'bulgakow' => 'Michail Bulgakow', 'storm' => 'Theodor Storm',
		);
		$key = strtok( $file, '_-' );
		if ( isset( $map[ $key ] ) ) {
			$a = $map[ $key ];
		}
	}
	return (string) $a;
}

/**
 * Original-Titel, deutscher Untertitel und Niveau eines Produkts.
 */
function eo_product_titles( $product ) {
	$product = wc_get_product( $product );
	list( $orig, $de, $level ) = eo_split_title( $product->get_name() );
	$sub = get_post_meta( $product->get_id(), '_eo_untertitel', true );
	if ( $sub ) {
		$de = $sub;
	}
	return array( $orig, $de, $level );
}

/**
 * Hauptfarbe des Covers (für Hintergründe und Buchrücken), wird am Produkt gespeichert.
 */
function eo_cover_color( $product ) {
	$product = wc_get_product( $product );
	if ( ! $product || ! $product->get_image_id() ) {
		return '#8a7a66';
	}
	$id     = $product->get_id();
	$img_id = (int) $product->get_image_id();
	$manual = get_post_meta( $id, '_eo_cover_farbe', true );
	if ( $manual && preg_match( '/^#[0-9a-f]{6}$/i', $manual ) ) {
		return $manual;
	}
	$cached = get_post_meta( $id, '_eo_cover_color', true );
	if ( is_array( $cached ) && isset( $cached['img'], $cached['hex'] ) && (int) $cached['img'] === $img_id ) {
		return $cached['hex'];
	}
	$hex = '#8a7a66';
	if ( function_exists( 'imagecreatefromstring' ) ) {
		$src  = wp_get_attachment_image_src( $img_id, 'woocommerce_thumbnail' );
		$path = $src ? eo_upload_url_to_path( $src[0] ) : '';
		if ( ! $path || ! file_exists( $path ) ) {
			$path = get_attached_file( $img_id );
		}
		$data = ( $path && file_exists( $path ) && filesize( $path ) < 8 * MB_IN_BYTES ) ? file_get_contents( $path ) : false; // phpcs:ignore
		$im   = $data ? @imagecreatefromstring( $data ) : false; // phpcs:ignore
		if ( $im ) {
			$w = imagesx( $im );
			$h = imagesy( $im );
			$s = imagecreatetruecolor( 20, 20 );
			imagecopyresampled( $s, $im, 0, 0, (int) ( $w * .08 ), (int) ( $h * .05 ), 20, 20, (int) ( $w * .84 ), (int) ( $h * .67 ) );
			$best = null;
			$sum  = array( 0, 0, 0, 0 );
			for ( $x = 0; $x < 20; $x++ ) {
				for ( $y = 0; $y < 20; $y++ ) {
					$c = imagecolorat( $s, $x, $y );
					$r = ( $c >> 16 ) & 255;
					$g = ( $c >> 8 ) & 255;
					$b = $c & 255;
					$max = max( $r, $g, $b );
					$min = min( $r, $g, $b );
					$l   = ( $max + $min ) / 510;
					$sat = $max === $min ? 0 : ( $max - $min ) / ( 255 - abs( $max + $min - 255 ) );
					$wgt = ( $l > .12 && $l < .85 ) ? .2 + $sat : .05;
					$sum[0] += $r * $wgt;
					$sum[1] += $g * $wgt;
					$sum[2] += $b * $wgt;
					$sum[3] += $wgt;
				}
			}
			if ( $sum[3] > 0 ) {
				$hex = sprintf( '#%02x%02x%02x', $sum[0] / $sum[3], $sum[1] / $sum[3], $sum[2] / $sum[3] );
			}
			imagedestroy( $s );
			imagedestroy( $im );
		}
	}
	update_post_meta( $id, '_eo_cover_color', array( 'img' => $img_id, 'hex' => $hex ) );
	return $hex;
}

function eo_upload_url_to_path( $url ) {
	$up = wp_get_upload_dir();
	if ( 0 === strpos( $url, $up['baseurl'] ) ) {
		return $up['basedir'] . substr( $url, strlen( $up['baseurl'] ) );
	}
	return '';
}

/**
 * Gut lesbare Textfarbe für einen Hintergrund.
 */
function eo_ink_for( $hex ) {
	$hex = ltrim( $hex, '#' );
	$r   = hexdec( substr( $hex, 0, 2 ) );
	$g   = hexdec( substr( $hex, 2, 2 ) );
	$b   = hexdec( substr( $hex, 4, 2 ) );
	return ( 0.299 * $r + 0.587 * $g + 0.114 * $b ) > 150 ? '#1e1b17' : '#fff8ec';
}

/**
 * Ist das Produktbild eher quadratisch (Set-Foto) als ein Buchcover?
 */
function eo_is_square_image( $product ) {
	$meta = wp_get_attachment_metadata( $product->get_image_id() );
	if ( empty( $meta['width'] ) || empty( $meta['height'] ) ) {
		return false;
	}
	return ( $meta['height'] / $meta['width'] ) < 1.25;
}

/**
 * Produkte abfragen (mit Cache, wird beim Speichern eines Produkts geleert).
 *
 * @param array $args orderby: popularity|date|rand|menu_order, limit, cats (IDs), ids, on_sale.
 * @return WC_Product[]
 */
function eo_query_products( $args ) {
	$args = wp_parse_args(
		$args,
		array( 'orderby' => 'popularity', 'limit' => 12, 'cats' => array(), 'ids' => array(), 'require_image' => true )
	);
	$key = 'eo_q_' . get_option( 'eo_cache_v', 1 ) . '_' . md5( wp_json_encode( $args ) );
	$ids = get_transient( $key );
	if ( false === $ids ) {
		$q = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'posts_per_page'      => $args['ids'] ? count( $args['ids'] ) : $args['limit'],
			'fields'              => 'ids',
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
			'tax_query'           => array( // phpcs:ignore
				array(
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => array( 'exclude-from-catalog' ),
					'operator' => 'NOT IN',
				),
			),
		);
		if ( $args['ids'] ) {
			$q['post__in'] = array_map( 'absint', $args['ids'] );
			$q['orderby']  = 'post__in';
		} elseif ( 'popularity' === $args['orderby'] ) {
			$q['meta_key'] = 'total_sales'; // phpcs:ignore
			$q['orderby']  = array( 'meta_value_num' => 'DESC', 'date' => 'DESC' );
		} elseif ( 'date' === $args['orderby'] ) {
			$q['orderby'] = 'date';
			$q['order']   = 'DESC';
		} else {
			$q['orderby'] = $args['orderby'];
		}
		if ( $args['cats'] ) {
			$q['tax_query'][] = array( 'taxonomy' => 'product_cat', 'field' => 'term_id', 'terms' => array_map( 'absint', $args['cats'] ) );
		}
		if ( $args['require_image'] ) {
			$q['meta_query'] = array( array( 'key' => '_thumbnail_id', 'compare' => 'EXISTS' ) ); // phpcs:ignore
		}
		$ids = get_posts( $q );
		set_transient( $key, $ids, 12 * HOUR_IN_SECONDS );
	}
	return array_values( array_filter( array_map( 'wc_get_product', (array) $ids ) ) );
}

/**
 * Cache leeren, wenn sich Produkte ändern.
 */
function eo_bump_cache() {
	update_option( 'eo_cache_v', (int) get_option( 'eo_cache_v', 1 ) + 1, true );
}
add_action( 'save_post_product', 'eo_bump_cache' );
add_action( 'woocommerce_update_product', 'eo_bump_cache' );
add_action( 'customize_save_after', 'eo_bump_cache' );

/**
 * Produktkarte – dasselbe Markup wie im Prototyp.
 * Ruft die WooCommerce-Hooks auf, damit Plugins wie German Market ihre Pflichtangaben
 * (inkl. MwSt., zzgl. Versand, Grundpreis …) an der Karte ausgeben können.
 *
 * @param WC_Product|int $product
 * @param array          $args show_lang (bool), heading (h2|h3).
 */
function eo_card( $product, $args = array() ) {
	$product = wc_get_product( $product );
	if ( ! $product ) {
		return '';
	}
	$args = wp_parse_args( $args, array( 'show_lang' => true, 'heading' => 'h3' ) );
	list( $orig, $de, $title_level ) = eo_product_titles( $product );
	$lang   = eo_product_lang( $product );
	$langs  = eo_langs();
	$level  = eo_product_level( $product );
	$author = eo_product_author( $product );
	$color  = eo_cover_color( $product );
	$square = eo_is_square_image( $product );
	$link   = $product->get_permalink();
	$tag    = in_array( $args['heading'], array( 'h2', 'h3', 'h4' ), true ) ? $args['heading'] : 'h3';

	$tags = '';
	if ( $args['show_lang'] && $lang && isset( $langs[ $lang ] ) ) {
		$tags .= '<span class="chip chip--lang lang-' . esc_attr( $lang ) . '" title="' . esc_attr( $langs[ $lang ]['name'] ) . '">' . esc_html( $langs[ $lang ]['code'] ) . '</span>';
	}
	if ( $level ) {
		$tags .= '<span class="chip chip--level">' . esc_html( $level ) . '</span>';
	}

	// Globale Produktvariable für Plugin-Hooks setzen.
	$prev_product      = isset( $GLOBALS['product'] ) ? $GLOBALS['product'] : null;
	$prev_post         = isset( $GLOBALS['post'] ) ? $GLOBALS['post'] : null;
	$GLOBALS['product'] = $product;
	$GLOBALS['post']    = get_post( $product->get_id() ); // phpcs:ignore
	setup_postdata( $GLOBALS['post'] );

	ob_start();
	?>
	<article class="card<?php echo $lang ? ' lang-' . esc_attr( $lang ) : ''; ?>" style="--c:<?php echo esc_attr( $color ); ?>">
		<div class="card__media<?php echo $square ? ' card__media--square' : ''; ?>">
			<?php if ( $product->is_on_sale() ) : ?>
				<div class="card__badges"><span class="chip chip--sale"><?php esc_html_e( 'Angebot', 'easyoriginal' ); ?></span></div>
			<?php endif; ?>
			<?php echo $product->get_image( 'woocommerce_thumbnail', array( 'alt' => '', 'loading' => 'lazy' ) ); // phpcs:ignore ?>
		</div>
		<div class="card__body">
			<?php if ( $tags || $author ) : ?>
				<div class="card__meta"><?php echo $tags; // phpcs:ignore ?><?php echo $author ? '<span>' . esc_html( $author ) . '</span>' : ''; ?></div>
			<?php endif; ?>
			<<?php echo $tag; // phpcs:ignore ?> class="card__title"><a class="card__link" href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $orig ); ?></a></<?php echo $tag; // phpcs:ignore ?>>
			<?php if ( $de ) : ?>
				<p class="card__de"><?php echo esc_html( $de ); ?></p>
			<?php endif; ?>
			<div class="card__price"><?php echo $product->get_price_html(); // phpcs:ignore ?></div>
			<div class="card__legal"><?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?><?php do_action( 'woocommerce_after_shop_loop_item' ); ?></div>
		</div>
	</article>
	<?php
	$html = ob_get_clean();

	$GLOBALS['product'] = $prev_product;
	$GLOBALS['post']    = $prev_post; // phpcs:ignore
	if ( $prev_post ) {
		setup_postdata( $prev_post );
	} else {
		wp_reset_postdata();
	}
	return $html;
}
