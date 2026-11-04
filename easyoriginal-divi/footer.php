<?php
/**
 * Fußbereich (ersetzt die Divi-Fußzeile).
 *
 * @package easyoriginal
 */

defined( 'ABSPATH' ) || exit;
?>
<footer class="footer" id="main-footer">
	<div class="container">
		<div class="footer__grid">
			<div class="footer__brand">
				<img src="<?php echo esc_url( eo_logo_url() ); ?>" width="500" height="103" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" loading="lazy">
				<p><?php echo esc_html( eo_opt( 'footer_text' ) ); ?></p>
				<div class="footer__social">
					<?php if ( eo_opt( 'facebook' ) ) : ?>
						<a href="<?php echo esc_url( eo_opt( 'facebook' ) ); ?>" aria-label="<?php esc_attr_e( 'easyOriginal auf Facebook', 'easyoriginal' ); ?>"><?php echo eo_icon( 'facebook' ); // phpcs:ignore ?></a>
					<?php endif; ?>
					<?php if ( eo_opt( 'instagram' ) ) : ?>
						<a href="<?php echo esc_url( eo_opt( 'instagram' ) ); ?>" aria-label="<?php esc_attr_e( 'easyOriginal auf Instagram', 'easyoriginal' ); ?>"><?php echo eo_icon( 'instagram' ); // phpcs:ignore ?></a>
					<?php endif; ?>
				</div>
			</div>
			<?php foreach ( eo_footer_columns() as $eo_col ) : ?>
				<div>
					<h3><?php echo esc_html( $eo_col[0] ); ?></h3>
					<ul>
						<?php foreach ( $eo_col[1] as $eo_item ) : ?>
							<li><a<?php echo eo_link_attrs( $eo_item ); // phpcs:ignore ?>><?php echo esc_html( $eo_item['title'] ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="footer__bottom">
			<div class="seal">
				<?php if ( eo_opt( 'show_seal' ) ) : ?>
					<img src="<?php echo esc_url( EO_THEME_URI . '/assets/img/siegel-oesterreichischer-haendler.png' ); ?>" width="52" height="52" alt="<?php esc_attr_e( 'Siegel: Österreichischer Händler', 'easyoriginal' ); ?>" loading="lazy">
				<?php endif; ?>
				<span><?php echo esc_html( eo_opt( 'copyright' ) ); ?></span>
			</div>
			<span><?php echo esc_html( eo_opt( 'footer_legal' ) ); ?></span>
		</div>
	</div>
</footer>

<div class="toast" id="toast" role="status" aria-live="polite"></div>

<?php if ( eo_can_preview_skins() ) : ?>
	<div class="skin-switch" role="group" aria-label="<?php esc_attr_e( 'Design-Variante (nur für Administratoren sichtbar)', 'easyoriginal' ); ?>">
		<span><?php esc_html_e( 'Variante', 'easyoriginal' ); ?></span>
		<button type="button" data-skin-set="buch" aria-pressed="<?php echo 'buch' === eo_skin() ? 'true' : 'false'; ?>">A<span class="long"> · Buchhandlung</span></button>
		<button type="button" data-skin-set="journal" aria-pressed="<?php echo 'journal' === eo_skin() ? 'true' : 'false'; ?>">B<span class="long"> · Journal</span></button>
		<button type="button" data-skin-set="bunt" aria-pressed="<?php echo 'bunt' === eo_skin() ? 'true' : 'false'; ?>">C<span class="long"> · Bunt</span></button>
	</div>
<?php endif; ?>

</div><!-- #et-main-area -->
</div><!-- #page-container -->
<?php wp_footer(); ?>
</body>
</html>
