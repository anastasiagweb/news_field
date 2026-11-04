<?php
/**
 * WooCommerce-Anpassungen.
 *
 * Wichtig für den deutschsprachigen Handel: Alle Standard-Hooks bleiben erhalten, damit
 * German Market & Co. ihre Pflichtangaben (MwSt., Versand, Lieferzeit, Grundpreis) ausgeben.
 *
 * @package easyoriginal
 */

defined( 'ABSPATH' ) || exit;

/* --------------------------------------------------------------------------
 * Produktkarten in Listen
 * ------------------------------------------------------------------------ */

add_action(
	'init',
	function () {
		// Preis und Sterne gibt die Karte selbst aus; Link/Button entfallen (ganze Karte ist klickbar).
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	},
	20
);

/**
 * Preisspannen als „ab 6,99 €“.
 */
function eo_variable_price_from( $price, $product ) {
	if ( ! eo_opt( 'price_from' ) ) {
		return $price;
	}
	$min = $product->get_variation_price( 'min', true );
	$max = $product->get_variation_price( 'max', true );
	if ( $min === $max ) {
		return $price;
	}
	$reg_min = $product->get_variation_regular_price( 'min', true );
	$html    = ( $product->is_on_sale() && $reg_min > $min ) ? wc_format_sale_price( wc_price( $reg_min ), wc_price( $min ) ) : wc_price( $min );
	/* translators: %s: Preis */
	return '<span class="eo-from">' . esc_html__( 'ab', 'easyoriginal' ) . '</span> ' . $html . $product->get_price_suffix();
}
add_filter( 'woocommerce_variable_price_html', 'eo_variable_price_from', 20, 2 );
add_filter( 'woocommerce_variable_sale_price_html', 'eo_variable_price_from', 20, 2 );

add_filter(
	'woocommerce_output_related_products_args',
	function ( $args ) {
		$args['posts_per_page'] = 5;
		$args['columns']        = 5;
		return $args;
	}
);

/* --------------------------------------------------------------------------
 * Seiten-Rahmen ohne Seitenleiste
 * ------------------------------------------------------------------------ */

add_action(
	'wp',
	function () {
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
		if ( ! eo_opt( 'shop_full_width' ) ) {
			return;
		}
		remove_action( 'woocommerce_before_main_content', 'et_divi_output_content_wrapper', 10 );
		remove_action( 'woocommerce_after_main_content', 'et_divi_output_content_wrapper_end', 10 );
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
		add_action( 'woocommerce_before_main_content', 'eo_shop_wrapper_start', 10 );
		add_action( 'woocommerce_after_main_content', 'eo_shop_wrapper_end', 10 );
	},
	20
);

function eo_shop_wrapper_start() {
	echo '<div id="main-content" class="eo-shop"><div class="container">';
}
function eo_shop_wrapper_end() {
	echo '</div></div>';
}

function eo_breadcrumb() {
	woocommerce_breadcrumb(
		array(
			'wrap_before' => '<nav class="crumbs" aria-label="' . esc_attr__( 'Brotkrümel', 'easyoriginal' ) . '"><ol>',
			'wrap_after'  => '</ol></nav>',
			'before'      => '<li>',
			'after'       => '</li>',
			'delimiter'   => '',
			'home'        => __( 'Startseite', 'easyoriginal' ),
		)
	);
}

/* --------------------------------------------------------------------------
 * Kategorie- und Shopseiten: Kopf, Niveau-Filter, Suche, Sortierung
 * ------------------------------------------------------------------------ */

add_filter( 'woocommerce_show_page_title', '__return_false' );
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

