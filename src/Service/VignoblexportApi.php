<?php

namespace App\Service;

use App\Entity\Order;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class VignoblexportApi
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function estimateShippingCosts(Order $order)
    {
        $response = $this->client
        ->request(
            'GET',
            'http://vignoblexport-fr.publish-it.fr/api/expedition/get-rates',
            ['headers' => [
                'X-AUTH-TOKEN' => $_ENV['VIGNOBLEXPORT_TOKEN'],
            ],
            'query' => [
                'expAddress[addressType]' => 'societe',
                'expAddress[postalCode]' => $order->getCompany()->getSeller()[0]->getAddresses()[0]->getZipCode(),
                'expAddress[city]' => $order->getCompany()->getSeller()[0]->getAddresses()[0]->getCity(),
                'expAddress[country]' => 'FR',
                'destAddress[addressType]' => 'particulier',
                'destAddress[postalCode]' => $order->getBuyer()->getAddresses()[0]->getZipCode(),
                'destAddress[city]' => $order->getBuyer()->getAddresses()[0]->getCity(),
                'destAddress[country]' => 'FR',
                'packages[0][nb]' => '1',
                'packages[0][weight]' => '10',
                'packages[0][width]' => '39',
                'packages[0][height]' => '40',
                'packages[0][depth]' => '27',
                'pickupDate' => '2020-07-28',
                'hourMini' => '10:10:00',
                'hourLimit' => '18:00:00',
                'nbBottles' => $order->getTotalQuantity(),
                'ups' => '1',
                'dhl' => '1',
                'fedex' => '1',
                'tnt' => '1'
            ]
        ]);


        // dump($response);
        $statusCode = $response->getStatusCode();
        // dump($statusCode);
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // dump($contentType);
        // $contentType = 'application/json'
        $content = $response->getContent();
        // dump($content);
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();
        // dump($content[0]['price']);
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]
        // die;
        return $content[0];
    }
}