<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
Function: uacf7_checked
Return: checked
*/
if( !function_exists('uacf7_checked') ){
    function uacf7_checked( $name ){
    
        //Get settings option
        $uacf7_options = get_option( apply_filters( 'uacf7_option_name', 'uacf7_option_name' ) );

        if( isset( $uacf7_options[$name] ) && $uacf7_options[$name] === 'on' ) {
            return 'checked';
        }
    }
}

/*
* Hook: uacf7_multistep_pro_features
* Multistep pro features demo
*/
add_action( 'uacf7_multistep_pro_features', 'uacf7_multistep_pro_features_demo', 5, 2 );
function uacf7_multistep_pro_features_demo( $all_steps, $form_id ){
    
    if( empty(array_filter($all_steps)) ) return;
    ?>
    <div class="multistep_fields_row" style="display: flex; flex-direction: column;">
    <?php
    $step_count = 1;
    foreach( $all_steps as $step ) {
        ?>
        <h3><strong>Step <?php echo $step_count; ?> <a style="color:red" target="_blank" href="https://cf7addons.com/preview/pro">(Pro)</a></strong></h3>
        <?php
        if( $step_count == 1 ){
            ?>
            <div>
               <p><label for="<?php echo 'next_btn_'.$step->name; ?>"><?php echo __('Change next button text for this Step', 'ultimate-addons-cf7' ) ?></label></p>
               <input id="<?php echo 'next_btn_'.$step->name; ?>" type="text" name="" value="" placeholder="<?php echo esc_html__('Next','ultimate-addons-cf7-pro') ?>">
            </div>
            <?php
        } else {

            if( count($all_steps) == $step_count ) {
                ?>
                <div>
                   <p><label for="<?php echo 'prev_btn_'.$step->name; ?>"><?php echo __('Change previous button text for this Step', 'ultimate-addons-cf7' ) ?></label></p>
                   <input id="<?php echo 'prev_btn_'.$step->name; ?>" type="text" name="" value="" placeholder="<?php echo esc_html__('Previous','ultimate-addons-cf7-pro') ?>">
                </div>
                <?php

            } else {
                ?>
                <div class="multistep_fields_row-">
                    <div class="multistep_field_column">
                       <p><label for="<?php echo 'prev_btn_'.$step->name; ?>"><?php echo __('Change previous button text for this Step', 'ultimate-addons-cf7' ) ?></label></p>
                       <input id="<?php echo 'prev_btn_'.$step->name; ?>" type="text" name="" value="" placeholder="<?php echo esc_html__('Previous','ultimate-addons-cf7-pro') ?>">
                    </div>

                    <div class="multistep_field_column">
                       <p><label for="<?php echo 'next_btn_'.$step->name; ?>"><?php echo __('Change next button text for this Step', 'ultimate-addons-cf7' ) ?></label></p>
                       <input id="<?php echo 'next_btn_'.$step->name; ?>" type="text" name="" value="" placeholder="<?php echo esc_html__('Next','ultimate-addons-cf7-pro') ?>">
                    </div>
                </div>
                <?php
            }

        }
        ?>
        <div class="uacf7_multistep_progressbar_image_row">
           <p><label for="<?php echo esc_attr('uacf7_progressbar_image_'.$step->name); ?>"><?php echo __('Add progressbar image for this step', 'ultimate-addons-cf7' ) ?></label></p>
           <input class="uacf7_multistep_progressbar_image" id="<?php echo esc_attr('uacf7_progressbar_image_'.$step->name); ?>" type="url" name="" value=""> <a class="button-primary" href="#"><?php echo __('Add or Upload Image', 'ultimate-addons-cf7' ) ?></a>
           
           <div class="multistep_fields_row step-title-description col-50">
                <div class="multistep_field_column">
                   <p><label for="<?php echo 'step_desc_'.$step->name; ?>"><?php echo __('Step description', 'ultimate-addons-cf7' ) ?></label></p>
                   <textarea id="<?php echo 'step_desc_'.$step->name; ?>" type="text" name="" cols="40" rows="3" placeholder="<?php echo esc_html__('Step description','ultimate-addons-cf7-pro') ?>"></textarea>
                </div>
    
                <div class="multistep_field_column">
                   <p><label for="<?php echo 'desc_title_'.$step->name; ?>"><?php echo __('Description title', 'ultimate-addons-cf7' ) ?></label></p>
                   <input id="<?php echo 'desc_title_'.$step->name; ?>" type="text" name="" value="" placeholder="<?php echo esc_html__('Description title','ultimate-addons-cf7-pro') ?>">
                </div>
            </div>
        </div>
        <?php
        $step_count++;
    }
    ?>
    </div>
    <?php
}

