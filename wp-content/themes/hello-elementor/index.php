<?php
/**
 * The site's entry point.
 *
 * Loads the relevant template part,
 * the loop is executed (when needed) by the relevant template part.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();

$is_elementor_theme_exist = function_exists( 'elementor_theme_do_location' );


	

if ( is_singular() ) {

	$Post = get_post(get_the_ID());

	if ($Post->post_type=='hotels') get_template_part( 'template-parts/single-hotels' );
	elseif ($Post->post_type=='city') get_template_part( 'template-parts/hotels_list' );
	elseif ($Post->ID==2926) get_template_part( 'template-parts/hotels_list' );
	elseif ( ! $is_elementor_theme_exist || ! elementor_theme_do_location( 'single' ) ) {
		get_template_part( 'template-parts/single' );
	}
} elseif ( is_archive() || is_home() ) {

	global $post;
	$hotels=false;
	$categories = get_the_category();
	foreach($categories as $category) {
		if  ($category->cat_ID==2926) $hotels=true;
	}
	if (1==2 && $hotels) get_template_part( 'template-parts/hotels_list' );
	elseif ( ! $is_elementor_theme_exist || ! elementor_theme_do_location( 'archive' ) ) {
		get_template_part( 'template-parts/archive' );
	}
} elseif ( is_search() ) {
	if ( ! $is_elementor_theme_exist || ! elementor_theme_do_location( 'archive' ) ) {
		get_template_part( 'template-parts/search' );
	}
} else {
	if ( ! $is_elementor_theme_exist || ! elementor_theme_do_location( 'single' ) ) {
		get_template_part( 'template-parts/404' );
	}
}

get_footer();
