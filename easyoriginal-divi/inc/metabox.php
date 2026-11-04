<?php
/**
 * Zusatzfelder am Produkt („easyOriginal“-Box im Produkt-Editor).
 *
 * @package easyoriginal
 */

defined( 'ABSPATH' ) || exit;

function eo_product_fields() {
	return array(
		'_eo_untertitel'    => array( __( 'Deutscher Titel (Untertitel)', 'easyoriginal' ), 'text', __( 'Leer = wird aus dem Produktnamen gelesen („Original / Deutsch“ oder „Original — Deutsch“).', 'easyoriginal' ) ),
		'_eo_autor'         => array( __( 'Autor', 'easyoriginal' ), 'text', '' ),
		'_eo_leseprobe'     => array( __( 'Leseprobe im Frank-Format', 'easyoriginal' ), 'textarea', __( 'Originaltext mit Übersetzungen in runden Klammern direkt dahinter, z. B.: L’étrange voyage (die seltsame Reise)! … – „wort — Bedeutung“ wird automatisch kursiv. Absätze durch Leerzeilen. Die Version „ohne Hilfen“ entsteht automatisch.', 'easyoriginal' ) ),
		'_eo_audio'         => array( __( 'Audio zur Leseprobe (MP3-URL)', 'easyoriginal' ), 'url', '' ),
		'_eo_leseprobe_pdf' => array( __( 'Längere Leseprobe (PDF-URL)', 'easyoriginal' ), 'url', '' ),
		'_eo_cover_farbe'   => array( __( 'Cover-Farbe (optional, z. B. #9662a5)', 'easyoriginal' ), 'text', __( 'Leer = wird automatisch aus dem Produktbild ermittelt.', 'easyoriginal' ) ),
	);
}

add_action(
	'add_meta_boxes',
	function () {
		add_meta_box( 'eo_product_box', 'easyOriginal', 'eo_product_box_html', 'product', 'normal', 'default' );
	}
);

function eo_product_box_html( $post ) {
	wp_nonce_field( 'eo_product_box', 'eo_product_box_nonce' );
	echo '<table class="form-table" role="presentation"><tbody>';
	foreach ( eo_product_fields() as $key => $f ) {
		$val = get_post_meta( $post->ID, $key, true );
		echo '<tr><th scope="row"><label for="' . esc_attr( $key ) . '">' . esc_html( $f[0] ) . '</label></th><td>';
		if ( 'textarea' === $f[1] ) {
			echo '<textarea class="large-text" rows="7" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '">' . esc_textarea( $val ) . '</textarea>';
		} else {
			echo '<input class="regular-text" type="' . ( 'url' === $f[1] ? 'url' : 'text' ) . '" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '">';
		}
		if ( $f[2] ) {
			echo '<p class="description">' . esc_html( $f[2] ) . '</p>';
		}
		echo '</td></tr>';
	}
	echo '</tbody></table>';
}

add_action(
	'save_post_product',
	function ( $post_id ) {
		if ( ! isset( $_POST['eo_product_box_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['eo_product_box_nonce'] ) ), 'eo_product_box' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		foreach ( eo_product_fields() as $key => $f ) {
			if ( ! isset( $_POST[ $key ] ) ) {
				continue;
			}
			$raw = wp_unslash( $_POST[ $key ] ); // phpcs:ignore
			if ( 'textarea' === $f[1] ) {
				$val = sanitize_textarea_field( $raw );
			} elseif ( 'url' === $f[1] ) {
				$val = esc_url_raw( $raw );
			} else {
				$val = sanitize_text_field( $raw );
			}
			if ( '' === $val ) {
				delete_post_meta( $post_id, $key );
			} else {
				update_post_meta( $post_id, $key, $val );
			}
		}
		delete_post_meta( $post_id, '_eo_cover_color' );
	}
);
