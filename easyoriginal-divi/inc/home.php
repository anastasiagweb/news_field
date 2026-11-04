<?php
/**
 * Bausteine der Startseite und Shortcodes für den Divi Builder.
 *
 *   [eo_startseite]                      alle Bausteine in Reihenfolge
 *   [eo_baustein name="regal"]           einzelner Baustein (Namen siehe eo_home_blocks())
 *   [eo_leseprobe produkt="123"]         Frank-Leseprobe eines Produkts mit Umschalter und Audio
 *   [eo_katalog sprache="en"]            filterbarer Katalog (Niveau, Reihe, Suche, Sortierung)
 *
 * @package easyoriginal
 */

defined( 'ABSPATH' ) || exit;

/**
 * Reihenfolge und Funktionen der Bausteine.
 */
function eo_home_blocks() {
	return apply_filters(
		'eo_home_blocks',
		array(
			'hero'       => 'eo_block_hero',
			'stats'      => 'eo_block_stats',
			'sprachen'   => 'eo_block_languages',
			'laufband'   => 'eo_block_marquee',
			'methode'    => 'eo_block_method',
			'regal'      => 'eo_block_bookshelf',
			'auswahl'    => 'eo_block_picks',
			'niveau'     => 'eo_block_levels',
			'aktion'     => 'eo_block_feature',
			'geschichte' => 'eo_block_story',
			'stimme'     => 'eo_block_review',
			'faq'        => 'eo_block_faq',
			'newsletter' => 'eo_block_newsletter',
		)
	);
}

/** Trennlinien (Ornament / Welle je nach Variante) vor diesen Bausteinen. */
function eo_dividers_before() {
	return array( 'sprachen', 'methode', 'niveau', 'faq' );
}

function eo_render_home() {
	$hidden = array_map( 'trim', explode( ',', (string) eo_opt( 'home_hidden' ) ) );
	$out    = '';
	foreach ( eo_home_blocks() as $name => $fn ) {
		if ( in_array( $name, $hidden, true ) || ! is_callable( $fn ) ) {
			continue;
		}
		if ( in_array( $name, eo_dividers_before(), true ) && 'sprachen' !== $name ) {
			$out .= '<div class="divider" aria-hidden="true"></div>';
		}
		$out .= call_user_func( $fn );
	}
	return '<div class="eo-home">' . $out . '</div>';
}

/* --------------------------------------------------------------------------
 * Frank-Leseprobe
 * ------------------------------------------------------------------------ */

/**
 * Text im Frank-Format → [HTML mit Hilfen, HTML ohne Hilfen].
 * Format: Originaltext, Übersetzungen/Erklärungen in runden Klammern direkt dahinter.
 * „wort — Bedeutung“ in der Klammer wird automatisch kursiv gesetzt. Absätze durch Leerzeilen.
 */
function eo_frank_parse( $text, $lang = '' ) {
	$text  = str_replace( array( "\r\n", "\r" ), "\n", trim( (string) $text ) );
	$paras = preg_split( '/\n\s*\n/', $text );
	$help  = '';
	$plain = '';
	$la    = $lang ? ' lang="' . esc_attr( $lang ) . '"' : '';
	foreach ( $paras as $p ) {
		$p      = preg_replace( '/\s+/u', ' ', trim( $p ) );
		$tokens = array();
		$buf    = '';
		$depth  = 0;
		$len    = mb_strlen( $p );
		for ( $i = 0; $i < $len; $i++ ) {
			$ch = mb_substr( $p, $i, 1 );
			if ( '(' === $ch ) {
				if ( 0 === $depth ) {
					if ( '' !== $buf ) {
						$tokens[] = array( 'o', $buf );
					}
					$buf = '';
				} else {
					$buf .= $ch;
				}
				$depth++;
			} elseif ( ')' === $ch && $depth > 0 ) {
				$depth--;
				if ( 0 === $depth ) {
					$tokens[] = array( 'g', $buf );
					$buf      = '';
				} else {
					$buf .= $ch;
				}
			} else {
				$buf .= $ch;
			}
		}
		if ( '' !== $buf ) {
			$tokens[] = array( $depth ? 'g' : 'o', $buf );
		}
		$h = '';
		$o = '';
		foreach ( $tokens as $t ) {
			if ( 'o' === $t[0] ) {
				$h .= '<span class="o">' . esc_html( $t[1] ) . '</span>';
				$o .= $t[1];
			} else {
				$g  = esc_html( trim( $t[1] ) );
				$g  = preg_replace( '/(^|;\s*)([^;—]+?)\s+—\s+/u', '$1<i' . $la . '>$2</i> — ', $g );
				$h .= '<span class="g" lang="de">(' . $g . ')</span>';
			}
		}
		$o      = preg_replace( '/\s+([.,!?;:…])/u', '$1', preg_replace( '/\s+/u', ' ', $o ) );
		$help  .= '<p class="frank"' . $la . '>' . $h . '</p>';
		$plain .= '<p class="frank-plain"' . $la . '>' . esc_html( trim( $o ) ) . '</p>';
	}
	return array( $help, $plain );
}

