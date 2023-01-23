<fieldset>
    <div class="ultimate-mailchimp-admin">
        <div class="ultimate-mailchimp-wrapper">

            <?php
            echo $this->connection_status();
            ?>
            <p><a href="<?php echo esc_url(admin_url('/admin.php?page=ultimate-addons')); ?>"><?php echo esc_html__( ' Mailchimp Api Settings Panel', 'ultimate-addons-cf7' ); ?></a></p>
            <?php
            $form_enable = get_post_meta($post->id(), 'uacf7_mailchimp_form_enable', true);
            $form_type = ! empty( get_post_meta($post->id(), 'uacf7_mailchimp_form_type', true)) ? get_post_meta($post->id(), 'uacf7_mailchimp_form_type', true) : ""; 
            $audience = ! empty( get_post_meta($post->id(), 'uacf7_mailchimp_audience', true)) ? get_post_meta($post->id(), 'uacf7_mailchimp_audience', true) : ""; 
            $subscriber_email = ! empty( get_post_meta($post->id(), 'uacf7_mailchimp_subscriber_email', true)) ? get_post_meta($post->id(), 'uacf7_mailchimp_subscriber_email', true) : "";
            $subscriber_fname =  ! empty( get_post_meta($post->id(), 'uacf7_mailchimp_subscriber_fname', true)) ? get_post_meta($post->id(), 'uacf7_mailchimp_subscriber_fname', true) : "";
            $subscriber_lname = ! empty( get_post_meta($post->id(), 'uacf7_mailchimp_subscriber_lname', true)) ? get_post_meta($post->id(), 'uacf7_mailchimp_subscriber_lname', true) : "";
            $uacf7_mailchimp_merge_fields = empty(get_post_meta($post->id(), 'uacf7_mailchimp_merge_fields', true)) ? array() : get_post_meta($post->id(), 'uacf7_mailchimp_merge_fields', true); 
    
            ?>
            <div class="mailchimp_fields_row">
                <h3><?php echo esc_html__( 'Mailchimp form settings ', 'ultimate-addons-cf7' ); ?></h3>
                <label for="uacf7_mailchimp_form_enable">
                    <input id="uacf7_mailchimp_form_enable" type="checkbox" value="enable" name="uacf7_mailchimp_form_enable" <?php checked($form_enable, 'enable', true); ?>> <strong><?php echo esc_html__( 'Enable mailchimp form', 'ultimate-addons-cf7' ); ?></strong>
                </label>
            </div>
            <br>
            <br>
            <div class="mailchimp_fields_row">
                <label>
                    <input type="radio" name="uacf7_mailchimp_form_type" checked="checked" value="subscribe" <?php checked($form_type, 'subscribe', true); ?>> <strong><?php echo esc_html__( 'Create Subscribe Form', 'ultimate-addons-cf7' ); ?></strong>
                </label><br>
                <label>
                    <input type="radio" name="uacf7_mailchimp_form_type" value="unsubscribe" disabled <?php //checked($form_type, 'unsubscribe', true); ?>> <strong><?php echo esc_html__( 'Create Unsubscribe Form', 'ultimate-addons-cf7' ); ?></strong>
                </label>
            </div>
            <br>
            <br>
            <div class="mailchimp_fields_row">

                <label for="uacf7_mailchimp_audience">
                    <strong><?php echo esc_html__( 'Select Audience', 'ultimate-addons-cf7' ); ?></strong><br>
                    <select name="uacf7_mailchimp_audience" id="uacf7_mailchimp_audience">
                        <?php
                        $api_key = $this->mailchimp_api;

                        if ($api_key != '') {

                            $response = $this->set_config($api_key, 'lists');
 
                            $response = json_decode($response, true);
                            $x = 0;
                            foreach ($response['lists'] as $list) {
                                echo '<option value="' . $list['id'] . '" ' . selected($audience, $list['id']) . '>' . $list['name'] . '</option>';

                                $x++;
                            }
                        } else {
                        }
                        ?>
                    </select>
                </label>
            </div>
            <br>
            <br>
            <div class="mailchimp_fields_row">

                <table>
                    <tr>
                        <td>
                            <label for="uacf7_mailchimp_subscriber_email">
                                <strong><?php echo esc_html__( 'Subscriber Email', 'ultimate-addons-cf7' ); ?></strong><br>
                                <select name="uacf7_mailchimp_subscriber_email" id="uacf7_mailchimp_subscriber_email">
                                    <?php
                                    $all_tags = $post->scan_form_tags(array('type' => 'email', 'type' => 'email*'));
                                    foreach ($all_tags as $tag) {
                                        echo '<option value="' . esc_attr($tag['name']) . '" ' . selected($subscriber_email, $tag['name']) . '>' . esc_attr($tag['name']) . '</option>';
                                    }
                                    ?>
                                </select>
                            </label>
                        </td>
                        <td>
                            <label for="uacf7_mailchimp_subscriber_fname">
                                <strong><?php echo esc_html__( 'Subscriber First Name', 'ultimate-addons-cf7' ); ?></strong><br>
                                <select name="uacf7_mailchimp_subscriber_fname" id="uacf7_mailchimp_subscriber_fname">
                                    <?php
                                    $fname_tags = $post->scan_form_tags(array('type' => 'text', 'type' => 'text*'));
                                    foreach ($fname_tags as $tag) {
                                        echo '<option value="' . esc_attr($tag['name']) . '" ' . selected($subscriber_fname, $tag['name']) . '>' . esc_attr($tag['name']) . '</option>';
                                    }
                                    ?>
                                </select>
                            </label>
                        </td>
                        <td>
                            <label for="uacf7_mailchimp_subscriber_lname">
                                <strong><?php echo esc_html__( 'Subscriber Last Name', 'ultimate-addons-cf7' ); ?></strong><br>
                                <select name="uacf7_mailchimp_subscriber_lname" id="uacf7_mailchimp_subscriber_lname">
                                    <?php
                                    $lname_tags = $post->scan_form_tags(array('type' => 'text', 'type' => 'text*'));
                                    foreach ($lname_tags as $tag) {
                                        echo '<option value="' . esc_attr($tag['name']) . '" ' . selected($subscriber_lname, $tag['name']) . '>' . esc_attr($tag['name']) . '</option>';
                                    }
                                    ?>
                                </select>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h3><?php echo esc_html__( 'Custom fields', 'ultimate-addons-cf7' ); ?></h3>
                        </td>
                    </tr>

                    <?php
                    $all_fields = $post->scan_form_tags();
                    $x = 1; 
                   
                    foreach ($all_fields as $field) {
                        if ($field['type'] != 'submit') {
                            $cf7_tag = '';
                            $mergefield = '';
                            if(is_array($uacf7_mailchimp_merge_fields) && !empty($uacf7_mailchimp_merge_fields)){
                                $count = count($uacf7_mailchimp_merge_fields); 
                                for ($i = 0; $i <= $count; $i++) { 
                                    if($i== $x){ 
                                        $cf7_tag = $uacf7_mailchimp_merge_fields[$x]['mailtag'];
                                        $mergefield = $uacf7_mailchimp_merge_fields[$x]['mergefield'];
                                    }
                                } 
                            } 
                             
                    ?>
                            <tr>
                                <td>
                                    <label><strong><?php echo esc_html__( 'Contact form tag', 'ultimate-addons-cf7' ); ?></strong><br>
                                        <select name="uacf7_mailchimp_extra_field_mailtag_<?php echo esc_attr($x); ?>">
                                            <?php
                                            echo '<option value="">Select Field</option>';
                                            foreach ($all_fields as $tag) {
                                                if ($tag['type'] != 'submit') {
                                                    echo '<option value="' . esc_attr($tag['name']) . '" ' . selected($cf7_tag, $tag['name']) . '>' . esc_attr($tag['name']) . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </label>
                                </td>
                                <td>
                                    <label> <strong><?php echo esc_html__( 'Mailchimp field', 'ultimate-addons-cf7' ); ?></strong><br>
                                        <input type="text" placeholder="Please enter mailchimp custom field name" name="uacf7_mailchimp_extra_field_mergefield_<?php echo esc_attr($x); ?>" value="<?php echo esc_attr($mergefield); ?>">
                                    </label>
                                </td>
                            </tr>
                    <?php
                            $x++;
                        }
                    }
                    ?>

                </table>

            </div>

            <?php wp_nonce_field('uacf7_mailchimp_nonce_action', 'uacf7_mailchimp_nonce'); ?>

        </div>
    </div>
</fieldset>