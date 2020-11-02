<?php

namespace Qoin;

use GuzzleHttp\Client;
use phpseclib\Crypt\RSA;

class CreditCard
{
    private $isProduction;
    private $privateKey;
    private $secretKey;
    private $referenceNumber;

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

    public function setReferenceNumber($referenceNumber)
    {
        $this->referenceNumber = $referenceNumber;

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
                        ? 'https://dev-apipg.qoin.id/credit-card/create-order'
                        : 'https://dev-sandbox-apipg.qoin.id/sandbox/credit-card/create-order';

        $client = new Client(['http_errors' => false]);
        $response = $client->request('POST', $endpoint, [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Signature' => $this->generateSignature(json_encode([
                    'ReferenceNo' => $body['reference_no'],
                    'ReqTime' => $body['request_time'],
                    'SecretKey' => $this->secretKey
                ]))
            ],
            'json' => $body
        ]);

        return json_decode($response->getBody()->getContents());
    }

    public function charge($body)
    {
        $endpoint = $this->isProduction
                        ? 'https://dev-apipg.qoin.id/credit-card/charge'
                        : 'https://dev-sandbox-apipg.qoin.id/sandbox/credit-card/charge';

        $client = new Client(['http_errors' => false]);
        $response = $client->request('POST', $endpoint, [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Signature' => $this->generateSignature(json_encode(['order_no' => $body['order_no']]))
            ],
            'json' => $body
        ]);

        return json_decode($response->getBody()->getContents());
    }

    public function getStatus($body)
    {
        $endpoint = $this->isProduction
                        ? 'https://dev-apipg.qoin.id/credit-card/status'
                        : 'https://dev-sandbox-apipg.qoin.id/sandbox/credit-card/status';

        $client = new Client(['http_errors' => false]);
        $response = $client->request('POST', $endpoint, [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Signature' => $this->generateSignature(json_encode([
                    'RefNo' => $this->referenceNumber,
                    'ReqTime' => $body['ReqTime'],
                    'SecretKey' => $this->secretKey
                ]))
            ],
            'json' => $body
        ]);

        return json_decode($response->getBody()->getContents());
    }
}