<?php

namespace Nishadil\SocialPostman\Core;

class HttpClient
{
    public function post(
        string $url,
        array $headers,
        array|string $payload,
        bool $multipart = false
    ): HttpResponse {
        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $multipart
                ? $payload
                : (is_array($payload) ? json_encode($payload) : $payload),
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => 30
        ]);

        $body = curl_exec($ch);
        $error = curl_error($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return new HttpResponse($status, $body, $error);
    }
}
