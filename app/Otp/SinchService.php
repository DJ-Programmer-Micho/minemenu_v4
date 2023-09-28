<?php

namespace App\Otp;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;

class SinchService
{
    public static function sendOTP($toNumber)
    {
        $applicationKey = env('SINCH_APP_KEY');
        $applicationSecret = env('SINCH_APP_SECRET');
// dd($applicationKey, $applicationSecret, $toNumber);
        $smsVerificationPayload = [
            "identity" => [
                "type" => "number",
                "endpoint" => $toNumber,
            ],
            "method" => "sms",
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . base64_encode("$applicationKey:$applicationSecret"),
        ])->post('https://verification.api.sinch.com/verification/v1/verifications', $smsVerificationPayload);

        return $response;
    }

    public static function verifyOTP($toNumber, $code)
    {
        $applicationKey = env('SINCH_APP_KEY');
        $applicationSecret = env('SINCH_APP_SECRET');

        $url = "https://verification.api.sinch.com/verification/v1/verifications/number/$toNumber";

        $smsVerificationPayload = [
            "method" => "sms",
            "sms" => [
                "code" => $code,
            ],
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . base64_encode("$applicationKey:$applicationSecret"),
        ])->put($url, $smsVerificationPayload);

        return $response;
    }
}