/*
* Progressbar style
*/
add_action( 'uacf7_multistep_before_form', 'uacf7_multistep_progressbar_style', 10 );
function uacf7_multistep_progressbar_style( $form_id ) {
    $uacf7_multistep_circle_width = get_post_meta( $form_id, 'uacf7_multistep_circle_width', true ); 
    $uacf7_multistep_circle_height = get_post_meta( $form_id, 'uacf7_multistep_circle_height', true ); 
    $uacf7_multistep_circle_bg_color = get_post_meta( $form_id, 'uacf7_multistep_circle_bg_color', true ); 
    $uacf7_multistep_circle_font_color = get_post_meta( $form_id, 'uacf7_multistep_circle_font_color', true ); 
    $uacf7_multistep_circle_border_radious = get_post_meta( $form_id, 'uacf7_multistep_circle_border_radious', true ); 
    $uacf7_multistep_font_size = get_post_meta( $form_id, 'uacf7_multistep_font_size', true ); 
    $uacf7_multistep_circle_active_color = get_post_meta( $form_id, 'uacf7_multistep_circle_active_color', true );
    $uacf7_multistep_progress_line_color = get_post_meta( $form_id, 'uacf7_multistep_progress_line_color', true );
    ?>
    <style>
    .steps-form .steps-row .steps-step .btn-circle {
        <?php if(!empty($uacf7_multistep_circle_width)) echo 'width: '.esc_attr($uacf7_multistep_circle_width).'px;'; ?>
        <?php if(!empty($uacf7_multistep_circle_height)) echo 'height: '.esc_attr($uacf7_multistep_circle_height).'px;'; ?>
        <?php if($uacf7_multistep_circle_border_radious != '' ) echo 'border-radius: '.$uacf7_multistep_circle_border_radious.'px;'; ?>
        <?php if(!empty($uacf7_multistep_circle_height)) echo 'line-height: '.esc_attr($uacf7_multistep_circle_height).'px;'; ?>
        <?php if(!empty($uacf7_multistep_circle_bg_color)) echo 'background-color: '.esc_attr($uacf7_multistep_circle_bg_color).' !important;'; ?>
        <?php if(!empty($uacf7_multistep_circle_font_color)) echo 'color: '.esc_attr($uacf7_multistep_circle_font_color).' !important;'; ?>
        <?php if(!empty($uacf7_multistep_font_size)) echo 'font-size: '.esc_attr($uacf7_multistep_font_size).'px;'; ?>
    }
	.steps-form .steps-row .steps-step .btn-circle img {
		<?php if( $uacf7_multistep_circle_border_radious != 0 ) echo 'border-radius: '.$uacf7_multistep_circle_border_radious.'px !important;'; ?>
	}
    .steps-form .steps-row .steps-step .btn-circle.uacf7-btn-active,
    .steps-form .steps-row .steps-step .btn-circle:hover,
    .steps-form .steps-row .steps-step .btn-circle:focus,
    .steps-form .steps-row .steps-step .btn-circle:active{
        <?php if(!empty($uacf7_multistep_circle_active_color)) echo 'background-color: '.esc_attr($uacf7_multistep_circle_active_color).' !important;'; ?>
        <?php if(!empty($uacf7_multistep_circle_font_color)) echo 'color: '.esc_attr($uacf7_multistep_circle_font_color).';'; ?>
    }
    .steps-form .steps-row .steps-step p {
        <?php if(!empty($uacf7_multistep_font_size)) echo 'font-size: '.esc_attr($uacf7_multistep_font_size).'px;'; ?>
    }
    .steps-form .steps-row::before {
        <?php if(!empty($uacf7_multistep_circle_height)) echo 'top: '.esc_attr($uacf7_multistep_circle_height / 2).'px;'; ?>
    }
    <?php if(!empty($uacf7_multistep_progress_line_color)): ?>
    .steps-form .steps-row::before {
    	background-color: <?php echo esc_attr($uacf7_multistep_progress_line_color); ?>;
    }
    <?php endif; ?>
    </style>
    <?php
}


