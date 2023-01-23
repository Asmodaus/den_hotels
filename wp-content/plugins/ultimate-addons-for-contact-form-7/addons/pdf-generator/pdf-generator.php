<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
* Pre Populate Classs
*/
class UACF7_PDF_GENERATOR {
    
    /*
    * Construct function
    */
    public function __construct() {
        
        // add_action( 'wp_enqueue_scripts', array($this, 'wp_enqueue_script' ) );  
        add_action( 'admin_enqueue_scripts', array($this, 'wp_enqueue_admin_script' ) );    
        add_action( 'wpcf7_editor_panels', array( $this, 'uacf7_add_panel' ) );     
        add_action( 'wpcf7_after_save', array( $this, 'uacf7_save_contact_form' ) );   
        // add_action( 'wpcf7_before_send_mail', array( $this, 'wpcf7_before_send_mail' ) );   
        
        add_filter( 'wpcf7_mail_components', array( $this, 'mycustom_wpcf7_mail_components' ) );   
        add_filter( 'uacf7_get_generated_pdf', array( $this, 'uacf7_get_generated_pdf' ), 10, 2 );   
        
    } 

 
    /*
    * Enqueue script Backend
    */
    
    public function wp_enqueue_admin_script() {
        // jQuery
        wp_enqueue_script('jquery');
        // This will enqueue the Media Uploader script
        wp_enqueue_media();

        update_option('upload_path',WP_CONTENT_DIR.'/uploads');
        update_option('upload_url_path',content_url().'/uploads');
        update_option('uploads_use_yearmonth_folders', false); 
        wp_enqueue_script('media-upload');
        
        wp_enqueue_style( 'pdf-generator-admin-style', UACF7_ADDONS . '/pdf-generator/assets/css/pdf-generator-admin.css' );
		wp_enqueue_script( 'pdf-generator-admin', UACF7_ADDONS . '/pdf-generator/assets/js/pdf-generator-admin.js', array('jquery'), 'media-upload', true ); 
        $pdf_settings['codeEditor'] = wp_enqueue_code_editor(array('type' => 'text/css'));
        wp_localize_script('jquery', 'pdf_settings', $pdf_settings);
        // require UACF7_PATH . 'third-party/vendor/autoload.php';

    } 
 
