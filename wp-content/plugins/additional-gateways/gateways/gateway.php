<?php

namespace SMSGateway;

require_once 'utils.php';

class Gateway
{
    public static $chunks = 50;
    public static $supports_bulk = true;
    public static $bulk_type = 'FIXED_MESSAGE';

    // docs at: https://gateway.sa/wp-content/uploads/SendingAPI-English-Gateway.sa_.pdf
    public static function sendSMS($gateway_fields, $mobile, $message, $test_call)
    {
        $last_sent_or_results = self::process_sms($gateway_fields, $mobile, $message, $test_call);
        if ($test_call) {
            return $last_sent_or_results[0];
        }

        if ($last_sent_or_results === -1) {
            return false;
        }

        return true;
    }

    public static function sendBulkSMS($gateway_fields, $messages, $test_call)
    {
        return self::process_sms($gateway_fields, '',$messages, $test_call);
    }

    public static function process_sms($gateway_fields, $mobile, $messages, $test_call)
    {

        $username = $gateway_fields['username'];
        $password = $gateway_fields['password'];
        $sender = $gateway_fields['sender'];

        $curl = curl_init();
        $post_params = array(
            'ApiKey' => $username,
            'ClientId' => $password,
            'SenderId' => $sender,
            'Message' => $messages,
            'MobileNumbers' => $mobile,
        );

        curl_setopt($curl, CURLOPT_URL, ' https://api.gateway.sa/api/v2/SendSMS?' . http_build_query($post_params));
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curl_error = curl_errno($curl);
        curl_close($curl);

        if ($test_call) {
            return $result;
        }

        $is_success = 200 <= $code && $code < 300;

        return true;

    }
}
