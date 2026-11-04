<?php
/**
 * Einstellungen unter „Design → Customizer → easyOriginal“.
 *
 * @package easyoriginal
 */

defined( 'ABSPATH' ) || exit;

/**
 * Standardwerte aller Einstellungen (Schlüssel ohne Präfix „eo_“).
 */
function eo_defaults() {
	static $d = null;
	if ( null !== $d ) {
		return $d;
	}
	$d = array(
		// Variante.
		'skin'               => 'buch',
		'skin_switch'        => 1,
		// Kopf & Fuß.
		'topbar_text'        => 'Kostenlose Lieferung in der EU ab 39 €',
		'footer_text'        => 'Zweisprachige Bücher nach der Frank-Lesemethode – für alle, die Fremdsprachen durch Lesen lernen möchten.',
		'footer_legal'       => 'Alle Preise inkl. MwSt., zzgl. Versand · Kostenlose Lieferung in der EU ab 39 €',
		'copyright'          => '© 2020–' . gmdate( 'Y' ) . ' EasyOriginal Verlag e.U.',
		'facebook'           => 'https://www.facebook.com/EasyOriginalcom/',
		'instagram'          => 'https://www.instagram.com/easyoriginal_com/',
		'show_seal'          => 1,
		// Startseite – Hero.
		'hero_issue'         => 'Herbst / Winter ' . gmdate( 'Y' ) . ' | Sechs Sprachen · Ein Prinzip',
		'hero_eyebrow'       => 'Zweisprachige Bücher · Frank-Lesemethode',
		'hero_title'         => 'Fremdsprachen lernen –',
		'hero_title_em'      => 'einfach durch Lesen.',
		'hero_lead'          => 'Echte Geschichten und große Klassiker im Original. Die Übersetzung steht direkt im Text, danach folgt derselbe Absatz ohne Hilfen – und Audio zum Mithören. Von A1 bis zum ungekürzten Klassiker.',
		'hero_cta1'          => 'Sprache wählen',
		'hero_cta1_url'      => '#sprachen',
		'hero_cta2'          => 'So funktioniert’s',
		'hero_cta2_url'      => '#methode',
		'hero_ticks'         => "Ohne Wörterbuch lesen\nVon Ilya Frank betreut\nTaschenbuch, E-Book & Audio",
		'hero_products'      => '',
		'sample_product'     => '',
		// Startseite – Bausteine.
		'home_hidden'        => '',
		'stats'              => "6 Sprachen :: EN · FR · IT · ES · RU · DE\nA1 bis Original :: für jedes Niveau das passende Buch\nLesen & Hören :: Buch, E-Book und Audio\nGratis-Versand :: in der EU ab 39 €",
		'method_url'         => '/wie-lese-ich-das-easyoriginal-buch/',
		'sets_cats'          => 'buecher-sets,englisch-deutsch-bundle,franzoesisch-deutsch-bundle,italienisch-deutsch-bundle,spanisch-deutsch-bundle,russisch-deutsch-bundle',
		'levels_url'         => '/shop/',
		'feature_eyebrow'    => 'Neu zur Weihnachtszeit',
		'feature_title'      => 'Weihnachten in Spanien',
		'feature_text'       => 'Lustige Weihnachtsgeschichten auf Spanisch – als Bücher-Set für Einsteiger (A1–A2) oder Aufsteiger (A2–B1). Als Geschenkset auf Wunsch mit Audio-CDs.',
		'feature_price'      => 'Geschenkset ab 69,96 €',
		'feature_btn'        => 'Geschenksets ansehen',
		'feature_url'        => '/geschenksets/',
		'feature_products'   => '',
		'feature_cats'       => 'geschenksets,geschenkset-spanisch',
		'story_quote'        => 'Die Idee, Bücher nach der Ilya-Frank-Methode für Deutsch- und Englischsprachige zu veröffentlichen, entstand in Erinnerung daran, wie diese Methode mir persönlich geholfen hat.',
		'story_name'         => 'Anastasia Guskova',
		'story_role'         => 'Gründerin, EasyOriginal Verlag',
		'story_facts'        => "Von Ilya Frank persönlich betreut :: Der Entwickler der Methode begleitet easyOriginal seit Beginn: Er wählt Übersetzer mit aus, schult sie und prüft jedes Buch auf fehlende oder überflüssige Kommentare.\nAus eigener Erfahrung :: Mit Büchern nach der Frank-Methode hat die Gründerin selbst Deutsch, Englisch und Französisch lesen gelernt.\nUnabhängiger Verlag aus Österreich :: EasyOriginal Verlag e.U. – seit 2020, ausgezeichnet mit dem Siegel „Österreichischer Händler“.",
		'story_links'        => "Die ganze Geschichte :: /ueber-easyoriginal/\nWer ist Ilya Frank? :: /ilya-frank-wer-ist-das/",
		'faq'                => "Ich bin Anfänger – ist das schon etwas für mich? :: Ja. Die Frank-Lesemethode funktioniert auf jedem Niveau, sogar für Anfänger. Am leichtesten starten Sie mit den modernen Lektüren A1–A2: kurze Kapitel, jeder Satz übersetzt und erklärt.\nIn welchen Formaten gibt es die Bücher? :: Je nach Titel als Taschenbuch oder E-Book (PDF, ePub, mobi), meist mit Audio – online oder auf CD. Die verfügbaren Formate sehen Sie auf jeder Produktseite.\n„Frank-Lesemethode“ oder „mit Worterklärungen“ – was ist der Unterschied? :: Bei der Frank-Lesemethode ist jeder Satz übersetzt und erklärt, danach folgt der Absatz noch einmal ohne Hilfen. Ausgaben „mit Worterklärungen“ richten sich an Fortgeschrittene und erklären nur noch ausgewählte Wörter.\nWas kostet der Versand? :: Innerhalb der EU liefern wir ab 39 € Bestellwert kostenlos. Alle Details finden Sie unter <a href=\"/versand__lieferung/\">Versand &amp; Lieferung</a>.\nWer ist Ilya Frank? :: Ilya Frank hat die Lesemethode entwickelt und betreut easyOriginal seit Beginn persönlich. Mehr dazu: <a href=\"/ilya-frank-ueber-seine-lesemethode/\">Ilya Frank über seine Lesemethode</a>.",
		'contact_url'        => '/kontakt/',
		'newsletter_title'   => 'Neue Bücher zuerst erfahren',
		'newsletter_text'    => 'Neuerscheinungen, Leseproben und Set-Angebote – direkt in Ihr Postfach.',
		'newsletter_code'    => '',
		// Sprachen.
		'lang_en_url'        => '/englisch-lernen/',
		'lang_en_cats'       => 'englisch-deutsch,englisch-deutsch-bundle,modern-englisch-frank,modern-englisch-frank-a1-a2,englisch-lustige-kurzgeschichtenfrank-a1-a2,englisch-lustige-kurzgeschichtenfrank-a2-b1,modern-worterklaerungen-englisch-b1-b2',
		'lang_fr_url'        => '/franzoesisch-lernen/',
		'lang_fr_cats'       => 'franzoesisch-deutsch,franzoesisch-deutsch-bundle,modern-franzoesisch-frank,modern-franzoesisch-frank-a1-a2,franzoesisch-lustige-kurzgeschichten-frank-a1-a2,franzoesisch-lustige-kurzgeschichten-worterklaerungen-a2-b1',
		'lang_it_url'        => '/italienisch-lernen/',
		'lang_it_cats'       => 'italienisch-deutsch,italienisch-deutsch-bundle,modern-italienisch-frank-a1-a2,italienisch-lustige-kurzgeschichtenfrank-a1-a2,italienisch-lustige-kurzgeschichten-worterklaerungen-a2-b1',
		'lang_es_url'        => '/spanisch-lernen/',
		'lang_es_cats'       => 'spanisch-deutsch,spanisch-deutsch-bundle,modern-spanisch-frank,modern-spanisch-frank-a1-a2,spanisch-lustige-kurzgeschichtenfrank-a1-a2,spanisch-lustige-kurzgeschichten-worterklaerungen-a2-b1',
		'lang_ru_url'        => '/russisch-lernen/',
		'lang_ru_cats'       => 'russisch-deutsch,russisch-deutsch-bundle',
		'lang_de_url'        => '/deutsch-englisch/',
		'lang_de_cats'       => 'deutsch-englisch',
		// Shop.
		'price_from'         => 1,
		'shop_full_width'    => 1,
	);
	return $d;
}

