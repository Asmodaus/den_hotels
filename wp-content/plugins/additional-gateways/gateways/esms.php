<?php

namespace SMSGateway;


class ESMS {
    // docs at: https://esms.vn/blog/3-buoc-de-co-the-gui-tin-nhan-tu-website-ung-dung-cua-ban-bang-sms-api-cua-esmsvn
    public static function sendSMS($gateway_fields, $mobile, $message, $test_call) {
        $api_key = $gateway_fields['api_secret'];
        $api_secret = $gateway_fields['api_key'];
        $brandname = $gateway_fields['brandname'];

        return self::process_sms($api_key, $api_secret, $brandname, $mobile, $message, $test_call);
    }

    public static function process_sms($api_key, $api_secret, $brandname, $mobile, $message, $test_call) {
        $curl = curl_init();
        $params = array(
            'ApiKey' => $api_key,
            'ApiSecret' => $api_secret,
            'Brandname' => $brandname,
            'Phone' => $mobile,
            'Content' => $message,
            'SmsType' => 2,
        );
        $encoded_query = http_build_query($params);
        curl_setopt($curl, CURLOPT_URL, 'http://rest.esms.vn/MainService.svc/json/SendMultipleMessage_V4_get?' . $encoded_query);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curl_error = curl_errno($curl);
        curl_close($curl);

        if($test_call) return $result;

        if ($curl_error !== 0) {
            return false;
        }

        $is_success = 200 <= $code && $code < 300;

        return $is_success;
    }

}
