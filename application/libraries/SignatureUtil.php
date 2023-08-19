<?php

use phpseclib3\Crypt\RSA;

class SignatureUtil
{
    public static function generateOauthSignature($private_key_str, $client_id, $iso_time)
    {
        $private_key = RSA::load(base64_decode($private_key_str));
        $signer = new PKCS1_v1_5();
        $signer->setPrivateKey($private_key);
        $dataToSign = $client_id . "|" . $iso_time;
        $signature = $signer->sign(hash('sha256', $dataToSign));
        $signStr = base64_encode($signature);
        return $signStr;
    }

    public function getToken($private_key_str, $client_id, $iso_time)
    {
        $private_key = openssl_pkey_get_private(file_get_contents("file:///C:/laragon/www/api-motionpay/private.pem"));
        $dataToSign = $client_id . "|" . $iso_time;
        openssl_sign($dataToSign, $signature, $private_key, OPENSSL_ALGO_SHA256);
        $signStr = base64_encode($signature);
        print_r($signStr);
        die;
        return $signStr;
    }
}
