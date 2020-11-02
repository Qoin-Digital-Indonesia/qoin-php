<?php

namespace Qoin;

use GuzzleHttp\Client;
use phpseclib\Crypt\RSA;

class LinkAja
{
    private $isProduction;
    private $privateKey;
    private $secretKey;

    public function __construct($isProduction = false)
    {
        $this->isProduction = $isProduction;
    }

    public function setEnvironment($environment)
    {
        if ($environment == 'production') $this->isProduction = true;

        return $this;
    }

    public function setPrivateKey($privateKey)
    {
        $this->privateKey = $privateKey;

        return $this;
    }

    public function setSecretKey($secretKey)
    {
        $this->secretKey = $secretKey;

        return $this;
    }

    private function generateSignature($plainText)
    {
        $rsa = new RSA;
        $rsa->setHash('sha256');
        $rsa->setSignatureMode(RSA::SIGNATURE_PKCS1);
        $rsa->loadKey($this->privateKey);

        return base64_encode($rsa->sign($plainText));
    }

    public function createOrder($body)
    {
        $endpoint = $this->isProduction
                        ? 'https://dev-apipg.qoin.id/espay-order'
                        : 'https://dev-sandbox-apipg.qoin.id/sandbox/wallet/order';

        $client = new Client(['http_errors' => false]);
        $response = $client->request('POST', $endpoint, [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Signature' => $this->generateSignature(json_encode([
                    'ReferenceNo' => $body['ReferenceNo'],
                    'ReqTime' => $body['ReqTime'],
                    'SecretKey' => $this->secretKey
                ]))
            ],
            'json' => array_merge($body, ['WalletType' => 'LINKAJA'])
        ]);

        return json_decode($response->getBody()->getContents());
    }

    public function getStatus($body)
    {
        $endpoint = $this->isProduction
                        ? 'https://dev-apipg.qoin.id/espay-check-status'
                        : 'https://dev-sandbox-apipg.qoin.id/sandbox/wallet/status';

        $client = new Client(['http_errors' => false]);
        $response = $client->request('POST', $endpoint, [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Signature' => $this->generateSignature(json_encode([
                    'ReferenceNo' => $body['ReferenceNo'],
                    'ReqTime' => $body['RequestTime'],
                    'SecretKey' => $this->secretKey
                ]))
            ],
            'json' => $body
        ]);

        return json_decode($response->getBody()->getContents());
    }
}