//Dispal repeater pro feature

if( !function_exists('uacf7_tg_pane_repeater') ) {
    add_action( 'admin_init', 'uacf7_repeater_pro_tag_generator' );
}

function uacf7_repeater_pro_tag_generator() {
    if (! function_exists( 'wpcf7_add_tag_generator'))
        return;

    wpcf7_add_tag_generator('repeater',
        __('Ultimate Repeater (pro)', 'ultimate-addons-cf7'),
        'uacf7-tg-pane-repeater',
        'uacf7_tg_pane_repeater_pro'
    );

}

function uacf7_tg_pane_repeater_pro( $contact_form, $args = '' ) {
    $args = wp_parse_args( $args, array() );
    $uacf7_field_type = 'repeater';
    ?>
    <div class="control-box">
        <fieldset>
            <legend>
                <?php echo esc_html__( "This is a Pro feature of Ultimate Addons for contact form 7. You can add repeatable field and repeatable fields group with this addon.", "ultimate-addons-cf7" ); ?> <a href="https://cf7addons.com/preview/repeater-field/" target="_blank">Check Preview</a>
            </legend>
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-name' ); ?>"><?php echo esc_html( __( 'Name', 'ultimate-addons-cf7' ) ); ?></label></th>
                        <td><input type="text" name="name" class="tg-name oneline" id="<?php echo esc_attr( $args['content'] . '-name' ); ?>" /></td>
                    </tr>
                    <tr>
                    	<th scope="row"><label for="tag-generator-panel-text-values"><?php echo __('Add Button Text', 'ultimate-addons-cf7' ) ?></label></th>
                    	<td><input type="text" name="" class="tg-name oneline uarepeater-add" value="Add more" id="tag-generator-panel-uarepeater-nae"></td>
                	</tr>
                	<tr>
                    	<th scope="row"><label for="tag-generator-panel-text-values-remove"><?php echo __('Remove Button Text', 'ultimate-addons-cf7' ) ?></label></th>
                    	<td><input type="text" name="" class="tg-name oneline uarepeater-remove" value="Remove" id="tag-generator-panel-uarepeater-n"></td>
                	</tr>
                    
                </tbody>
            </table>
        </fieldset>
    </div>
    <?php
}

//Add wrapper to contact form 7
add_filter( 'wpcf7_contact_form_properties', 'uacf7_add_wrapper_to_cf7_form', 10, 2 );
function uacf7_add_wrapper_to_cf7_form($properties, $cfform) {
    if (!is_admin() || (defined('DOING_AJAX') && DOING_AJAX)) {
    
        $form = $properties['form'];
        ob_start();
        echo '<div class="uacf7-form-'.$cfform->id().'">'.$form.'</div>';
        $properties['form'] = ob_get_clean();
        
    }
	return $properties;
}

/**
 * Black Friday Deals 2022
 */


