<?php
/**
 * The template for displaying the header
 *
 * This is the template that displays all of the <head> section, opens the <body> tag and adds the site's header.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<?php $viewport_content = apply_filters( 'hello_elementor_viewport_content', 'width=device-width, initial-scale=1' ); ?>
	<meta name="viewport" content="<?php echo esc_attr( $viewport_content ); ?>">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
	<link rel="stylesheet" href="<?php echo get_theme_file_uri( 'css/normalize.css' ); ?>">
 
	<link rel="stylesheet" href="<?php echo get_theme_file_uri( 'css/swiper-bundle.min.css' ); ?>">
	<link rel="stylesheet" href="<?php echo get_theme_file_uri( 'libs/bootstrap5/bootstrap.min.css' ); ?>">
	<link rel="stylesheet" href="<?php echo get_theme_file_uri( 'css/lightbox.min.css' ); ?>">
	<link rel="stylesheet" href="<?php echo get_theme_file_uri( 'css/style.css' ); ?>">

	<link rel="stylesheet" href="<?php echo get_theme_file_uri( 'js/swiper-bundle.min.js' ); ?>">
	<link rel="stylesheet" href="<?php echo get_theme_file_uri( 'libs/bootstrap5/bootstrap.min.js' ); ?>">
	<link rel="stylesheet" href="<?php echo get_theme_file_uri( 'js/lightbox.min.js' ); ?>">
	<link rel="stylesheet" href="<?php echo get_theme_file_uri( 'js/script.js' ); ?>">

</head>
<body <?php body_class(); ?>>

<?php hello_elementor_body_open(); ?>

<a class="skip-link screen-reader-text" href="#content">
	<?php esc_html_e( 'Skip to content', 'hello-elementor' ); ?></a>

<?php
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) {
	if ( did_action( 'elementor/loaded' ) && hello_header_footer_experiment_active() ) {
		get_template_part( 'template-parts/dynamic-header' );
	} else {
		get_template_part( 'template-parts/header' );
	}
}
