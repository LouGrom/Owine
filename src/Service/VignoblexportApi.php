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
                'expAddress[country]' => 'FR', //TODO
                'destAddress[addressType]' => 'particulier',
                'destAddress[postalCode]' => $order->getBuyer()->getAddresses()[0]->getZipCode(),
                'destAddress[city]' => $order->getBuyer()->getAddresses()[0]->getCity(),
                'destAddress[country]' => 'FR', //TODO
                'packages[0][nb]' => '1', //! TOUT DOUX
                'packages[0][weight]' => '10', //TODO
                'packages[0][width]' => '39', //TODO 
                'packages[0][height]' => '40', //TODO
                'packages[0][depth]' => '27', //TODO
                'pickupDate' => '2020-07-28',  //TODO
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
        // dump($content[0]['name']);
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]
        // die;
        return $content[0];
    }

    public function createShipment(Order $order)
    {

        foreach($order->getOrderProducts() as $orderProduct) {

            $product = [
                'appellation' => $orderProduct->getProduct()->getAppellation()->getName(),
                'origin' => $order->getCompany()->getSeller()[0]->getAddresses()[0]->getCountry(),
                'description' => $orderProduct->getProduct()->getDescription(),
                'capacity' => $orderProduct->getProduct()->getCapacity(),
                'degre' => $orderProduct->getProduct()->getAlcoholVolume(),
                'color' => $orderProduct->getProduct()->getColor()->getName(),
                'hsCode' => $orderProduct->getProduct()->getHsCode(),
                'millesime' => $orderProduct->getProduct()->getVintage(),
                'unitValue' => $orderProduct->getProduct()->getPrice(),
                'quantity' => $orderProduct->getQuantity(),
                'manufacturer' => $orderProduct->getProduct()->getBrand()->getName(),
                'circulation' => 'CRD'
            ];

            $details[] = $product;
        }

        $response = $this->client
        ->request(
            'POST',
            'http://vignoblexport-fr.publish-it.fr/api/expedition/create',
            ['headers' => [
                'X-AUTH-TOKEN' => $_ENV['VIGNOBLEXPORT_TOKEN'],
            ],
            'query' => [
                // 'expAddress[]' => '',
                'expAddress[addressType]' => 'societe',
                'expAddress[company]' => $order->getCompany()->getName(),
                'expAddress[contact]' => $order->getCompany()->getSeller()[0]->getFullName(),
                'expAddress[phone]' => $order->getCompany()[0]->getSeller()->getPhoneNumber(),
                'expAddress[address]' => $order->getCompany()[0]->getSeller()->getAddresses()[0]->getStreet(),
                'expAddress[address2]' => '',
                'expAddress[postalCode]' => $order->getCompany()->getSeller()[0]->getAddresses()[0]->getZipCode(),
                'expAddress[city]' => $order->getCompany()->getSeller()[0]->getAddresses()[0]->getCity(),
                'expAddress[country]' => $order->getCompany()[0]->getSeller()->getAddresses()[0]->getIso(),
                'expAddress[state]' => $order->getCompany()[0]->getSeller()->getAddresses()[0]->getProvince(),
                'destAddress[country]' => $order->getCompany()->getSeller()[0]->getAddresses()[0]->getIso(),
                'expAddress[fda]' => '',
                'expAddress[eori]' => '',
                'expAddress[notify]' => '0',
                'expAddress[tvaNum]' => $order->getCompany()->getVat(),
                'expAddress[acciseNum]' => '',
                'expAddress[licenceImportation]' => '',
                'expAddress[email]' => $order->getBuyer()->getEmail(),
                // 'destAddress[]' => '',
                'destAddress[addressType]' => 'particulier',
                'destAddress[company]' => '',
                'destAddress[contact]' => $order->getBuyer()->getFullName(),
                'destAddress[lastname]' => '',
                'destAddress[firstname]' => '',
                'destAddress[phone]' => $order->getBuyer()->getAddresses()[0]->getPhoneNumber(),
                'destAddress[address]' => $order->getBuyer()->getAddresses()[0]->getStreet(),
                'destAddress[address2]' => '',
                'destAddress[postalCode]' => $order->getBuyer()->getAddresses()[0]->getZipCode(),
                'destAddress[city]' => $order->getBuyer()->getAddresses()[0]->getCity(),
                'destAddress[country]' => $order->getBuyer()->getAddresses()[0]->getIso(),
                'destAddress[state]' => $order->getBuyer()->getAddresses()[0]->getProvince(),
                'destAddress[notify]' => '0',
                'destAddress[saveAddress]' => '0',
                'destAddress[addressName]' => '',
                'destAddress[tvaSociety]' => '',
                'destAddress[acciseNum]' => '',
                'destAddress[licenceImportation]' => '',
                'destAddress[destTax]' => '',
                'destAddress[email]' => $order->getBuyer()->getEmail(),
                'packages[][nb]' => '1', //TODO
                'packages[][weight]' => '10', //TODO
                'packages[][width]' => '39', //TODO
                'packages[][height]' => '40', //TODO
                'packages[][depth]' => '27', //TODO
                'carrier[]' => '',
                'carrier[pickupDate]' => '2020-07-28', //TODO
                'carrier[name]' => '',
                'carrier[service]' => '',
                'carrier[serviceCode]' => '',
                'carrier[price]' => '',
                'carrier[surcharges]' => '',
                'carrier[local]' => '',
                'carrier[cutoff]' => '',
                'carrier[pickupTime]' => '',
                'carrier[deliveryDate]' => '',
                'carrier[deliveryTime]' => '',
                'carrier[pickupAccessDelay]' => '',
                'carrier[saturdayDelivery]' => '',
                'details[]' => $details,
                'insurance' => '0',
                'insurancePrice' => '',
                'emailDutiesTaxes' => '0',
                'totalValue' => $order->getTotalAmount(),
                'instructions' => '', 
                'devise' => 'EUR',
                'detailsType' => 'vente',
                'circulation' => 'CRD',
                'reference' => '',
                'dutiesTaxes' => '',
                'colaAttachments[]' => '',
                'colaAttachments[name]' => '',
                'colaAttachments[file]' => '',
                'champagneAttachments[]' => '',
                'champagneAttachments[name]' => '',
                'champagneAttachments[file]' => '',
                'hourMini' => '10:10:00',
                'hourLimit' => '18:00:00',
                'nbBottles' => $order->getTotalQuantity(),
                'nbMagnums' => '',
                'wineType' => $order->getOrderProducts()[0]->getType(),
                // 'accessPoint[]' => '',
                // 'accessPoint[id]' => '',
                // 'accessPoint[name]' => '',
                // 'accessPoint[addLine1]' => '',
                // 'accessPoint[postal]' => '',
                // 'accessPoint[city]' => '',
                // 'accessPoint[country]' => '',
                // 'repFiscale' => '',
                // 'repFiscaleTvaNum' => '',
                // 'charges[]' => '',
                // 'charges[accises]' => '',
                // 'charges[tva]' => '',
                // 'charges[transport]' => '',
                // 'charges[formalite]' => '',
                // 'charges[taxeEmballage]' => '',
                // 'charges[totalValMarchandise]' => '',
                // 'charges[volumeHL]' => '',
                // 'charges[totalTTCAcciseDest]' => '',
                // 'charges[totalTTCAcciseExp]' => '',
                // 'charges[totalTTCEmballageDest]' => '',
                // 'charges[totalTTCEmballageExp]' => '',
                // 'charges[totalTTCFormaliteDest]' => '',
                // 'charges[totalTTCFormaliteExp]' => '',
                // 'charges[totalTTCMarchandiseDest]' => '',
                // 'charges[totalTTCMarchandiseExp]' => '',
                // 'charges[totalTTCTransportDest]' => '',
                // 'charges[totalTTCTransportExp]' => '',
                // 'hasColaWaiver' => '',
                // 'colaWaiverSupplier' => '',
                // 'noColaWaiver' => '',
                // 'importerColaWaiver[]' => '',
                // 'importerColaWaiver[company]' => '',
                // 'importerColaWaiver[phone]' => '',
                // 'importerColaWaiver[address]' => '',
                // 'importerColaWaiver[additionalAddress]' => '',
                // 'importerColaWaiver[postalCode]' => '',
                // 'importerColaWaiver[city]' => '',
                // 'importerColaWaiver[email]' => '',
                // 'importerColaWaiver[licence]' => '',
                // 'importerColaWaiver[saveAddress]' => ''
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
        // dump($content[0]['name']);
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]
        // die;
        return $content[0];
    }
}