/**
 * Zeilen „Titel :: Text“ → Liste.
 */
function eo_lines( $key ) {
	$out = array();
	foreach ( preg_split( '/\r\n|\r|\n/', (string) eo_opt( $key ) ) as $line ) {
		$line = trim( $line );
		if ( '' === $line ) {
			continue;
		}
		$parts = array_map( 'trim', explode( '::', $line, 2 ) );
		$out[] = array( $parts[0], isset( $parts[1] ) ? $parts[1] : '' );
	}
	return $out;
}

add_action(
	'customize_register',
	function ( WP_Customize_Manager $wp ) {
		$wp->add_panel( 'eo_panel', array( 'title' => 'easyOriginal', 'priority' => 25 ) );
		$sections = array(
			'eo_variant' => __( 'Design-Variante', 'easyoriginal' ),
			'eo_header'  => __( 'Kopf- und Fußzeile', 'easyoriginal' ),
			'eo_hero'    => __( 'Startseite: Einstieg (Hero)', 'easyoriginal' ),
			'eo_home'    => __( 'Startseite: Bausteine', 'easyoriginal' ),
			'eo_langs'   => __( 'Sprachen', 'easyoriginal' ),
			'eo_shop'    => __( 'Shop', 'easyoriginal' ),
		);
		foreach ( $sections as $id => $title ) {
			$wp->add_section( $id, array( 'title' => $title, 'panel' => 'eo_panel' ) );
		}
		$t = 'text';
		$a = 'textarea';
		$c = 'checkbox';
		$fields = array(
			array( 'skin', 'eo_variant', 'radio', __( 'Variante', 'easyoriginal' ), __( 'A · Buchhandlung: warmes Papier, 3D-Bücher, Holzregal. B · Journal: Smaragd, Bordeaux und Gold, Literaturmagazin. C · Bunt: kräftige Farben, Sticker, Laufband.', 'easyoriginal' ), array( 'buch' => 'A · Buchhandlung', 'journal' => 'B · Journal', 'bunt' => 'C · Bunt' ) ),
			array( 'skin_switch', 'eo_variant', $c, __( 'Varianten-Umschalter für eingeloggte Administratoren anzeigen', 'easyoriginal' ), __( 'Besucher sehen ihn nie.', 'easyoriginal' ) ),
			array( 'topbar_text', 'eo_header', $t, __( 'Text in der oberen Leiste', 'easyoriginal' ) ),
			array( 'footer_text', 'eo_header', $a, __( 'Kurztext in der Fußzeile', 'easyoriginal' ) ),
			array( 'footer_legal', 'eo_header', $t, __( 'Preis-Hinweis in der Fußzeile', 'easyoriginal' ) ),
			array( 'copyright', 'eo_header', $t, __( 'Copyright-Zeile', 'easyoriginal' ) ),
			array( 'facebook', 'eo_header', 'url', 'Facebook' ),
			array( 'instagram', 'eo_header', 'url', 'Instagram' ),
			array( 'show_seal', 'eo_header', $c, __( 'Siegel „Österreichischer Händler“ zeigen', 'easyoriginal' ) ),
			array( 'hero_issue', 'eo_hero', $t, __( 'Ausgabe-Zeile (nur Variante Journal), zwei Teile mit „|“', 'easyoriginal' ) ),
			array( 'hero_eyebrow', 'eo_hero', $t, __( 'Dachzeile', 'easyoriginal' ) ),
			array( 'hero_title', 'eo_hero', $t, __( 'Überschrift', 'easyoriginal' ) ),
			array( 'hero_title_em', 'eo_hero', $t, __( 'Überschrift – hervorgehobener Teil', 'easyoriginal' ) ),
			array( 'hero_lead', 'eo_hero', $a, __( 'Einleitung', 'easyoriginal' ) ),
			array( 'hero_cta1', 'eo_hero', $t, __( 'Button 1', 'easyoriginal' ) ),
			array( 'hero_cta1_url', 'eo_hero', $t, __( 'Button 1 – Link', 'easyoriginal' ) ),
			array( 'hero_cta2', 'eo_hero', $t, __( 'Button 2', 'easyoriginal' ) ),
			array( 'hero_cta2_url', 'eo_hero', $t, __( 'Button 2 – Link', 'easyoriginal' ) ),
			array( 'hero_ticks', 'eo_hero', $a, __( 'Häkchen-Punkte (eine Zeile je Punkt)', 'easyoriginal' ) ),
			array( 'hero_products', 'eo_hero', $t, __( 'Bücher im Bild (Produkt-IDs, kommagetrennt, max. 5)', 'easyoriginal' ), __( 'Leer = Bestseller mit Buchcover.', 'easyoriginal' ) ),
			array( 'sample_product', 'eo_hero', $t, __( 'Leseprobe aus Produkt (ID)', 'easyoriginal' ), __( 'Das Produkt braucht eine Leseprobe im Feld „easyOriginal“. Leer = Produkt mit Artikelnummer DF1 (Arsène Lupin) bzw. eingebaute Probe.', 'easyoriginal' ) ),
			array( 'home_hidden', 'eo_home', $t, __( 'Ausgeblendete Bausteine', 'easyoriginal' ), __( 'Kommagetrennt aus: stats, sprachen, laufband, methode, regal, auswahl, niveau, aktion, geschichte, stimme, faq, newsletter', 'easyoriginal' ) ),
			array( 'stats', 'eo_home', $a, __( 'Kennzahlen (4 Zeilen „Titel :: Unterzeile“)', 'easyoriginal' ) ),
			array( 'method_url', 'eo_home', $t, __( 'Methode – Link „Ausführlich erklärt“', 'easyoriginal' ) ),
			array( 'sets_cats', 'eo_home', $t, __( 'Tab „Bücher-Sets“: Kategorie-Slugs', 'easyoriginal' ) ),
			array( 'levels_url', 'eo_home', $t, __( 'Niveau-Karten: Ziel-Seite (Filter wird angehängt)', 'easyoriginal' ) ),
			array( 'feature_eyebrow', 'eo_home', $t, __( 'Aktion – Dachzeile', 'easyoriginal' ) ),
			array( 'feature_title', 'eo_home', $t, __( 'Aktion – Überschrift', 'easyoriginal' ) ),
			array( 'feature_text', 'eo_home', $a, __( 'Aktion – Text', 'easyoriginal' ) ),
			array( 'feature_price', 'eo_home', $t, __( 'Aktion – Preiszeile', 'easyoriginal' ) ),
			array( 'feature_btn', 'eo_home', $t, __( 'Aktion – Button', 'easyoriginal' ) ),
			array( 'feature_url', 'eo_home', $t, __( 'Aktion – Link', 'easyoriginal' ) ),
			array( 'feature_products', 'eo_home', $t, __( 'Aktion – Bilder aus Produkten (IDs, 3 Stück)', 'easyoriginal' ) ),
			array( 'feature_cats', 'eo_home', $t, __( 'Aktion – sonst Produkte aus diesen Kategorie-Slugs', 'easyoriginal' ) ),
			array( 'story_quote', 'eo_home', $a, __( 'Geschichte – Zitat', 'easyoriginal' ) ),
			array( 'story_name', 'eo_home', $t, __( 'Geschichte – Name', 'easyoriginal' ) ),
			array( 'story_role', 'eo_home', $t, __( 'Geschichte – Rolle', 'easyoriginal' ) ),
			array( 'story_facts', 'eo_home', $a, __( 'Geschichte – Punkte („Titel :: Text“ je Zeile)', 'easyoriginal' ) ),
			array( 'story_links', 'eo_home', $a, __( 'Geschichte – Links („Text :: URL“ je Zeile)', 'easyoriginal' ) ),
			array( 'faq', 'eo_home', $a, __( 'Fragen & Antworten („Frage :: Antwort“ je Zeile, Links erlaubt)', 'easyoriginal' ) ),
			array( 'contact_url', 'eo_home', $t, __( 'Kontakt-Link', 'easyoriginal' ) ),
			array( 'newsletter_title', 'eo_home', $t, __( 'Newsletter – Überschrift', 'easyoriginal' ) ),
			array( 'newsletter_text', 'eo_home', $t, __( 'Newsletter – Text', 'easyoriginal' ) ),
			array( 'newsletter_code', 'eo_home', $a, __( 'Newsletter – Shortcode des Anmeldeformulars', 'easyoriginal' ), __( 'Z. B. das Divi-Modul „E-Mail-Optin“ aus der Divi-Bibliothek: [et_pb_section global_module="123"][/et_pb_section]. Leer = Baustein wird ausgeblendet.', 'easyoriginal' ) ),
			array( 'price_from', 'eo_shop', $c, __( 'Preisspannen als „ab 6,99 €“ anzeigen', 'easyoriginal' ) ),
			array( 'shop_full_width', 'eo_shop', $c, __( 'Shop-Seiten ohne Seitenleiste', 'easyoriginal' ) ),
		);
		foreach ( array_keys( eo_langs_static_names() ) as $code ) {
			$n        = eo_langs_static_names()[ $code ];
			$fields[] = array( 'lang_' . $code . '_url', 'eo_langs', $t, sprintf( __( '%s – Link der Sprachseite', 'easyoriginal' ), $n ) );
			$fields[] = array( 'lang_' . $code . '_cats', 'eo_langs', $t, sprintf( __( '%s – Kategorie-Slugs (für Cover und Katalog)', 'easyoriginal' ), $n ) );
		}
		$d = eo_defaults();
		foreach ( $fields as $f ) {
			list( $key, $section, $type, $label ) = $f;
			$desc     = isset( $f[4] ) ? $f[4] : '';
			$sanitize = 'sanitize_text_field';
			if ( $c === $type ) {
				$sanitize = 'absint';
			} elseif ( 'url' === $type ) {
				$sanitize = 'esc_url_raw';
			} elseif ( $a === $type ) {
				$sanitize = 'wp_kses_post';
			} elseif ( 'radio' === $type ) {
				$sanitize = 'sanitize_key';
			}
			$wp->add_setting( 'eo_' . $key, array( 'default' => $d[ $key ], 'sanitize_callback' => $sanitize, 'transport' => 'refresh' ) );
			$ctrl = array( 'label' => $label, 'section' => $section, 'type' => $type, 'description' => $desc );
			if ( 'radio' === $type ) {
				$ctrl['choices'] = $f[5];
			}
			$wp->add_control( 'eo_' . $key, $ctrl );
		}
	}
);

function eo_langs_static_names() {
	return array( 'en' => 'Englisch', 'fr' => 'Französisch', 'it' => 'Italienisch', 'es' => 'Spanisch', 'ru' => 'Russisch', 'de' => 'Deutsch' );
}