add_action(
	'woocommerce_before_main_content',
	function () {
		if ( is_product() ) {
			eo_breadcrumb();
		}
		if ( ! ( is_shop() || is_product_taxonomy() ) ) {
			return;
		}
		$term  = is_product_taxonomy() ? get_queried_object() : null;
		$lang  = $term ? eo_lang_from_slug( $term->slug ) : '';
		$langs = eo_langs();
		$title = $term ? single_term_title( '', false ) : woocommerce_page_title( false );
		$desc  = $term ? term_description( $term->term_id, $term->taxonomy ) : '';
		if ( ! $desc && is_shop() ) {
			$shop = get_post( wc_get_page_id( 'shop' ) );
			$desc = $shop ? apply_filters( 'the_content', $shop->post_excerpt ) : '';
		}
		$intro = $desc ? wp_trim_words( wp_strip_all_tags( $desc ), 34, ' …' ) : '';
		$kids  = $term ? get_terms( array( 'taxonomy' => $term->taxonomy, 'parent' => $term->term_id, 'hide_empty' => true ) ) : get_terms( array( 'taxonomy' => 'product_cat', 'parent' => 0, 'hide_empty' => true, 'exclude' => array( (int) get_option( 'default_product_cat' ) ) ) );
		eo_breadcrumb();
		echo '<section class="cat-hero' . ( $lang ? ' lang-' . esc_attr( $lang ) : '' ) . '"><div class="cat-hero__grid"><div>';
		echo '<h1>' . ( $lang ? '<span class="lang-dot" aria-hidden="true">' . esc_html( $langs[ $lang ]['code'] ) . '</span> ' : '' ) . esc_html( $title ) . '</h1>';
		if ( $intro ) {
			echo '<p class="lead">' . esc_html( $intro ) . '</p>';
		}
		if ( $kids && ! is_wp_error( $kids ) ) {
			echo '<div class="series-links">';
			foreach ( array_slice( $kids, 0, 12 ) as $k ) {
				echo '<a href="' . esc_url( get_term_link( $k ) ) . '">' . esc_html( $k->name ) . ' <span>' . (int) $k->count . '</span></a>';
			}
			echo '</div>';
		}
		echo '</div>';
		if ( $lang ) {
			echo '<blockquote class="cat-hero__line"' . ( 'de' !== $lang ? ' lang="' . esc_attr( $lang ) . '"' : '' ) . '>' . esc_html( $langs[ $lang ]['quote'] ) . '<cite>' . esc_html( $langs[ $lang ]['cite'] ) . '</cite></blockquote>';
		}
		echo '</div></section>';
	},
	30
);

add_action(
	'woocommerce_before_shop_loop',
	function () {
		$base = remove_query_arg( array( 'filter_niveau', 'paged', 'product-page' ), get_pagenum_link( 1, false ) );
		echo '<div class="toolbar"><div class="toolbar__inner">';
		if ( taxonomy_exists( 'pa_niveau' ) ) {
			$terms  = get_terms( array( 'taxonomy' => 'pa_niveau', 'hide_empty' => true ) );
			$active = isset( $_GET['filter_niveau'] ) ? array_map( 'sanitize_title', explode( ',', wp_unslash( $_GET['filter_niveau'] ) ) ) : array(); // phpcs:ignore
			if ( $terms && ! is_wp_error( $terms ) ) {
				echo '<nav class="seg" aria-label="' . esc_attr__( 'Niveau', 'easyoriginal' ) . '">';
				echo '<a href="' . esc_url( $base ) . '" aria-pressed="' . ( $active ? 'false' : 'true' ) . '">' . esc_html__( 'Alle', 'easyoriginal' ) . '</a>';
				foreach ( $terms as $t ) {
					$on    = in_array( $t->slug, $active, true );
					$label = 'original' === $t->slug ? __( 'Klassiker im Original', 'easyoriginal' ) : $t->name;
					echo '<a href="' . esc_url( add_query_arg( 'filter_niveau', $t->slug, $base ) ) . '" aria-pressed="' . ( $on ? 'true' : 'false' ) . '">' . esc_html( $label ) . '</a>';
				}
				echo '</nav>';
			}
		}
		echo '<form class="search-inline" role="search" method="get" action="' . esc_url( home_url( '/' ) ) . '">' . eo_icon( 'search' ) . '<label class="sr-only" for="eo-shop-q">' . esc_html__( 'Bücher suchen', 'easyoriginal' ) . '</label><input class="input" id="eo-shop-q" type="search" name="s" value="' . esc_attr( get_search_query() ) . '" placeholder="' . esc_attr__( 'Titel oder Autor', 'easyoriginal' ) . '"><input type="hidden" name="post_type" value="product"></form>';
		woocommerce_catalog_ordering();
		echo '</div></div><div class="subfilters-row">';
		woocommerce_result_count();
		echo '</div>';
	},
	15
);

