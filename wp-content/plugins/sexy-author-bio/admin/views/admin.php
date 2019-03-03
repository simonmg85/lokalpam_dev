<?php
/**
 * Plugin options view.
 *
 * @package   WP_Author_Bio
 * @author    Andy Forsberg <andy@penguinwp.com>
 * @license   GPL-2.0+
 * @copyright 2017 Penguin Initiatives
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
?>

<div class="wrap">

	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

	<div style="float:left;width:80%;">

	<form method="post" action="options.php">
		<?php
			settings_fields( 'sexyauthorbio_settings' );
			do_settings_sections( 'sexyauthorbio_settings' );
			submit_button();
		?>
	</form>

	</div>

	<?php include 'metabox.php'; ?>

</div>

