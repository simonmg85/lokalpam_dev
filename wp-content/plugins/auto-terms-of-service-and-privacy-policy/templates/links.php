<?php
if (!defined( 'ABSPATH' )) {
	exit;
}
$args = array (
	'post_type' => WPAUTOTERMS_CPT,
	'post_status' => 'publish',
	'orderby' => 'post_modified',
);

$posts = get_posts( $args );
if(empty($posts)) {
	return;
}
?>
<div class="wpautoterms-footer"><p>
		<?php
		$links = array ();
		foreach ($posts as $post) {
			$links[] = '<a href="' . esc_url( get_post_permalink( $post->ID ) ) . '">' . esc_html( $post->post_title ) . '</a>';
		}
		echo join( '<span class="separator"> ' . get_option( WPAUTOTERMS_OPTION_PREFIX . 'links_separator' ) . ' </span>', $links );
		?></p>
</div>