/* Ausführliche Kategoriebeschreibung (SEO-Text) unter der Liste. */
add_action(
	'woocommerce_after_shop_loop',
	function () {
		if ( ! is_product_taxonomy() || is_paged() ) {
			return;
		}
		$desc = term_description();
		if ( ! $desc || str_word_count( wp_strip_all_tags( $desc ) ) < 45 ) {
			return;
		}
		echo '<section class="section section--tight"><div class="seo"><div><span class="eyebrow">' . esc_html__( 'Ratgeber', 'easyoriginal' ) . '</span><h2>' . esc_html( single_term_title( '', false ) ) . '</h2></div><div><details><summary>' . esc_html__( 'Mehr lesen', 'easyoriginal' ) . '</summary>' . wp_kses_post( $desc ) . '</details></div></div></section>';
	},
	20
);

/* --------------------------------------------------------------------------
 * Produktseite
 * ------------------------------------------------------------------------ */

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );

add_action(
	'woocommerce_single_product_summary',
	function () {
		global $product;
		list( $orig, $de ) = eo_product_titles( $product );
		$lang              = eo_product_lang( $product );
		$langs             = eo_langs();
		$level             = eo_product_level( $product );
		$author            = eo_product_author( $product );
		echo '<div class="pinfo__chips">';
		if ( $lang ) {
			echo '<span class="chip chip--lang lang-' . esc_attr( $lang ) . '">' . esc_html( $langs[ $lang ]['code'] ) . '</span>';
			echo '<span class="chip">' . esc_html( 'de' === $lang ? 'Deutsch–Englisch' : $langs[ $lang ]['name'] . '–Deutsch' ) . '</span>';
		}
		if ( $level ) {
			echo '<span class="chip">' . esc_html( __( 'Original', 'easyoriginal' ) === $level ? __( 'Klassiker · ungekürzt', 'easyoriginal' ) : $level ) . '</span>';
		}
		echo '</div>';
		echo '<h1 class="product_title entry-title"' . ( $lang && 'de' !== $lang ? ' lang="' . esc_attr( $lang ) . '"' : '' ) . '>' . esc_html( $orig ) . '</h1>';
		if ( $de ) {
			echo '<p class="pinfo__sub">' . esc_html( $de ) . '</p>';
		}
		$count = $product->get_review_count();
		if ( $author || $count ) {
			echo '<div class="pinfo__by">';
			if ( $author ) {
				/* translators: %s: Autor */
				echo '<span>' . wp_kses_post( sprintf( __( 'von %s', 'easyoriginal' ), '<strong>' . esc_html( $author ) . '</strong>' ) ) . '</span>';
			}
			if ( $count && wc_review_ratings_enabled() ) {
				echo '<a href="#reviews" class="pinfo__rating">' . wc_get_rating_html( $product->get_average_rating(), $count ) . '<span>' . esc_html( number_format_i18n( (float) $product->get_average_rating(), 1 ) . ' · ' . sprintf( _n( '%d Bewertung', '%d Bewertungen', $count, 'easyoriginal' ), $count ) ) . '</span></a>'; // phpcs:ignore
			}
			echo '</div>';
		}
	},
	5
);