    // public function wpcf7_before_send_mail($post){
    //     exit;
    // }
    public function uacf7_get_generated_pdf($form_id, $data_id){ 
        require UACF7_PATH . 'third-party/vendor/autoload.php';
        $enable_pdf = !empty(get_post_meta( $form_id, 'uacf7_enable_pdf_generator', true )) ? get_post_meta( $form_id, 'uacf7_enable_pdf_generator', true ) : '';
        if( $enable_pdf != 'on'){ die; }
        
        $upload_dir    = wp_upload_dir(); 
        $dir = $upload_dir['basedir'];
        global $wpdb; 
        $data = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."uacf7_form WHERE id = %s AND form_id = %s", $data_id, $form_id ) ); 

        $uacf7_pdf_name = !empty(get_post_meta( $form_id, 'uacf7_pdf_name', true )) ? get_post_meta( $form_id, 'uacf7_pdf_name', true ) : get_the_title( $form_id );
        $customize_pdf = !empty(get_post_meta( $form_id, 'customize_pdf', true )) ? get_post_meta( $form_id, 'customize_pdf', true ) : '';
        $pdf_bg_upload_image = !empty(get_post_meta( $form_id, 'pdf_bg_upload_image', true )) ? get_post_meta( $form_id, 'pdf_bg_upload_image', true ) : '';
        $customize_pdf_header = !empty(get_post_meta( $form_id, 'customize_pdf_header', true )) ? get_post_meta( $form_id, 'customize_pdf_header', true ) : '';
        $pdf_header_upload_image = !empty(get_post_meta( $form_id, 'pdf_header_upload_image', true )) ? get_post_meta( $form_id, 'pdf_header_upload_image', true ) : '';
        $pdf_header_img_height = !empty(get_post_meta( $form_id, 'pdf_header_img_height', true )) ? get_post_meta( $form_id, 'pdf_header_img_height', true ) : '';
        $pdf_header_img_width = !empty(get_post_meta( $form_id, 'pdf_header_img_width', true )) ? get_post_meta( $form_id, 'pdf_header_img_width', true ) : '';
        $pdf_header_img_aline = !empty(get_post_meta( $form_id, 'pdf_header_img_aline', true )) ? get_post_meta( $form_id, 'pdf_header_img_aline', true ) : '';
        $customize_pdf_footer = !empty(get_post_meta( $form_id, 'customize_pdf_footer', true )) ? get_post_meta( $form_id, 'customize_pdf_footer', true ) : '';
        $custom_pdf_css = !empty(get_post_meta( $form_id, 'custom_pdf_css', true )) ? get_post_meta( $form_id, 'custom_pdf_css', true ) : ''; 
        $pdf_content_color = !empty(get_post_meta( $form_id, 'pdf_content_color', true )) ? get_post_meta( $form_id, 'pdf_content_color', true ) : ''; 
        $pdf_content_bg_color = !empty(get_post_meta( $form_id, 'pdf_content_bg_color', true )) ? get_post_meta( $form_id, 'pdf_content_bg_color', true ) : '';  
        $pdf_header_color = !empty(get_post_meta( $form_id, 'pdf_header_color', true )) ? get_post_meta( $form_id, 'pdf_header_color', true ) : ''; 
        $pdf_header_bg_color = !empty(get_post_meta( $form_id, 'pdf_header_bg_color', true )) ? get_post_meta( $form_id, 'pdf_header_bg_color', true ) : '';  
        $pdf_footer_color = !empty(get_post_meta( $form_id, 'pdf_footer_color', true )) ? get_post_meta( $form_id, 'pdf_footer_color', true ) : ''; 
        $pdf_footer_bg_color = !empty(get_post_meta( $form_id, 'pdf_footer_bg_color', true )) ? get_post_meta( $form_id, 'pdf_footer_bg_color', true ) : '';  
        $pdf_bg_upload_image =  !empty($pdf_bg_upload_image) ? 'background-image: url("'.$pdf_bg_upload_image.'");' : '';
        $pdf_header_upload_image =  !empty($pdf_header_upload_image) ? '<img src="'.$pdf_header_upload_image.'" style="height: 60; max-width: 100%; ">' : '';

        $mpdf = new \Mpdf\Mpdf([ 
            'fontdata' => [ // lowercase letters only in font key
                'dejavuserifcond' => [
                    'R' => 'DejaVuSansCondensed.ttf',
                ]
            ],
            'mode' => 'utf-8',
            'default_font' => 'dejavusanscond',
            'margin_header' => 0,
            'margin_footer' => 0,
            'format' => 'A4', 
            'margin_left' => 0,
            'margin_right' => 0
        ]); 
        

        // PDF Style
        $pdf_style = ' <style>
            body {
                 '.$pdf_bg_upload_image.'
                background-repeat:no-repeat;
                background-image-resize: 6; 
            }
            .pdf-header{
                height: 60px;   
                background-color: '.$pdf_header_bg_color.';
                color : '.$pdf_header_color.'; 
            }
            .pdf-footer{ 
                background-color: '.$pdf_footer_bg_color.';
                color : '.$pdf_footer_color.'; 
            }
            .pdf-content{ 
                background-color: '.$pdf_content_bg_color.';
                color : '.$pdf_content_color.';
                padding: 20px;
                height: 100%;
            }
            .header-logo{
                text-align: '.$pdf_header_img_aline.'; 
                float: left; 
                width: 20%;
            }
            .header-content{
                float: right; 
                width: 80%
                
            }
            '.$custom_pdf_css.'
        </style>';
     

        // PDF Header
        $mpdf->SetHTMLHeader('
        <div class="pdf-header"  >
                <div class="header-logo"  >
                    '.$pdf_header_upload_image.'
                </div>    
                <div class="header-content">
                '.$customize_pdf_header.'
                </div>
        </div>
        ');

        // PDF Footer
        $mpdf->SetHTMLFooter('<div class="pdf-footer">'.$customize_pdf_footer.'</div>');
        $replace_key = [];
        $replace_value = []; 
        $uploaded_files = [];
        
       $form_value =  json_decode($data->form_value); 
        foreach($form_value as $key => $value){
            $replace_key[] = '['.$key.']';
            $replace_value[] = $value;
        }  

        $pdf_content = str_replace($replace_key, $replace_value, $customize_pdf);

        $mpdf->SetTitle($uacf7_pdf_name);

         // PDF Footer Content
        $mpdf->WriteHTML($pdf_style.'<div class="pdf-content">'.$pdf_content.'   </div>');

        $pdf_url = $dir.'/uacf7-uploads/'.$uacf7_pdf_name.'.pdf';
        $mpdf->Output($pdf_url, 'D'); // Dwonload
        die();


    }
    function mycustom_wpcf7_mail_components( $components  ) { 

        $wpcf7 = WPCF7_ContactForm::get_current();
        $enable_pdf = !empty(get_post_meta( $wpcf7->id(), 'uacf7_enable_pdf_generator', true )) ? get_post_meta( $wpcf7->id(), 'uacf7_enable_pdf_generator', true ) : '';
        if($enable_pdf == 'on'){ 
            $submission = WPCF7_Submission::get_instance();
            $contact_form_data = $submission->get_posted_data();
            $files            = $submission->uploaded_files();
          
            require UACF7_PATH . 'third-party/vendor/autoload.php';
            $upload_dir    = wp_upload_dir(); 
            $time_now      = time();
            $dir = $upload_dir['basedir'];
            $uploaded_files = [];
            $uacf7_dirname = $upload_dir['basedir'].'/uacf7-uploads';
            if ( ! file_exists( $uacf7_dirname ) ) {
                wp_mkdir_p( $uacf7_dirname ); 
            } 
            foreach ($_FILES as $file_key => $file) {
                array_push($uploaded_files, $file_key);
            }

            //  
            $uacf7_pdf_name = !empty(get_post_meta( $wpcf7->id(), 'uacf7_pdf_name', true )) ? get_post_meta( $wpcf7->id(), 'uacf7_pdf_name', true ) : get_the_title( $wpcf7->id() );
            $customize_pdf = !empty(get_post_meta( $wpcf7->id(), 'customize_pdf', true )) ? get_post_meta( $wpcf7->id(), 'customize_pdf', true ) : '';
            $pdf_bg_upload_image = !empty(get_post_meta( $wpcf7->id(), 'pdf_bg_upload_image', true )) ? get_post_meta( $wpcf7->id(), 'pdf_bg_upload_image', true ) : '';
            $customize_pdf_header = !empty(get_post_meta( $wpcf7->id(), 'customize_pdf_header', true )) ? get_post_meta( $wpcf7->id(), 'customize_pdf_header', true ) : '';
            $pdf_header_upload_image = !empty(get_post_meta( $wpcf7->id(), 'pdf_header_upload_image', true )) ? get_post_meta( $wpcf7->id(), 'pdf_header_upload_image', true ) : '';
            $pdf_header_img_height = !empty(get_post_meta( $wpcf7->id(), 'pdf_header_img_height', true )) ? get_post_meta( $wpcf7->id(), 'pdf_header_img_height', true ) : '';
            $pdf_header_img_width = !empty(get_post_meta( $wpcf7->id(), 'pdf_header_img_width', true )) ? get_post_meta( $wpcf7->id(), 'pdf_header_img_width', true ) : '';
            $pdf_header_img_aline = !empty(get_post_meta( $wpcf7->id(), 'pdf_header_img_aline', true )) ? get_post_meta( $wpcf7->id(), 'pdf_header_img_aline', true ) : '';
            $customize_pdf_footer = !empty(get_post_meta( $wpcf7->id(), 'customize_pdf_footer', true )) ? get_post_meta( $wpcf7->id(), 'customize_pdf_footer', true ) : '';
            $custom_pdf_css = !empty(get_post_meta( $wpcf7->id(), 'custom_pdf_css', true )) ? get_post_meta( $wpcf7->id(), 'custom_pdf_css', true ) : ''; 
            $pdf_content_color = !empty(get_post_meta( $wpcf7->id(), 'pdf_content_color', true )) ? get_post_meta( $wpcf7->id(), 'pdf_content_color', true ) : ''; 
            $pdf_content_bg_color = !empty(get_post_meta( $wpcf7->id(), 'pdf_content_bg_color', true )) ? get_post_meta( $wpcf7->id(), 'pdf_content_bg_color', true ) : '';  
            $pdf_header_color = !empty(get_post_meta( $wpcf7->id(), 'pdf_header_color', true )) ? get_post_meta( $wpcf7->id(), 'pdf_header_color', true ) : ''; 
            $pdf_header_bg_color = !empty(get_post_meta( $wpcf7->id(), 'pdf_header_bg_color', true )) ? get_post_meta( $wpcf7->id(), 'pdf_header_bg_color', true ) : '';  
            $pdf_footer_color = !empty(get_post_meta( $wpcf7->id(), 'pdf_footer_color', true )) ? get_post_meta( $wpcf7->id(), 'pdf_footer_color', true ) : ''; 
            $pdf_footer_bg_color = !empty(get_post_meta( $wpcf7->id(), 'pdf_footer_bg_color', true )) ? get_post_meta( $wpcf7->id(), 'pdf_footer_bg_color', true ) : '';  
            $pdf_bg_upload_image =  !empty($pdf_bg_upload_image) ? 'background-image: url("'.$pdf_bg_upload_image.'");' : '';
            $pdf_header_upload_image =  !empty($pdf_header_upload_image) ? '<img src="'.$pdf_header_upload_image.'" style="height: 60; max-width: 100%; ">' : '';
            $mpdf = new \Mpdf\Mpdf([ 
                'fontdata' => [ // lowercase letters only in font key
                    'dejavuserifcond' => [
                        'R' => 'DejaVuSansCondensed.ttf',
                    ]
                ],
                'mode' => 'utf-8',
                'default_font' => 'dejavusanscond',
                'margin_header' => 0,
                'margin_footer' => 0,
                'format' => 'A4', 
                'margin_left' => 0,
                'margin_right' => 0
            ]); 
            $replace_key = [];

            // PDF Style
            $pdf_style = ' <style>
                body {
                     '.$pdf_bg_upload_image.'
                    background-repeat:no-repeat;
                    background-image-resize: 6; 
                }
                .pdf-header{
                    height: 60px;   
                    background-color: '.$pdf_header_bg_color.';
                    color : '.$pdf_header_color.'; 
                }
                .pdf-footer{ 
                    background-color: '.$pdf_footer_bg_color.';
                    color : '.$pdf_footer_color.'; 
                }
                .pdf-content{ 
                    background-color: '.$pdf_content_bg_color.';
                    color : '.$pdf_content_color.';
                    padding: 20px;
                    height: 100%;
                }
                .header-logo{
                    text-align: '.$pdf_header_img_aline.'; 
                    float: left; 
                    width: 20%;
                }
                .header-content{
                    float: right; 
                    width: 80%
                    
                }
                '.$custom_pdf_css.'
            </style>';
            $replace_value = []; 

            // PDF Header
            $mpdf->SetHTMLHeader('
            <div class="pdf-header"  >
                    <div class="header-logo"  >
                        '.$pdf_header_upload_image.'
                    </div>    
                    <div class="header-content">
                    '.$customize_pdf_header.'
                    </div>
            </div>
            ');

            // PDF Footer
            $mpdf->SetHTMLFooter('<div class="pdf-footer">'.$customize_pdf_footer.'</div>');

            foreach($contact_form_data as $key => $value){
                if(!in_array($key, $uploaded_files)){ 
                    $replace_key[] = '['.$key.']';
                    $replace_value[] = $value;
                }
                
                
            }
            
            foreach ($files as $file_key => $file) {
                if(!empty($file)){
                    if(in_array($file_key, $uploaded_files)){ 
                        $file = is_array( $file ) ? reset( $file ) : $file; 
                        $dir_link = '/uacf7-uploads/'.$time_now.'-'.$file_key.'-'.basename($file);
                        copy($file, $dir.$dir_link); 
                        $replace_key[] = '['.$file_key.']';
                        $replace_value[] = $upload_dir['baseurl'].$dir_link; 
                    }  
                }
                
            } 

            $pdf_content = str_replace($replace_key, $replace_value, $customize_pdf);

            $mpdf->SetTitle($uacf7_pdf_name);

             // PDF Footer Content
            $mpdf->WriteHTML($pdf_style.'<div class="pdf-content">'.$pdf_content.'   </div>');

            $pdf_url = $dir.'/uacf7-uploads/'.$uacf7_pdf_name.'.pdf';
            $mpdf->Output($pdf_url, 'F'); // save to databaes 
           
            $components['attachments'][] = $pdf_url;
            
        }
        return $components;
      
    }

    /*
    * Function create tab panel
    */
    public function uacf7_add_panel( $panels ) {
		$panels['uacf7-pdf-generator-panel'] = array(
            'title'    => __( 'UACF7 PDF Generator', 'ultimate-addons-cf7' ),
			'callback' => array( $this, 'uacf7_create_pdf_generator_panel_fields' ),
		);
		return $panels;

	}
    
   
    /*
    * Function PDF Generator fields
    */
    public function uacf7_create_pdf_generator_panel_fields($post) {

         // get existing value 
         $all_fields = $post->scan_form_tags();
         
         $uacf7_enable_pdf_generator = get_post_meta( $post->id(), 'uacf7_enable_pdf_generator', true ); 
         $uacf7_pdf_name = get_post_meta( $post->id(), 'uacf7_pdf_name', true ); 
         $customize_pdf = get_post_meta( $post->id(), 'customize_pdf', true ); 
         $pdf_bg_upload_image = get_post_meta( $post->id(), 'pdf_bg_upload_image', true );  
         $customize_pdf_header = get_post_meta( $post->id(), 'customize_pdf_header', true ); 
         $pdf_header_upload_image = get_post_meta( $post->id(), 'pdf_header_upload_image', true );  
         $customize_pdf_footer = get_post_meta( $post->id(), 'customize_pdf_footer', true ); 
         $custom_pdf_css = get_post_meta( $post->id(), 'custom_pdf_css', true ); 
         $pdf_content_color = get_post_meta( $post->id(), 'pdf_content_color', true ); 
         $pdf_content_bg_color = get_post_meta( $post->id(), 'pdf_content_bg_color', true ); 
         $pdf_header_color = get_post_meta( $post->id(), 'pdf_header_color', true ); 
         $pdf_header_bg_color = get_post_meta( $post->id(), 'pdf_content_bg_color', true ); 
         $pdf_footer_color = get_post_meta( $post->id(), 'pdf_footer_color', true ); 
         $pdf_footer_bg_color = get_post_meta( $post->id(), 'pdf_footer_bg_color', true ); 
        ?>
        <h2><?php echo esc_html__( 'PDF Generator', 'ultimate-addons-cf7' ); ?></h2>
        <p><?php echo esc_html__('This feature will help you to create pdf after form submission, send to mail, stored pdf into the server and export pdf form the admin.','ultimate-addons-cf7'); ?></p>
        <div class="uacf7-doc-notice">Not sure how to set this? Check our step by step <a href="https://themefic.com/docs/ultimate-addons-for-contact-form-7/pdf-generator/" target="_blank">documentation</a>.</div>
        <fieldset>
           <div class="ultimate-placeholder-admin pdf-generator-admin">
               <div class="ultimate-placeholder-wrapper pdf-generator-wrap">
                  <img src="" alt="">
                  <h3> Option</h3>
                  <div class="uacf7pdf-twocolumns">
                       <h4><?php _e('Enable PDF Generator', 'ultimate-addons-cf7'); ?></h4>
                       <label for="uacf7_enable_pdf_generator">  
                            <input id="uacf7_enable_pdf_generator" type="checkbox" name="uacf7_enable_pdf_generator" <?php checked( 'on', $uacf7_enable_pdf_generator ); ?> > Enable
                        </label><br><br>
                    </div>
                  <div class="uacf7pdf-twocolumns">
                       <h4><?php _e('PDF Title', 'ultimate-addons-cf7'); ?></h4>
                       <label for="uacf7_pdf_name">  
                            <input id="uacf7_pdf_name" type="text" ize="100%" name="uacf7_pdf_name"  value="<?php  echo esc_attr_e($uacf7_pdf_name); ?>" >.pdf
                        </label><br><br>
                    </div>
                 
                    <hr>
                   <h3>Customize PDF</h3> 
                   <hr>
                   <div class="uacf7pdf-twocolumns">
                       <h4><?php _e('Background Image', 'ultimate-addons-cf7'); ?></h4>
                       <input id="pdf_bg_upload_image" size="60%" class="wpcf7-form-field" name="pdf_bg_upload_image" value="<?php echo esc_attr_e($pdf_bg_upload_image); ?>" type="text" /> 
                       <a href="#" id="upload_pdf_image_button" class="button" ><span> <?php _e('Select or Upload picture', 'ultimate-addons-cf7'); ?> </span></a> <br /> 
              
                   </div>
                   <div class="uacf7pdf-fourcolumns">
                        <h4><?php _e('Color', 'ultimate-addons-cf7'); ?> </h4> 
                        <input type="text" id="uacf7-uacf7style-input-color" name="pdf_content_color" class="uacf7-color-picker" value="<?php echo esc_attr_e($pdf_content_color); ?>" placeholder="<?php echo esc_html__( 'Color', 'ultimate-addons-cf7' ); ?>">  
                    </div>
                    <div class="uacf7pdf-fourcolumns">
                        <h4><?php _e('Background Color', 'ultimate-addons-cf7'); ?>  </h4> 
                        <input type="text" id="uacf7-uacf7style-input-color" name="pdf_content_bg_color" class="uacf7-color-picker" value="<?php echo esc_attr_e($pdf_content_bg_color); ?>" placeholder="<?php echo esc_html__( 'Background color', 'ultimate-addons-cf7' ); ?>">  
                    </div>  
                   <div class="uacf7pdf-onecolumns">
                        <p> <strong>Form Tags : </strong>
                            <strong>
                                <?php
                                    foreach ($all_fields as $tag) {
                                        if ($tag['type'] != 'submit') {
                                            echo '<span>['.$tag['name'].']</span> ';
                                        }
                                    }
                                ?>
                            </strong>
                        </p>

                        <label for="customize_pdf">  
                        <?php wp_editor( $customize_pdf, 'post_meta_box', array('textarea_name'=>'customize_pdf', 'media_buttons' => false )); ?>

                            <!-- <input type="text" id="customize_pdf" name="customize_pdf" class="large-text" value="<?php echo esc_attr_e($customize_pdf); ?>" placeholder="<?php echo esc_html__( 'Enter Your Custom CSS', 'ultimate-addons-cf7' ); ?>">  -->
                        </label><br><br>
                   </div>
                  
                    <hr>
                   <h3>Customize PDF header</h3> 
                   <hr> 
                   <p> <strong>header and footer page numbers & date Tags : 
                        <span>{PAGENO}</span>, 
                        <span>{DATE j-m-Y}</span>, 
                        <span>{nb}</span>, 
                        <span>{nbpg}</span>
                        </strong>
                        
                    </p>
                   <div class="uacf7pdf-twocolumns">
                       <h4><?php _e('Header Image', 'ultimate-addons-cf7'); ?></h4>
                       <input id="upload_image" size="60%" class="wpcf7-form-field" name="pdf_header_upload_image" value="<?php echo esc_attr_e($pdf_header_upload_image); ?>" type="text" /> 
                       <a href="#" id="upload_image_button" class="button" ><span> <?php _e('Select or Upload picture', 'ultimate-addons-cf7'); ?> </span></a> <br /> 
                    </div> 
                    <div class="uacf7pdf-fourcolumns">
                        <h4><?php _e('Color', 'ultimate-addons-cf7'); ?> </h4> 
                        <input type="text" id="uacf7-uacf7style-input-color" name="pdf_header_color" class="uacf7-color-picker" value="<?php echo esc_attr_e($pdf_header_color); ?>" placeholder="<?php echo esc_html__( 'Color', 'ultimate-addons-cf7' ); ?>">  
                    </div>
                    <div class="uacf7pdf-fourcolumns">
                        <h4><?php _e('Background Color', 'ultimate-addons-cf7'); ?>  </h4> 
                        <input type="text" id="uacf7-uacf7style-input-color" name="pdf_header_bg_color" class="uacf7-color-picker" value="<?php echo esc_attr_e($pdf_header_bg_color); ?>" placeholder="<?php echo esc_html__( 'Background color', 'ultimate-addons-cf7' ); ?>">  
                    </div>  
                     
                   <div class="uacf7pdf-onecolumns">
                    <br>
                    <br>
                        <label for="customize_pdf">  
                             <?php wp_editor( $customize_pdf_header, 'post_meta_box2', array('textarea_name'=>'customize_pdf_header', 'media_buttons' => false )); ?> 
                        </label><br><br>
                   </div>
                   <div class="uacf7pdf-onecolumns">
                        <h3>Customize PDF footer</h3>
                        <hr> 
                        <div class="uacf7pdf-fourcolumns">
                            <h4><?php _e('Color', 'ultimate-addons-cf7'); ?> </h4> 
                            <input type="text" id="uacf7-uacf7style-input-color" name="pdf_footer_color" class="uacf7-color-picker" value="<?php echo esc_attr_e($pdf_footer_color); ?>" placeholder="<?php echo esc_html__( 'Color', 'ultimate-addons-cf7' ); ?>">  
                        </div>
                        <div class="uacf7pdf-fourcolumns">
                            <h4><?php _e('Background Color', 'ultimate-addons-cf7'); ?>  </h4> 
                            <input type="text" id="uacf7-uacf7style-input-color" name="pdf_footer_bg_color" class="uacf7-color-picker" value="<?php echo esc_attr_e($pdf_footer_bg_color); ?>" placeholder="<?php echo esc_html__( 'Background color', 'ultimate-addons-cf7' ); ?>"> 
        
                        </div>  
                        <div class="uacf7pdf-onecolumns">
                            <label for="customize_pdf">  
                                <?php wp_editor( $customize_pdf_footer, 'post_meta_box4', array('textarea_name'=>'customize_pdf_footer', 'media_buttons' => false )); ?> 
                            </label><br><br>
                         </div>  
                   </div>
                   <div class="uacf7pdf-onecolumns">
                        <h3>Custom CSS</h3>
                        <hr> 
                        <label for="customize_pdf">  
                            <input type="text" id="custom_pdf_css" name="custom_pdf_css" class="large-text" value="<?php echo esc_attr_e($custom_pdf_css); ?>" placeholder="<?php echo esc_html__( 'Customize PDF CSS', 'ultimate-addons-cf7' ); ?>"> 
                        </label><br><br>
                   </div>
                   
                  
               </div>
           </div>
        </fieldset>
        <?php
        wp_nonce_field( 'uacf7_pdf_generator_nonce_action', 'uacf7_pdf_generator_nonce' );
	}
    public function uacf7_save_contact_form( $form ) {
        
        if ( ! isset( $_POST ) || empty( $_POST ) ) {
			return;
		}
        if ( ! wp_verify_nonce( $_POST['uacf7_pdf_generator_nonce'], 'uacf7_pdf_generator_nonce_action' ) ) {
            return;
        } 

        update_post_meta( $form->id(), 'uacf7_enable_pdf_generator', $_POST['uacf7_enable_pdf_generator'] );
        update_post_meta( $form->id(), 'uacf7_pdf_name', $_POST['uacf7_pdf_name'] );
        update_post_meta( $form->id(), 'customize_pdf', $_POST['customize_pdf'] );
        update_post_meta( $form->id(), 'pdf_bg_upload_image', $_POST['pdf_bg_upload_image'] );
        update_post_meta( $form->id(), 'customize_pdf_header', $_POST['customize_pdf_header'] );
        update_post_meta( $form->id(), 'pdf_header_upload_image', $_POST['pdf_header_upload_image'] );  
        update_post_meta( $form->id(), 'customize_pdf_footer', $_POST['customize_pdf_footer'] );
        update_post_meta( $form->id(), 'custom_pdf_css', $_POST['custom_pdf_css'] );
        update_post_meta( $form->id(), 'pdf_content_color', $_POST['pdf_content_color'] );
        update_post_meta( $form->id(), 'pdf_content_bg_color', $_POST['pdf_content_bg_color'] );
        update_post_meta( $form->id(), 'pdf_header_color', $_POST['pdf_header_color'] );
        update_post_meta( $form->id(), 'pdf_header_bg_color', $_POST['pdf_header_bg_color'] );
        update_post_meta( $form->id(), 'pdf_footer_color', $_POST['pdf_footer_color'] );
        update_post_meta( $form->id(), 'pdf_footer_bg_color', $_POST['pdf_footer_bg_color'] );
         
    }
   
     
}
 
new UACF7_PDF_GENERATOR();