/** Eingebaute Leseprobe (Arsène Lupin), falls kein Produkt eine Probe hat. */
function eo_default_sample() {
	return array(
		'text'   => 'L’étrange voyage (die seltsame Reise)! Il avait si bien commencé cependant (sie hatte doch so gut begonnen; commencer — beginnen; cependant — jedoch, dennoch)! Pour ma part (für meinen Teil), je n’en fis jamais (habe ich mich nie auf eine begeben: „machte ich nie eine davon“; en faire — /hier: eine Reise/ machen; „en“ ersetzt das vorher genannte Wort „Reise“) qui s’annonçât sous de plus heureux auspices (die sich verheißungsvoller: „unter glücklicheren Vorzeichen“ ankündigte; s’annoncer — sich ankündigen, versprechen; ça s’annonce bien — das sieht gut aus; ça s’annonce plutôt mal — das sieht ziemlich schlecht aus; auspice m — Vorzeichen). La Provence est un transatlantique rapide, confortable (die „Provence“ ist ein schneller und komfortabler Ozeandampfer; transatlantique — transatlantisch; /bateau/ transatlantique m — Ozeandampfer; rapide — schnell, geschwind), commandé par le plus affable des hommes (befehligt von dem liebenswürdigsten Menschen: „befehligt von dem liebenswürdigsten der Menschen“; affable — freundlich, nett, liebenswürdig). La société la plus choisie (die erlesenste Gesellschaft; choisir — auswählen, auslesen) s’y trouvait réunie (versammelte sich dort: „befand sich dort versammelt“; y — dort; se trouver — sich befinden; réunir — versammeln, verbinden; sich treffen; réuni — versammelt).',
		'audio'  => 'https://easyoriginal1.s3.eu-central-1.amazonaws.com/franzoesisch/f1/1.mp3',
		'lang'   => 'fr',
		'author' => 'Maurice Leblanc',
		'title'  => 'L’Arrestation d’Arsène Lupin',
		'de'     => 'Die Verhaftung von Arsène Lupin',
		'url'    => home_url( '/' ),
		'pdf'    => '',
	);
}

/**
 * Leseprobe eines Produkts (oder Standard-Probe).
 */
function eo_get_sample( $product_id = 0 ) {
	$pid = $product_id ? absint( $product_id ) : absint( eo_opt( 'sample_product' ) );
	if ( ! $pid && function_exists( 'wc_get_product_id_by_sku' ) ) {
		$pid = wc_get_product_id_by_sku( 'DF1' );
	}
	$product = $pid && function_exists( 'wc_get_product' ) ? wc_get_product( $pid ) : null;
	$text    = $product ? get_post_meta( $product->get_id(), '_eo_leseprobe', true ) : '';
	if ( $product && $text ) {
		list( $orig, $de ) = eo_product_titles( $product );
		return array(
			'text'    => $text,
			'audio'   => get_post_meta( $product->get_id(), '_eo_audio', true ),
			'pdf'     => get_post_meta( $product->get_id(), '_eo_leseprobe_pdf', true ),
			'lang'    => eo_product_lang( $product ),
			'author'  => eo_product_author( $product ),
			'title'   => $orig,
			'de'      => $de,
			'url'     => $product->get_permalink(),
			'product' => $product,
		);
	}
	$s = eo_default_sample();
	if ( $product ) {
		$s['url']     = $product->get_permalink();
		$s['product'] = $product;
	}
	return $s;
}

/**
 * Buchseite mit Umschalter „Mit/Ohne Hilfen“ und Audio.
 *
 * @param array $s     Probe aus eo_get_sample().
 * @param array $args  mode: toggle|both, fade (bool), head (string).
 */
function eo_reader_html( $s, $args = array() ) {
	$args              = wp_parse_args( $args, array( 'mode' => 'toggle', 'fade' => true ) );
	list( $help, $pl ) = eo_frank_parse( $s['text'], $s['lang'] );
	$langs             = eo_langs();
	$lang_name         = ( $s['lang'] && isset( $langs[ $s['lang'] ] ) ) ? $langs[ $s['lang'] ]['name'] : '';
	ob_start();
	?>
	<div class="bookpage reader" data-mode="help">
		<div class="bookpage__head"><span><?php echo esc_html( $s['author'] ); ?></span><span><?php echo esc_html( 'both' === $args['mode'] ? $s['title'] : trim( $lang_name . ' · ' . __( 'Leseprobe', 'easyoriginal' ), ' ·' ) ); ?></span></div>
		<?php if ( 'both' === $args['mode'] ) : ?>
			<h3><?php esc_html_e( 'Mit Hilfen', 'easyoriginal' ); ?></h3>
			<div class="reader__both"><?php echo $help; // phpcs:ignore ?></div>
			<h3><?php esc_html_e( 'Ohne Hilfen', 'easyoriginal' ); ?></h3>
			<div class="reader__both"><?php echo $pl; // phpcs:ignore ?></div>
		<?php else : ?>
			<div class="<?php echo $args['fade'] ? 'reader__fade' : 'reader__body'; ?>"><?php echo $help . $pl; // phpcs:ignore ?></div>
		<?php endif; ?>
		<div class="bookpage__controls">
			<?php if ( 'both' !== $args['mode'] ) : ?>
				<div class="toggle" role="group" aria-label="<?php esc_attr_e( 'Ansicht', 'easyoriginal' ); ?>">
					<button type="button" data-mode="help" aria-pressed="true"><?php esc_html_e( 'Mit Hilfen', 'easyoriginal' ); ?></button>
					<button type="button" data-mode="plain" aria-pressed="false"><?php esc_html_e( 'Ohne Hilfen', 'easyoriginal' ); ?></button>
				</div>
			<?php else : ?>
				<span class="reader__note"><?php esc_html_e( 'Audioaufnahme zum Abschnitt', 'easyoriginal' ); ?></span>
			<?php endif; ?>
			<?php if ( ! empty( $s['audio'] ) ) : ?>
				<button class="audio-btn" type="button" aria-pressed="false">
					<span class="audio-btn__icon"><?php echo eo_icon( 'play', 'ic-play' ) . eo_icon( 'pause', 'ic-pause' ); // phpcs:ignore ?></span>
					<span class="audio-btn__label"><?php esc_html_e( 'Anhören', 'easyoriginal' ); ?></span>
					<span class="audio-btn__bar" aria-hidden="true"><span></span></span>
				</button>
				<audio preload="none" src="<?php echo esc_url( $s['audio'] ); ?>"></audio>
			<?php endif; ?>
		</div>
	</div>
	<?php
	return ob_get_clean();
}

/* --------------------------------------------------------------------------
 * Bausteine
 * ------------------------------------------------------------------------ */

function eo_portrait_products( $args, $count ) {
	$args['limit'] = max( $count * 3, 12 );
	$list          = array();
	foreach ( eo_query_products( $args ) as $p ) {
		if ( ! eo_is_square_image( $p ) ) {
			$list[] = $p;
		}
		if ( count( $list ) >= $count ) {
			break;
		}
	}
	return $list;
}

