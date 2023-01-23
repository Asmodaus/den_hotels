<?php

namespace SMSGateway;


class Telnyx {
    // docs at: https://developers.telnyx.com/docs/v1/messaging/quickstarts/sending-sms-and-mms
    public static function sendSMS($gateway_fields, $mobile, $message, $test_call) {
        $profile_secret = $gateway_fields['profile_secret'];
        $sender = $gateway_fields['sender'];

        return self::process_sms($profile_secret, $sender, $mobile, $message, $test_call);
    }

    public static function process_sms($profile_secret, $mobile, $message, $test_call) {
        $curl = curl_init();
        $data = array(
            'body' => $message,
            'to' => $mobile,
            'from' => $sender,
        );

        curl_setopt($curl, CURLOPT_URL, 'https://sms.telnyx.com/messages');
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'X-Profile-Secret: ' . $profile_secret,
            )
        );
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data, true));

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
