<?php
defined( 'ABSPATH' ) or die( 'Cheatin\' uh?' );

/**
 * Fix elementor invisible element
 *
 */
add_action('wp_head', 'wpmobile_fix_contact7', 999);
function wpmobile_fix_contact7() {

    if (!is_wpappninja()) {
        return;
    } ?>

	<?php if (theme_is_changed()) {?>
    <style>
    form.wpcf7-form input, form.wpcf7-form textarea {
        padding: 10px!important;
        border: 1px solid!important;
        width: 100%!important;
    }
    </style>
        <?php } ?>

    <?php if (get_wpappninja_option('agressive_anti_cache') == '1') { ?>
    <script>
    jQuery( document ).ajaxComplete(function() {
        jQuery('a').each(function(){

            if (typeof jQuery(this).attr("href") !== typeof undefined && jQuery(this).attr("href") !== false) {
                if (jQuery(this).attr("href").indexOf("wpappninja_v") < 0 && jQuery(this).attr("href").match("^http")) {
                    if (jQuery(this).attr("href").indexOf("?") < 0) {
                        jQuery(this).attr("href", jQuery(this).attr("href") + "?wpappninja_v=" + Math.random().toString(36).substr(2, 9));
                    } else {
                        jQuery(this).attr("href", jQuery(this).attr("href") + "&wpappninja_v=" + Math.random().toString(36).substr(2, 9));
                    }
                }
            }
        });
    });
    </script>
    <?php
    }
}
