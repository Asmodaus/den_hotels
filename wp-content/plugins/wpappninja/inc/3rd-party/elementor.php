<?php
defined( 'ABSPATH' ) or die( 'Cheatin\' uh?' );

/**
 * Fix elementor invisible element
 *
 */
add_action('wp_head', 'wpmobile_fix_elementor', 999);
function wpmobile_fix_elementor() {

    if (!is_wpappninja()) {
        return;
    } ?>
	<?php if (theme_is_changed()) {?>
    <style>form.cart input.qty {
    width: 50px!important;
}.et_animated {
opacity: 1!important;
}
i.icon.f7-icons {
    font-family: 'Framework7 Icons'!important;
}
html body #root ul.activity-nav .selected a, html body #root .bp-navs .current a {
    background: none!important;
}.navbar p, .navbar h2 {
margin: 0!important;
}
    .navbar-inner p {
        margin: 0!important;
    }
    .elementor-animated-content {
        visibility: visible;
    }
    .elementor-invisible {
        visibility: visible!important;
    }
    body {
        overflow: auto;
    }
    </style>

    <?php
}
}
