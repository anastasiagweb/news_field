<?php
/**
 * Template Name: easyOriginal Startseite
 *
 * Alle Bausteine der neuen Startseite. Inhalte aus dem Editor/Divi Builder dieser Seite
 * werden darunter ausgegeben (z. B. für zusätzliche Abschnitte).
 *
 * @package easyoriginal
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<div id="main-content" class="eo-main">
	<?php echo eo_render_home(); // phpcs:ignore ?>
	<?php
	while ( have_posts() ) :
		the_post();
		if ( '' !== trim( (string) get_post_field( 'post_content', get_the_ID() ) ) ) :
			?>
			<div class="eo-page-content"><?php the_content(); ?></div>
			<?php
		endif;
	endwhile;
	?>
</div>
<?php
get_footer();