if(!function_exists('uacf7_black_friday_20222_admin_notice')){
	function uacf7_black_friday_20222_admin_notice(){
		$deal_link =sanitize_url('https://themefic.com/go/uacf7-bf-deal');
		$get_current_screen = get_current_screen();  
		if(!isset($_COOKIE['uacf7_dismiss_admin_notice']) && $get_current_screen->base == 'dashboard'){ 
            ?>
            <style> 
                .tf_black_friday_20222_admin_notice a:focus {
                    box-shadow: none;
                } 
                .tf_black_friday_20222_admin_notice {
                    padding: 7px;
                    position: relative;
                    z-index: 10;
                }
                .tf_black_friday_20222_admin_notice { 
						max-width: 585px;
                }
                .tf_black_friday_20222_admin_notice button:before {
                    color: #fff !important;
                }
                .tf_black_friday_20222_admin_notice button:hover::before {
                    color: #d63638 !important;
                }
            </style>
            <div class="notice notice-success tf_black_friday_20222_admin_notice"> 
                <a href="<?php echo $deal_link; ?>" target="_blank" >
                    <img  style="width: 100%; height: 150px;" src="<?php echo UACF7_URL ?>/assets/img/BLACK_FRIDAY_BACKGROUND_GRUNGE_notice.png" alt="">
                </a> 
                <button type="button" class="notice-dismiss tf_black_friday_notice_dismiss"><span class="screen-reader-text"><?php echo __('Dismiss this notice.', 'ultimate-addons-cf7' ) ?></span></button>
            </div>
            <script>
                jQuery(document).ready(function($) {
                    $(document).on('click', '.tf_black_friday_notice_dismiss', function( event ) {
                        jQuery('.tf_black_friday_20222_admin_notice').css('display', 'none')
                        data = {
                            action : 'uacf7_black_friday_notice_dismiss_callback',
                        };

                        $.ajax({
                            url: ajaxurl,
                            type: 'post',
                            data: data,
                            success: function (data) { ;
                            },
                            error: function (data) { 
                            }
                        });
                    });
                });
            </script>
        
        <?php 
		}
		
	} 
	if (strtotime('2022-12-01') > time()) {
		add_action( 'admin_notices', 'uacf7_black_friday_20222_admin_notice' );  
	}   
}

function uacf7_black_friday_notice_dismiss_callback() { 
	$cookie_name = "uacf7_dismiss_admin_notice";
	$cookie_value = "1";
	setcookie($cookie_name, $cookie_value, time() + (86400 * 3), "/"); 
	wp_die();
}
add_action( 'wp_ajax_uacf7_black_friday_notice_dismiss_callback', 'uacf7_black_friday_notice_dismiss_callback' );
 
if(!function_exists('uacf7_black_friday_2022_callback')){
	 
	if (strtotime('2022-12-01') > time()) { 
		add_action( 'wpcf7_admin_misc_pub_section', 'uacf7_black_friday_2022_callback' );
	}    
	function uacf7_black_friday_2022_callback(){
		$deal_link =sanitize_url('https://themefic.com/go/uacf7-bf-deal');
	?> 
		<style> 
			.back_friday_2022_preview a:focus {
				box-shadow: none;
			} 
			.back_friday_2022_preview a {
				display: inline-block;
			}
			#uacf7_black_friday_docs .inside {
				padding: 0;
				margin-top: 0;
			}
            #uacf7_black_friday_docs .postbox-header {
				display: none;
				visibility: hidden;
			}
            .back_friday_2022_preview {
                position: relative;
            }
            .tf_black_friday_cf7_notice_dismiss {
                position: ;
                z-index: 1;
            }
		 
		</style>
        <?php if(!isset($_COOKIE['uacf7_dismiss_post_notice'])): ?>
		<div class="back_friday_2022_preview" style="text-align: center; overflow: hidden;">
			<a href="<?php echo $deal_link; ?>" target="_blank" >
				<img  style="width: 100%; transform: scale(1.3);" src="<?php echo UACF7_URL ?>/assets/img/BLACK_FRIDAY_BACKGROUND_GRUNGE.jpg" alt="">
			</a>  
            <button type="button" class="notice-dismiss tf_black_friday_cf7_notice_dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
		</div>
        <script>
            jQuery(document).ready(function($) {
                $(document).on('click', '.tf_black_friday_cf7_notice_dismiss', function( event ) { 
                    jQuery('.back_friday_2022_preview').css('display', 'none')
                    data = {
                        action : 'uacf7_black_friday_notice_cf7_dismiss_callback', 
                    };

                    $.ajax({
                        url: ajaxurl,
                        type: 'post',
                        data: data,
                        success: function (data) { ;
                        },
                        error: function (data) { 
                        }
                    });
                });
            });
        </script>
        <?php endif; ?>
	<?php
	}  
    function uacf7_black_friday_notice_cf7_dismiss_callback() { 
        $cookie_name = "uacf7_dismiss_post_notice";
        $cookie_value = "1";
        setcookie($cookie_name, $cookie_value, time() + (86400 * 3), "/"); 
        wp_die();
    }
    add_action( 'wp_ajax_uacf7_black_friday_notice_cf7_dismiss_callback', 'uacf7_black_friday_notice_cf7_dismiss_callback' );
     
}

