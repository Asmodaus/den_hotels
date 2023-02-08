<?php
/**
 * The template for displaying the footer.
 *
 * Contains the body & html closing tags.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) {
	if ( did_action( 'elementor/loaded' ) && hello_header_footer_experiment_active() ) {
		get_template_part( 'template-parts/dynamic-footer' );
	} else {
		get_template_part( 'template-parts/footer' );
	}
}
?>

<?php wp_footer(); ?>

<link rel="stylesheet" href="<?php echo get_theme_file_uri( 'js/swiper-bundle.min.js' ); ?>">
	<link rel="stylesheet" href="<?php echo get_theme_file_uri( 'libs/bootstrap5/bootstrap.min.js' ); ?>">
	<link rel="stylesheet" href="<?php echo get_theme_file_uri( 'js/lightbox.min.js' ); ?>">
	<link rel="stylesheet" href="<?php echo get_theme_file_uri( 'js/script.js' ); ?>">
</body>
</html>
