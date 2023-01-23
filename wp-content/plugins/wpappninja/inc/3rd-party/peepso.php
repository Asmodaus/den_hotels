<?php
defined( 'ABSPATH' ) or die( 'Cheatin\' uh?' );


add_action('init', 'wpmobile_remove_shortcode_filter_peepso', PHP_INT_MAX);
function wpmobile_remove_shortcode_filter_peepso() {

    if (class_exists('PeepSo') && is_wpappninja()) {
        remove_action( 'pre_get_posts', 'wpmobileapp_pre_get_posts' );
        
        add_action('wp_head', 'wpmobile_x_peepso_css');
    }
}

function wpmobile_x_peepso_css() {

 if ( theme_is_changed() ) {
	echo '<style>
   button.ps-lightbox-arrow-next, button.ps-lightbox-arrow-prev {
    width: auto!important;
   }
   </style>';
}

	echo '<style>
   html, body {height: auto!important;}
   </style>';

   echo "<script>
	jQuery(function() {
		jQuery('a[href*=\"#photo=\"], .ps-notif a, .ps-chat__message-delete').each(function(){
			jQuery(this).attr('href', jQuery(this).attr('href') + '&fake=.png');
		});
	});
	</script>";
}