add_action(
	'woocommerce_single_product_summary',
	function () {
		global $product;
		echo '<ul class="assure">';
		echo '<li>' . eo_icon( 'truck' ) . ' ' . esc_html( eo_opt( 'topbar_text' ) ) . '</li>'; // phpcs:ignore
		if ( get_post_meta( $product->get_id(), '_eo_audio', true ) || false !== stripos( wp_json_encode( $product->get_attributes() ), 'audio' ) ) {
			echo '<li>' . eo_icon( 'headphones' ) . ' ' . esc_html__( 'Mit Audio zum Mithören – online oder auf CD', 'easyoriginal' ) . '</li>'; // phpcs:ignore
		}
		echo '</ul>';
		$up = $product->get_upsell_ids();
		if ( $up ) {
			$set = wc_get_product( $up[0] );
			if ( $set && $set->is_visible() ) {
				list( $so ) = eo_product_titles( $set );
				echo '<a class="bundle-offer" href="' . esc_url( $set->get_permalink() ) . '">' . $set->get_image( 'thumbnail', array( 'alt' => '' ) ) . '<span><strong>' . esc_html( $so ) . '</strong><small>' . esc_html__( 'Im Set günstiger als einzeln', 'easyoriginal' ) . '</small></span><span class="format__price">' . wp_kses_post( $set->get_price_html() ) . '</span></a>'; // phpcs:ignore
			}
		}
	},
	35
);

/* Leseprobe unter der Kaufbox. */
add_action(
	'woocommerce_after_single_product_summary',
	function () {
		global $product;
		if ( ! get_post_meta( $product->get_id(), '_eo_leseprobe', true ) ) {
			return;
		}
		$s = eo_get_sample( $product->get_id() );
		echo '<section class="section section--paper2 eo-sample" id="leseprobe"><div class="sample"><div class="sample__aside"><span class="eyebrow">' . esc_html__( 'Leseprobe', 'easyoriginal' ) . '</span><h2>' . esc_html__( 'So sieht eine Seite aus', 'easyoriginal' ) . '</h2>';
		echo '<p class="lead">' . esc_html__( 'Erst der Absatz mit Übersetzung und Erklärungen, dann derselbe Absatz im reinen Original. Hören Sie dazu die Audioaufnahme.', 'easyoriginal' ) . '</p>';
		echo '<p class="legend"><span><i class="legend__o"></i> ' . esc_html__( 'Originaltext', 'easyoriginal' ) . '</span><span><i class="legend__g"></i> ' . esc_html__( 'Übersetzung & Erklärungen', 'easyoriginal' ) . '</span></p>';
		if ( $s['pdf'] ) {
			echo '<p><a class="link-arrow" href="' . esc_url( $s['pdf'] ) . '" target="_blank" rel="noopener">' . esc_html__( 'Längere Leseprobe als PDF', 'easyoriginal' ) . '</a></p>';
		}
		echo '</div>' . eo_reader_html( $s, array( 'mode' => 'both' ) ) . '</div></section>'; // phpcs:ignore
	},
	5
);

/* Kaufleiste am unteren Rand (mobil). */
add_action(
	'wp_footer',
	function () {
		if ( ! is_product() ) {
			return;
		}
		$product = wc_get_product( get_queried_object_id() );
		if ( ! $product || ! $product->is_purchasable() ) {
			return;
		}
		list( $orig ) = eo_product_titles( $product );
		echo '<div class="sticky-buy" aria-hidden="true"><div><strong>' . wp_kses_post( $product->get_price_html() ) . '</strong><small>' . esc_html( $orig ) . '</small></div><a class="btn" href="#eo-buy" tabindex="-1">' . esc_html( $product->is_type( 'variable' ) ? __( 'Format wählen', 'easyoriginal' ) : __( 'In den Warenkorb', 'easyoriginal' ) ) . '</a></div>';
	}
);

add_action(
	'woocommerce_before_add_to_cart_form',
	function () {
		echo '<span id="eo-buy"></span>';
	}
);