function eo_book3d( $product, $class = '', $size = 'woocommerce_thumbnail', $style = '' ) {
	return '<a class="book3d ' . esc_attr( $class ) . '" style="--c:' . esc_attr( eo_cover_color( $product ) ) . ';' . esc_attr( $style ) . '" href="' . esc_url( $product->get_permalink() ) . '" tabindex="-1"><span class="book3d__inner">' . $product->get_image( $size, array( 'alt' => '', 'loading' => 'eager' ) ) . '</span></a>';
}

function eo_block_hero() {
	$sample = eo_get_sample();
	$ids    = array_filter( array_map( 'absint', explode( ',', (string) eo_opt( 'hero_products' ) ) ) );
	$books  = array();
	if ( function_exists( 'wc_get_product' ) ) {
		$books = $ids ? eo_query_products( array( 'ids' => array_slice( $ids, 0, 5 ) ) ) : eo_portrait_products( array( 'orderby' => 'popularity' ), 6 );
		if ( ! $ids && ! empty( $sample['product'] ) ) {
			$sid   = $sample['product']->get_id();
			$books = array_values( array_filter( $books, function ( $b ) use ( $sid ) { return $b->get_id() !== $sid; } ) );
			array_unshift( $books, $sample['product'] );
		}
		$books = array_slice( $books, 0, 5 );
	}
	$issue = array_map( 'trim', explode( '|', (string) eo_opt( 'hero_issue' ) ) );
	$ticks = array_filter( array_map( 'trim', preg_split( '/\r\n|\n/', (string) eo_opt( 'hero_ticks' ) ) ) );
	ob_start();
	?>
	<section class="hero">
		<div class="hero__bg" aria-hidden="true"><span class="blob blob--1"></span><span class="blob blob--2"></span><span class="blob blob--3"></span></div>
		<div class="container hero__grid">
			<div class="hero__text">
				<p class="hero__issue"><?php foreach ( $issue as $part ) { echo '<span>' . esc_html( $part ) . '</span>'; } ?></p>
				<span class="eyebrow"><?php echo esc_html( eo_opt( 'hero_eyebrow' ) ); ?></span>
				<h1 class="hero__title"><?php echo esc_html( eo_opt( 'hero_title' ) ); ?> <em><?php echo esc_html( eo_opt( 'hero_title_em' ) ); ?></em></h1>
				<p class="lead hero__lead"><?php echo esc_html( eo_opt( 'hero_lead' ) ); ?></p>
				<div class="hero__ctas">
					<a class="btn btn--lg" href="<?php echo esc_url( eo_url( eo_opt( 'hero_cta1_url' ) ) ); ?>"><?php echo esc_html( eo_opt( 'hero_cta1' ) ); ?> <?php echo eo_icon( 'right' ); // phpcs:ignore ?></a>
					<?php if ( eo_opt( 'hero_cta2' ) ) : ?>
						<a class="btn btn--ghost btn--lg" href="<?php echo esc_url( eo_url( eo_opt( 'hero_cta2_url' ) ) ); ?>"><?php echo esc_html( eo_opt( 'hero_cta2' ) ); ?></a>
					<?php endif; ?>
				</div>
				<?php if ( $ticks ) : ?>
					<ul class="ticks"><?php foreach ( $ticks as $t ) { echo '<li>' . eo_icon( 'check' ) . ' ' . esc_html( $t ) . '</li>'; } // phpcs:ignore ?></ul>
				<?php endif; ?>
			</div>
			<div class="hero__visual">
				<div class="hero__books" aria-hidden="true">
					<?php
					foreach ( $books as $i => $b ) {
						echo eo_book3d( $b, 'hb hb--' . ( $i + 1 ), 0 === $i ? 'woocommerce_single' : 'woocommerce_thumbnail' ); // phpcs:ignore
					}
					?>
				</div>
				<div class="hero__bubbles" aria-hidden="true">
					<?php foreach ( array( 'en', 'fr', 'it', 'es', 'ru' ) as $c ) : $l = eo_langs()[ $c ]; ?>
						<span class="bubble lang-<?php echo esc_attr( $c ); ?>" lang="<?php echo esc_attr( $c ); ?>"><?php echo esc_html( $l['hello'] ); ?></span>
					<?php endforeach; ?>
				</div>
				<span class="hero__sticker" aria-hidden="true"><?php esc_html_e( 'mit Audio ♪', 'easyoriginal' ); ?></span>
				<figure class="hero__page">
					<span class="hero__note hero__note--1"><?php esc_html_e( 'Übersetzung direkt im Text', 'easyoriginal' ); ?></span>
					<?php echo eo_reader_html( $sample ); // phpcs:ignore ?>
					<figcaption class="legend">
						<span><i class="legend__o"></i> <?php esc_html_e( 'Originaltext', 'easyoriginal' ); ?></span>
						<span><i class="legend__g"></i> <?php esc_html_e( 'Übersetzung & Erklärungen', 'easyoriginal' ); ?></span>
						<a class="link-arrow" href="<?php echo esc_url( $sample['url'] ); ?>"><?php echo esc_html( sprintf( __( 'Aus „%s“', 'easyoriginal' ), $sample['de'] ? $sample['de'] : $sample['title'] ) ); ?></a>
					</figcaption>
				</figure>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

function eo_block_stats() {
	$icons = array( 'globe', 'stairs', 'headphones', 'truck' );
	$out   = '<section class="stats" aria-label="' . esc_attr__( 'Auf einen Blick', 'easyoriginal' ) . '"><div class="container stats__row">';
	foreach ( array_slice( eo_lines( 'stats' ), 0, 4 ) as $i => $s ) {
		$out .= '<div class="stat" data-reveal style="--d:' . ( $i * 0.08 ) . 's"><span class="stat__icon">' . eo_icon( $icons[ $i ] ) . '</span><div><strong>' . esc_html( $s[0] ) . '</strong><span>' . esc_html( $s[1] ) . '</span></div></div>';
	}
	return $out . '</div></section>';
}

function eo_section_head( $eyebrow, $title, $text = '', $extra = '', $id = '' ) {
	return '<div class="section-head"><div><span class="eyebrow">' . esc_html( $eyebrow ) . '</span><h2' . ( $id ? ' id="' . esc_attr( $id ) . '"' : '' ) . '>' . esc_html( $title ) . '</h2>' . ( $text ? '<p>' . esc_html( $text ) . '</p>' : '' ) . '</div>' . $extra . '</div>';
}

function eo_block_languages() {
	$out = '<div class="divider" aria-hidden="true"></div><section class="section section--langs numbered" id="sprachen"><div class="container">';
	$out .= eo_section_head( __( 'Die Sprachen', 'easyoriginal' ), __( 'Welche Sprache möchten Sie lesen?', 'easyoriginal' ), __( 'Alle Bücher erscheinen zweisprachig mit Deutsch. Viele Titel gibt es auch mit Englisch als Hilfssprache.', 'easyoriginal' ) );
	$out .= '<div class="langs">';
	$i    = 0;
	foreach ( eo_langs() as $code => $l ) {
		$covers = '';
		$cats   = eo_lang_cat_ids( $code );
		if ( $cats && function_exists( 'wc_get_product' ) ) {
			$picks = eo_portrait_products( array( 'cats' => $cats ), 3 );
			if ( ! $picks ) { // nur Set-Fotos vorhanden → diese verwenden
				$picks = eo_query_products( array( 'cats' => $cats, 'limit' => 3 ) );
			}
			foreach ( $picks as $p ) {
				$covers .= $p->get_image( 'woocommerce_thumbnail', array( 'alt' => '', 'loading' => 'lazy' ) );
			}
		}
		$links = '';
		foreach ( $l['links'] as $link ) {
			$links .= '<li><a href="' . esc_url( eo_url( $link[1] ) ) . '">' . esc_html( $link[0] ) . '</a></li>';
		}
		$quote_lang = 'de' === $code ? '' : ' lang="' . esc_attr( $code ) . '"';
		$out       .= '<article class="lang-card lang-' . esc_attr( $code ) . '" data-reveal style="--d:' . ( ( $i % 3 ) * 0.06 ) . 's">'
			. ( $covers ? '<div class="lang-card__covers" aria-hidden="true">' . $covers . '</div>' : '' )
			. '<div class="lang-card__top"><span class="lang-card__code">' . esc_html( $l['code'] ) . '</span><span class="lang-card__hello"' . $quote_lang . '>' . esc_html( $l['hello'] ) . '</span><span class="lang-card__arrow">' . eo_icon( 'right' ) . '</span></div>'
			. '<h3><a href="' . esc_url( $l['url'] ) . '">' . esc_html( $l['name'] ) . '</a></h3>'
			. '<blockquote' . $quote_lang . '>' . esc_html( $l['quote'] ) . '<cite>' . esc_html( $l['cite'] ) . '</cite></blockquote>'
			. '<ul>' . $links . '</ul></article>';
		$i++;
	}
	return $out . '</div></div></section>';
}

function eo_block_marquee() {
	if ( ! function_exists( 'wc_get_product' ) ) {
		return '';
	}
	$books = eo_portrait_products( array( 'orderby' => 'date' ), 20 );
	if ( count( $books ) < 6 ) {
		return '';
	}
	$half = (int) ceil( count( $books ) / 2 );
	$rows = array( array_slice( $books, 0, $half ), array_slice( $books, $half ) );
	$out  = '<section class="marquee" aria-hidden="true">';
	foreach ( $rows as $row ) {
		$cells = '';
		foreach ( $row as $p ) {
			$cells .= '<a href="' . esc_url( $p->get_permalink() ) . '" tabindex="-1">' . $p->get_image( 'woocommerce_thumbnail', array( 'alt' => '', 'loading' => 'lazy' ) ) . '</a>';
		}
		$out .= '<div class="marquee__row">' . $cells . $cells . '</div>';
	}
	return $out . '</section>';
}

function eo_block_method() {
	$link = '<a class="link-arrow" href="' . esc_url( eo_url( eo_opt( 'method_url' ) ) ) . '">' . esc_html__( 'Ausführlich erklärt', 'easyoriginal' ) . '</a>';
	ob_start();
	?>
	<section class="section section--method numbered" id="methode">
		<div class="container">
			<?php echo eo_section_head( __( 'Die Frank-Lesemethode', 'easyoriginal' ), __( 'Ein Absatz, drei Schritte', 'easyoriginal' ), __( 'Kein Pauken, kein Wörterbuch: Sie lernen Wörter und Grammatik dort, wo sie vorkommen – in einer Geschichte, die Sie weiterlesen möchten.', 'easyoriginal' ), $link ); // phpcs:ignore ?>
			<div class="steps">
				<div class="step" data-reveal>
					<div class="step__num">1</div>
					<h3><?php esc_html_e( 'Mit Hilfen lesen', 'easyoriginal' ); ?></h3>
					<p><?php esc_html_e( 'Jeder Satz steht im Original, die Übersetzung folgt direkt dahinter – mit Erklärungen zu Wörtern und Grammatik.', 'easyoriginal' ); ?></p>
					<div class="step__demo" lang="fr"><span class="o">Pour ma part</span> <span class="g" lang="de">(für meinen Teil)</span>, <span class="o">je n’en fis jamais</span> <span class="g" lang="de">(habe ich mich nie auf eine begeben)</span> …</div>
				</div>
				<div class="step" data-reveal style="--d:.1s">
					<div class="step__num">2</div>
					<h3><?php esc_html_e( 'Ohne Hilfen wiederholen', 'easyoriginal' ); ?></h3>
					<p><?php esc_html_e( 'Danach kommt derselbe Absatz noch einmal – ohne Übersetzung. Sie lesen ihn schon fast wie ein Muttersprachler.', 'easyoriginal' ); ?></p>
					<div class="step__demo" lang="fr">Pour ma part, je n’en fis jamais qui s’annonçât sous de plus heureux auspices.</div>
				</div>
				<div class="step" data-reveal style="--d:.2s">
					<div class="step__num">3</div>
					<h3><?php esc_html_e( 'Hören & mitlesen', 'easyoriginal' ); ?></h3>
					<p><?php esc_html_e( 'Zu vielen Büchern gibt es Audio – online oder auf CD. So trainieren Sie Aussprache und Hörverstehen nebenbei.', 'easyoriginal' ); ?></p>
					<div class="step__demo step__demo--audio"><span class="audio-btn__icon" aria-hidden="true"><?php echo eo_icon( 'play' ); // phpcs:ignore ?></span><span class="wave" aria-hidden="true"></span><span class="step__demo-note"><?php esc_html_e( 'Online oder CD', 'easyoriginal' ); ?></span></div>
				</div>
			</div>
			<p class="method-note"><?php echo eo_icon( 'info' ); // phpcs:ignore ?><span><?php esc_html_e( 'Ganz ehrlich: Kein Buch bringt Ihnen das Sprechen bei – dafür braucht es Praxis. Aber mit einem großen passiven Wortschatz lernen Sie viel schneller und sicherer sprechen.', 'easyoriginal' ); ?></span></p>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

function eo_block_bookshelf() {
	if ( ! function_exists( 'wc_get_product' ) ) {
		return '';
	}
	$books = eo_portrait_products( array( 'orderby' => 'popularity' ), 30 );
	if ( count( $books ) < 8 ) {
		return '';
	}
	$langs  = eo_langs();
	$spines = '';
	foreach ( $books as $p ) {
		list( $orig, $de ) = eo_product_titles( $p );
		$c      = eo_cover_color( $p );
		$lang   = eo_product_lang( $p );
		$author = eo_product_author( $p );
		$h      = 150 + ( crc32( $orig ) % 56 );
		$price  = (float) $p->get_price();
		$w      = max( 24, min( 50, (int) round( 22 + $price * 0.9 ) ) );
		$label  = $orig . ( $author ? ' – ' . $author : '' ) . ( $de ? ' (' . $de . ')' : '' );
		$spines .= '<a class="spine' . ( $lang ? ' lang-' . esc_attr( $lang ) : '' ) . '" href="' . esc_url( $p->get_permalink() ) . '" style="--c:' . esc_attr( $c ) . ';--spine-ink:' . esc_attr( eo_ink_for( $c ) ) . ';--w:' . $w . 'px;--h:' . $h . 'px" aria-label="' . esc_attr( $label ) . '">'
			. '<span class="spine__title">' . esc_html( $orig ) . '</span><span class="spine__code">' . esc_html( $lang ? $langs[ $lang ]['code'] : '' ) . '</span>'
			. '<span class="spine__peek" aria-hidden="true">' . $p->get_image( 'woocommerce_thumbnail', array( 'alt' => '', 'loading' => 'lazy' ) ) . '<small>' . esc_html( $orig ) . '</small></span></a>';
	}
	return '<section class="section section--shelf numbered" aria-labelledby="eo-regal-h"><div class="container">'
		. eo_section_head( __( 'Stöbern', 'easyoriginal' ), __( 'Ein Blick ins Regal', 'easyoriginal' ), __( 'Klassiker und moderne Geschichten in sechs Sprachen. Fahren Sie über einen Buchrücken, um das Cover zu sehen.', 'easyoriginal' ), '', 'eo-regal-h' )
		. '<div class="bookshelf"><div class="bookshelf__row">' . $spines . '</div><div class="bookshelf__plank"></div></div></div></section>';
}

function eo_cat_ids_from_slugs( $slugs ) {
	$ids = array();
	foreach ( array_filter( array_map( 'trim', explode( ',', (string) $slugs ) ) ) as $slug ) {
		$t = get_term_by( 'slug', $slug, 'product_cat' );
		if ( $t ) {
			$ids[] = (int) $t->term_id;
		}
	}
	return $ids;
}

function eo_block_picks() {
	if ( ! function_exists( 'wc_get_product' ) ) {
		return '';
	}
	$tabs = array(
		'bestseller' => array( __( 'Bestseller', 'easyoriginal' ), eo_query_products( array( 'orderby' => 'popularity', 'limit' => 12 ) ) ),
		'neu'        => array( __( 'Neu', 'easyoriginal' ), eo_query_products( array( 'orderby' => 'date', 'limit' => 12 ) ) ),
	);
	$set_cats = eo_cat_ids_from_slugs( eo_opt( 'sets_cats' ) );
	if ( $set_cats ) {
		$tabs['sets'] = array( __( 'Bücher-Sets', 'easyoriginal' ), eo_query_products( array( 'orderby' => 'popularity', 'limit' => 12, 'cats' => $set_cats ) ) );
	}
	$tabs = array_filter( $tabs, function ( $t ) { return ! empty( $t[1] ); } );
	if ( ! $tabs ) {
		return '';
	}
	$btns   = '';
	$panels = '';
	$first  = true;
	foreach ( $tabs as $key => $t ) {
		$btns  .= '<button role="tab" type="button" id="eo-tab-' . esc_attr( $key ) . '" aria-controls="eo-panel-' . esc_attr( $key ) . '" aria-selected="' . ( $first ? 'true' : 'false' ) . '" data-key="' . esc_attr( $key ) . '">' . esc_html( $t[0] ) . '</button>';
		$cards  = '';
		foreach ( $t[1] as $p ) {
			$cards .= eo_card( $p );
		}
		$panels .= '<div class="shelf__track" role="tabpanel" id="eo-panel-' . esc_attr( $key ) . '" aria-labelledby="eo-tab-' . esc_attr( $key ) . '"' . ( $first ? '' : ' hidden' ) . '>' . $cards . '</div>';
		$first   = false;
	}
	$controls = '<div class="shelf-controls"><div class="shelf-tabs" role="tablist" aria-label="' . esc_attr__( 'Auswahl', 'easyoriginal' ) . '">' . $btns . '</div>'
		. '<div class="shelf__nav"><button type="button" data-shelf-prev aria-label="' . esc_attr__( 'Zurück', 'easyoriginal' ) . '">' . eo_icon( 'left' ) . '</button><button type="button" data-shelf-next aria-label="' . esc_attr__( 'Weiter', 'easyoriginal' ) . '">' . eo_icon( 'right' ) . '</button></div></div>';
	return '<section class="section section--tight section--picks numbered"><div class="container" id="shelf">'
		. eo_section_head( __( 'Aus dem Programm', 'easyoriginal' ), __( 'Was gerade gelesen wird', 'easyoriginal' ), '', $controls )
		. '<div class="shelf">' . $panels . '</div></div></section>';
}

function eo_level_url( $slug ) {
	$base = eo_url( eo_opt( 'levels_url' ) );
	return taxonomy_exists( 'pa_niveau' ) ? add_query_arg( 'filter_niveau', $slug, $base ) : $base;
}

function eo_block_levels() {
	$levels = array(
		array( 'a1-a2', __( 'Einstieg', 'easyoriginal' ), 'A1–A2', __( 'Kurze moderne Krimis und lustige Geschichten. Jeder Satz übersetzt und erklärt – ideal nach einem Grundkurs oder einer Sprach-App.', 'easyoriginal' ) ),
		array( 'a2-b1', __( 'Aufbau', 'easyoriginal' ), 'A2–B1', __( 'Mehr Handlung, längere Kapitel: Krimis, Humor und Alltagsgeschichten – weiterhin mit allen Hilfen.', 'easyoriginal' ) ),
		array( 'b1-b2', __( 'Fortgeschritten', 'easyoriginal' ), 'B1–B2', __( 'Moderne Lektüre mit Worterklärungen statt Satz-für-Satz-Übersetzung. Sie lesen schon fast frei.', 'easyoriginal' ) ),
		array( 'original', __( 'Klassiker', 'easyoriginal' ), __( 'Original', 'easyoriginal' ), __( 'Austen, Dickens, Leblanc, Tschechow: ungekürzte Originaltexte, mit der Frank-Lesemethode lesbar gemacht.', 'easyoriginal' ) ),
	);
	$out = '<section class="section section--levels numbered" id="niveau"><div class="container">'
		. eo_section_head( __( 'Ihr Einstieg', 'easyoriginal' ), __( 'Welches Niveau passt zu Ihnen?', 'easyoriginal' ), __( 'Unsicher? Starten Sie lieber eine Stufe leichter – Lesen soll Freude machen, nicht anstrengen.', 'easyoriginal' ) )
		. '<div class="levels">';
	foreach ( $levels as $i => $l ) {
		$meter = '';
		for ( $k = 0; $k < 4; $k++ ) {
			$meter .= '<i' . ( $k <= $i ? ' class="on"' : '' ) . '></i>';
		}
		$out .= '<a class="level" href="' . esc_url( eo_level_url( $l[0] ) ) . '" data-reveal style="--d:' . ( $i * 0.08 ) . 's"><span class="level__name">' . esc_html( $l[1] ) . '</span><span class="level__tag">' . esc_html( $l[2] ) . '</span><p>' . esc_html( $l[3] ) . '</p><span class="meter" aria-label="' . esc_attr( sprintf( __( 'Schwierigkeit %d von 4', 'easyoriginal' ), $i + 1 ) ) . '">' . $meter . '</span></a>';
	}
	return $out . '</div></div></section>';
}

function eo_block_feature() {
	if ( ! eo_opt( 'feature_title' ) ) {
		return '';
	}
	$imgs = '';
	if ( function_exists( 'wc_get_product' ) ) {
		$ids      = array_filter( array_map( 'absint', explode( ',', (string) eo_opt( 'feature_products' ) ) ) );
		$products = $ids ? eo_query_products( array( 'ids' => array_slice( $ids, 0, 3 ) ) ) : array();
		if ( ! $products ) {
			$cats     = eo_cat_ids_from_slugs( eo_opt( 'feature_cats' ) );
			$products = $cats ? eo_query_products( array( 'cats' => $cats, 'limit' => 3, 'orderby' => 'date' ) ) : array();
		}
		foreach ( $products as $p ) {
			$imgs .= '<a href="' . esc_url( $p->get_permalink() ) . '" aria-label="' . esc_attr( $p->get_name() ) . '">' . $p->get_image( 'woocommerce_single', array( 'alt' => '', 'loading' => 'lazy' ) ) . '</a>';
		}
	}
	return '<section class="section section--tight section--feature"><div class="container"><div class="feature" data-reveal><span class="feature__deco" aria-hidden="true"></span>'
		. '<div class="feature__text"><span class="eyebrow">' . esc_html( eo_opt( 'feature_eyebrow' ) ) . '</span><h2>' . esc_html( eo_opt( 'feature_title' ) ) . '</h2><p>' . esc_html( eo_opt( 'feature_text' ) ) . '</p>'
		. ( eo_opt( 'feature_price' ) ? '<span class="price-tag">' . esc_html( eo_opt( 'feature_price' ) ) . '</span><small class="feature__legal">' . esc_html__( 'inkl. MwSt., zzgl. Versand', 'easyoriginal' ) . '</small>' : '' )
		. '<div class="hero__ctas"><a class="btn btn--light" href="' . esc_url( eo_url( eo_opt( 'feature_url' ) ) ) . '">' . esc_html( eo_opt( 'feature_btn' ) ) . '</a></div></div>'
		. ( $imgs ? '<div class="feature__media">' . $imgs . '</div>' : '' )
		. '</div></div></section>';
}

function eo_block_story() {
	$name  = (string) eo_opt( 'story_name' );
	$mono  = '';
	foreach ( preg_split( '/\s+/u', trim( $name ) ) as $part ) {
		$mono .= mb_substr( $part, 0, 1 );
	}
	$facts = '';
	foreach ( eo_lines( 'story_facts' ) as $i => $f ) {
		$facts .= '<div class="fact" data-reveal style="--d:' . ( $i * 0.08 ) . 's"><h3>' . esc_html( $f[0] ) . '</h3><p>' . esc_html( $f[1] ) . '</p></div>';
	}
	$links = '';
	foreach ( eo_lines( 'story_links' ) as $l ) {
		$links .= '<a class="link-arrow" href="' . esc_url( eo_url( $l[1] ) ) . '">' . esc_html( $l[0] ) . '</a>';
	}
	return '<section class="section section--green section--story"><div class="container story"><div data-reveal><span class="eyebrow">' . esc_html__( 'Unsere Geschichte', 'easyoriginal' ) . '</span>'
		. '<blockquote>' . esc_html( eo_opt( 'story_quote' ) ) . '</blockquote>'
		. '<div class="signature"><span class="signature__mono" aria-hidden="true">' . esc_html( mb_strtoupper( mb_substr( $mono, 0, 2 ) ) ) . '</span><span><strong>' . esc_html( $name ) . '</strong>' . esc_html( eo_opt( 'story_role' ) ) . '</span></div></div>'
		. '<div class="facts">' . $facts . ( $links ? '<p class="story__links">' . $links . '</p>' : '' ) . '</div></div></section>';
}

function eo_block_review() {
	if ( ! function_exists( 'wc_get_product' ) ) {
		return '';
	}
	$reviews = get_comments(
		array(
			'post_type'  => 'product',
			'status'     => 'approve',
			'type'       => 'review',
			'number'     => 1,
			'meta_query' => array( array( 'key' => 'rating', 'value' => 5 ) ), // phpcs:ignore
		)
	);
	if ( ! $reviews ) {
		return '';
	}
	$r       = $reviews[0];
	$product = wc_get_product( $r->comment_post_ID );
	if ( ! $product ) {
		return '';
	}
	$text  = wp_strip_all_tags( $r->comment_content );
	$quote = $text;
	if ( mb_strlen( $text ) > 220 ) {
		// Satz mit „Methode“ bevorzugen, sonst die ersten Sätze.
		$sentences = preg_split( '/(?<=[.!?])\s+/u', $text );
		$quote     = '';
		foreach ( $sentences as $s ) {
			if ( false !== mb_stripos( $s, 'Methode' ) && mb_strlen( $s ) < 260 ) {
				$quote = $s;
				break;
			}
		}
		if ( ! $quote ) {
			$quote = wp_trim_words( $text, 36, ' …' );
		}
	}
	list( $orig, $de ) = eo_product_titles( $product );
	$langs             = eo_langs();
	$lang              = eo_product_lang( $product );
	$stars             = str_repeat( eo_icon( 'star' ), 5 );
	return '<section class="section section--tight section--review"><div class="container"><figure class="quote-review" data-reveal>'
		. eo_book3d( $product, 'quote-review__book', 'woocommerce_thumbnail', '--bw:150px;--bh:225px;--bt:20px;--ry:-22deg' )
		. '<div><span class="rating-stars" aria-label="' . esc_attr__( '5 von 5 Sternen', 'easyoriginal' ) . '">' . $stars . '</span>'
		. '<blockquote>„' . esc_html( trim( $quote ) ) . '“</blockquote>'
		. '<figcaption><strong>' . esc_html( $r->comment_author ) . '</strong> ' . esc_html( sprintf( __( 'über „%s“', 'easyoriginal' ), $de ? $de : $orig ) ) . ( $lang ? ' (' . esc_html( $langs[ $lang ]['name'] ) . ')' : '' ) . '</figcaption></div>'
		. '</figure></div></section>';
}

function eo_block_faq() {
	$items = '';
	foreach ( eo_lines( 'faq' ) as $i => $f ) {
		$answer = wp_kses_post( preg_replace_callback( '/href="(\/[^"]*)"/', function ( $m ) { return 'href="' . esc_url( eo_url( $m[1] ) ) . '"'; }, $f[1] ) );
		$items .= '<details' . ( 0 === $i ? ' open' : '' ) . '><summary>' . esc_html( $f[0] ) . '</summary><div><p>' . $answer . '</p></div></details>';
	}
	if ( ! $items ) {
		return '';
	}
	return '<section class="section section--tight section--faq" id="faq"><div class="container faq"><div><span class="eyebrow">' . esc_html__( 'Fragen & Antworten', 'easyoriginal' ) . '</span><h2>' . esc_html__( 'Gut zu wissen', 'easyoriginal' ) . '</h2>'
		. '<p class="lead">' . esc_html__( 'Noch etwas unklar? Schreiben Sie uns – wir helfen gern bei der Auswahl des richtigen Buches.', 'easyoriginal' ) . '</p>'
		. '<a class="btn btn--ghost" href="' . esc_url( eo_url( eo_opt( 'contact_url' ) ) ) . '">' . esc_html__( 'Kontakt aufnehmen', 'easyoriginal' ) . '</a></div><div>' . $items . '</div></div></section>';
}

function eo_block_newsletter() {
	$code = trim( (string) eo_opt( 'newsletter_code' ) );
	if ( ! $code ) {
		return '';
	}
	return '<section class="container section--newsletter"><div class="newsletter" data-reveal><div><h2>' . esc_html( eo_opt( 'newsletter_title' ) ) . '</h2><p>' . esc_html( eo_opt( 'newsletter_text' ) ) . '</p></div><div class="newsletter__form">' . do_shortcode( $code ) . '</div></div></section>';
}

/* --------------------------------------------------------------------------
 * Katalog mit Filtern (für Sprachseiten im Divi Builder)
 * ------------------------------------------------------------------------ */

function eo_catalog_html( $atts ) {
	if ( ! function_exists( 'wc_get_product' ) ) {
		return '';
	}
	$atts = shortcode_atts( array( 'sprache' => '', 'kategorien' => '', 'limit' => 400 ), $atts, 'eo_katalog' );
	$cats = $atts['kategorien'] ? eo_cat_ids_from_slugs( $atts['kategorien'] ) : ( $atts['sprache'] ? eo_lang_cat_ids( sanitize_key( $atts['sprache'] ) ) : array() );
	if ( ! $cats ) {
		return '<p>' . esc_html__( 'Keine Kategorien gefunden. Bitte im Shortcode sprache="en" oder kategorien="slug,slug" angeben.', 'easyoriginal' ) . '</p>';
	}
	$products = eo_query_products( array( 'cats' => $cats, 'limit' => absint( $atts['limit'] ), 'orderby' => 'popularity', 'require_image' => false ) );
	$levels   = array( 'A1–A2' => 0, 'A2–B1' => 0, 'B1–B2' => 0, 'Original' => 0 );
	$series   = array();
	$cards    = '';
	foreach ( $products as $rank => $p ) {
		$lvl = eo_product_level( $p );
		if ( isset( $levels[ $lvl ] ) ) {
			$levels[ $lvl ]++;
		}
		$names = array();
		foreach ( wp_get_post_terms( $p->get_id(), 'product_cat' ) as $t ) {
			if ( in_array( (int) $t->term_id, $cats, true ) || in_array( (int) $t->parent, $cats, true ) ) {
				$names[]             = $t->name;
				$series[ $t->name ] = isset( $series[ $t->name ] ) ? $series[ $t->name ] + 1 : 1;
			}
		}
		list( $orig, $de ) = eo_product_titles( $p );
		$search            = mb_strtolower( $orig . ' ' . $de . ' ' . eo_product_author( $p ) . ' ' . implode( ' ', $names ) );
		$price             = $p->is_type( 'variable' ) ? (float) $p->get_variation_price( 'min', true ) : (float) wc_get_price_to_display( $p );
		$cards            .= '<div class="eo-cat-item" data-level="' . esc_attr( $lvl ) . '" data-series="' . esc_attr( '|' . implode( '|', $names ) . '|' ) . '" data-sale="' . ( $p->is_on_sale() ? 1 : 0 ) . '" data-price="' . esc_attr( $price ) . '" data-rank="' . (int) $rank . '" data-title="' . esc_attr( mb_strtolower( $orig ) ) . '" data-search="' . esc_attr( $search ) . '">' . eo_card( $p, array( 'show_lang' => false ) ) . '</div>';
	}
	ksort( $series );
	$seg = '<button type="button" data-level="alle" aria-pressed="true">' . esc_html__( 'Alle', 'easyoriginal' ) . ' <small>' . count( $products ) . '</small></button>';
	foreach ( $levels as $l => $n ) {
		if ( $n ) {
			$seg .= '<button type="button" data-level="' . esc_attr( $l ) . '" aria-pressed="false">' . esc_html( 'Original' === $l ? __( 'Klassiker im Original', 'easyoriginal' ) : $l ) . ' <small>' . (int) $n . '</small></button>';
		}
	}
	$pills = '';
	foreach ( $series as $name => $n ) {
		$pills .= '<label class="pill-check"><input type="checkbox" name="reihe" value="' . esc_attr( $name ) . '"> ' . esc_html( $name ) . '</label>';
	}
	$uid = 'eo-cat-' . wp_rand( 1000, 9999 );
	return '<section class="eo-catalog" id="' . esc_attr( $uid ) . '" aria-label="' . esc_attr__( 'Bücher', 'easyoriginal' ) . '">'
		. '<div class="toolbar"><div class="toolbar__inner"><div class="seg" role="group" aria-label="' . esc_attr__( 'Niveau', 'easyoriginal' ) . '">' . $seg . '</div>'
		. '<div class="search-inline">' . eo_icon( 'search' ) . '<label class="sr-only" for="' . esc_attr( $uid ) . '-q">' . esc_html__( 'Suchen', 'easyoriginal' ) . '</label><input class="input" id="' . esc_attr( $uid ) . '-q" type="search" data-q placeholder="' . esc_attr__( 'Titel oder Autor', 'easyoriginal' ) . '"></div>'
		. '<label class="sr-only" for="' . esc_attr( $uid ) . '-sort">' . esc_html__( 'Sortieren', 'easyoriginal' ) . '</label><select class="select" id="' . esc_attr( $uid ) . '-sort" data-sort><option value="beliebt">' . esc_html__( 'Beliebteste zuerst', 'easyoriginal' ) . '</option><option value="preis_auf">' . esc_html__( 'Preis aufsteigend', 'easyoriginal' ) . '</option><option value="preis_ab">' . esc_html__( 'Preis absteigend', 'easyoriginal' ) . '</option><option value="titel">' . esc_html__( 'Titel A–Z', 'easyoriginal' ) . '</option></select></div></div>'
		. '<div class="subfilters-row"><div class="subfilters" role="group" aria-label="' . esc_attr__( 'Reihe', 'easyoriginal' ) . '"><span class="label">' . esc_html__( 'Reihe', 'easyoriginal' ) . '</span>' . $pills . '<label class="pill-check"><input type="checkbox" data-sale-only> ' . esc_html__( 'Nur Angebote', 'easyoriginal' ) . '</label></div><span class="result-count" aria-live="polite"></span></div>'
		. '<div class="book-grid">' . $cards . '<div class="empty" hidden><strong>' . esc_html__( 'Keine Treffer', 'easyoriginal' ) . '</strong>' . esc_html__( 'Versuchen Sie ein anderes Niveau oder entfernen Sie Filter.', 'easyoriginal' ) . '</div></div></section>';
}

/* --------------------------------------------------------------------------
 * Shortcodes
 * ------------------------------------------------------------------------ */

add_shortcode( 'eo_startseite', 'eo_render_home' );
add_shortcode(
	'eo_baustein',
	function ( $atts ) {
		$atts   = shortcode_atts( array( 'name' => '' ), $atts, 'eo_baustein' );
		$blocks = eo_home_blocks();
		return isset( $blocks[ $atts['name'] ] ) ? call_user_func( $blocks[ $atts['name'] ] ) : '';
	}
);
add_shortcode(
	'eo_leseprobe',
	function ( $atts ) {
		$atts = shortcode_atts( array( 'produkt' => 0 ), $atts, 'eo_leseprobe' );
		return eo_reader_html( eo_get_sample( absint( $atts['produkt'] ) ), array( 'fade' => false ) );
	}
);
add_shortcode( 'eo_katalog', 'eo_catalog_html' );
