<?php

class Pakasir {
    private static $baseUrl = 'https://app.pakasir.com/api';

    public static function createTransaction($orderId, $amount, $method = 'qris') {
        $url = self::$baseUrl . '/transactioncreate/' . $method;

        $data = [
            'project'  => PAKASIR_PROJECT_SLUG,
            'order_id' => $orderId,
            'amount'   => (int) $amount,
            'api_key'  => PAKASIR_API_KEY
        ];

        $response = self::request('POST', $url, $data);

        if ($response && isset($response['payment'])) {
            return $response['payment'];
        }

        return false;
    }

    public static function checkStatus($orderId, $amount) {
        $query = http_build_query([
            'project'  => PAKASIR_PROJECT_SLUG,
            'amount'   => (int) $amount,
            'order_id' => $orderId,
            'api_key'  => PAKASIR_API_KEY
        ]);

        $url = self::$baseUrl . '/transactiondetail?' . $query;

        $response = self::request('GET', $url);

        if ($response && isset($response['transaction'])) {
            return $response['transaction'];
        }

        return false;
    }

    private static function request($method, $url, $data = []) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json'
            ]);
        }

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            curl_close($ch);
            return false;
        }

        curl_close($ch);

        return json_decode($result, true);
    }
}
