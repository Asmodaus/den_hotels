<?php

if (!defined('ABSPATH')) {
    exit;
}

add_action('digits_activation_hooks', 'digits_create_req_logs_db');

function digits_create_req_logs_db()
{
    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();

    $tb = $wpdb->prefix . 'digits_request_logs';
    if ($wpdb->get_var("SHOW TABLES LIKE '$tb'") != $tb) {
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $tb (
                  request_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
		          phone VARCHAR(40) NOT NULL,
		          email VARCHAR(100) NOT NULL,
		          mode VARCHAR(100) NOT NULL,
		          request_type VARCHAR(100) NOT NULL,
		          user_agent VARCHAR(255) NULL,
		          ip VARCHAR(50) NOT NULL,
		          time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
		          PRIMARY KEY  (request_id)
	            ) $charset_collate;";
    }

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta(array($sql));
}

function digits_add_request_log($phone, $mode)
{
    global $wpdb;
    $table = $wpdb->prefix . 'digits_request_logs';
    $data = array();
    $data['ip'] = digits_get_ip();
    $data['phone'] = $phone;
    $data['mode'] = $mode;
    $data['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

    return $wpdb->insert($table, $data);
}

function digits_check_request($phone)
{
    $limits = array(
        array(
            'duration_type' => 'hour',
            'duration' => 1,
            'max' => 12,
            'type' => 'phone'
        ),
        array(
            'duration_type' => 'day',
            'duration' => 1,
            'max' => 18,
            'type' => 'phone'
        ),
        array(
            'duration_type' => 'day',
            'duration' => 30,
            'max' => 50,
            'type' => 'phone'
        ),
        array(
            'duration_type' => 'day',
            'duration' => 365,
            'max' => 365,
            'type' => 'phone'
        ),
        array(
            'duration_type' => 'hour',
            'duration' => 1,
            'max' => 20,
            'type' => 'ip'
        ),
        array(
            'duration_type' => 'day',
            'duration' => 1,
            'max' => 90,
            'type' => 'ip'
        ),
        array(
            'duration_type' => 'day',
            'duration' => 30,
            'max' => 300,
            'type' => 'ip'
        ),
        array(
            'duration_type' => 'day',
            'duration' => 365,
            'max' => 1000,
            'type' => 'ip'
        ),
    );

    $ip = digits_get_ip();
    foreach ($limits as $limit) {
        $duration_type = $limit['duration_type'];
        $duration = $limit['duration'];
        $type = $limit['type'];
        $max = $limit['max'];

        if ($type == 'ip') {
            $key = 'ip';
            $value = $ip;
        } else {
            $key = 'phone';
            $value = $phone;
        }
        $count = digits_count_req_in_time($key, $value, $duration, $duration_type);
        if ($count > $max) {
            return new WP_Error('limit_exceed', __('OTP limit has exceeded since you made too many attempts, Please try again after some time!', 'digits'));
        }
    }
    return true;
}

function digits_count_req_in_time($key, $value, $days, $duration_type)
{
    global $wpdb;
    $table = $wpdb->prefix . 'digits_request_logs';
    $days = absint($days);

    if (empty($days)) {
        return 0;
    }

    $key = filter_var($key, FILTER_SANITIZE_STRING);

    if ($duration_type == 'hour') {
        $diff = 'TIMESTAMPDIFF(HOUR, time, CURDATE())';
    } else {
        $diff = 'DATEDIFF(CURDATE(), time)';
    }
    $query = $wpdb->prepare("select count(*) from " . $table . " where " . $key . "='%s' AND " . $diff . " <= " . $days, $value);
    $results = $wpdb->get_var($query);
    return $results;
}
