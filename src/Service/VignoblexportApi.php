<?php

namespace App\Service;

use App\Entity\Order;
use App\Repository\PackageRepository;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class VignoblexportApi
{
    private $client;

    private $selectedPackages = null;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function selectPackage(Order $order)
    {
        if ($this->selectedPackages !== null) {
            return $this->selectedPackages;
        }

        $response = $this->client
        ->request(
            'GET',
            'http://vignoblexport-fr.publish-it.fr/api/package/get-sizes',
            ['headers' => [
                'X-AUTH-TOKEN' => $_ENV['VIGNOBLEXPORT_TOKEN'],
            ],
            'query' => [
                'nbBottles' => $order->getTotalQuantity(),
            ]
        ]);

        $statusCode = $response->getStatusCode();

        $contentType = $response->getHeaders()['content-type'][0];
        $content = $response->getContent();
        $content = $response->toArray();

        $packages = $content['packages'];

        // $nbBottlesOfPackage = $packages['nbBottles'];
        // $nbPackages = $packages['nbPackages'];

        $sellerPackages = $order->getCompany()->getPackages();

        // On récupère les nombres de bouteilles que peuvent accueillir les cartons du vendeur
        foreach($sellerPackages as $sellerPackage) {
            $sellerNbBottles[] = $sellerPackage->getBottleQuantity();
        }
        if(empty($sellerNbBottles)){
            $sellerNbBottles = [0];
        }
        $useable = null;

        foreach($packages as $choice) {
            foreach($choice as $nbPacks) {
                // Avant de vérifier un nouveau choice, on initialise $success à true.
                $success = true;
                // Pour chaque choice proposé, on vérifie les formats de carton.
                foreach ($nbPacks as $choiceDetails) {
                    // Si l'un deux n'est pas possédé par le vendeur, on attribue la valeur false à $success
                    // Inversement, si le vendeur possède tous les types de carton demandés pour le choice, $success sera toujours à true
                    if(!in_array($choiceDetails['nbBottles'], $sellerNbBottles)){
                        $success = false;
                    }
                }
                // Arrivé ici, si $success est à true, ça veut dire que le vendeur est capable d'envoyer la commande avec les cartons demandés par le dernier choice
                // Donc on sort de la boucle avec break;
                if($success == true){
                    $useable = $nbPacks;
                    break;
                }
            }
            // Puis on sort de la boucle principale avec un autre break;
            if($success == true){
                break;
            }
        }

        // Par défaut, si le vendeur n'a aucun format de carton compatible on lui envoie le premier choix proposé par l'API (et il se débrouillera tout seul)
        if($success == false) {
            $useable = $packages[0]['choice1'];
        }

        // On prend le poids d'une bouteille de vin tranquille par défaut, on verra plus tard pour du Champagne
        $packageList = null;
        foreach ($useable as $box) {
            $packageList[] = [
                'nb' => $box['nbPackages'],
                'weight' => $box['sizes']['weightVT'],
                'width' => $box['sizes']['width'],
                'height' => $box['sizes']['height'],
                'depth' => $box['sizes']['depth']
            ];
        }

        $this->selectedPackages = $packageList;

        return $packageList;
    }

    public function estimateShippingCosts(Order $order)
    {

        $packageList = $this->selectPackage($order);

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
                'packages' => $packageList,
                'pickupDate' => '2021-03-26',  //TODO
                'hourMini' => '10:10:00',
                'hourLimit' => '18:00:00',
                'nbBottles' => $order->getTotalQuantity(),
                'ups' => '1',
                'dhl' => '1',
                'fedex' => '1',
                'tnt' => '1'
            ]
        ]);

        $statusCode = $response->getStatusCode();
        $contentType = $response->getHeaders()['content-type'][0];
        $content = $response->getContent();
        $content = $response->toArray();

        return $content[0];
    }

    public function createShipment(Order $order, $packageList, $carrierDetails, $commodityDetails)
    {

        $response = $this->client
        ->request(
            'POST',
            'http://vignoblexport-fr.publish-it.fr/api/expedition/create',
            ['headers' => [
                'Content-Type' => 'application/json',
                'X-AUTH-TOKEN' => $_ENV['VIGNOBLEXPORT_TOKEN'],
            ],
            'json' => [
                'expAddress' => [
                    'addressType' => 'societe',
                    'company' => $order->getCompany()->getName(),
                    'contact' => $order->getCompany()->getSeller()[0]->getFullName(),
                    'phone' => $order->getCompany()->getSeller()[0]->getAddresses()[0]->getPhoneNumber(),
                    'address' => $order->getCompany()->getSeller()[0]->getAddresses()[0]->getStreet(),
                    'address2' => '',
                    'postalCode' => $order->getCompany()->getSeller()[0]->getAddresses()[0]->getZipCode(),
                    'city' => $order->getCompany()->getSeller()[0]->getAddresses()[0]->getCity(),
                    'state' => $order->getCompany()->getSeller()[0]->getAddresses()[0]->getProvince(),
                    'country' => $order->getCompany()->getSeller()[0]->getAddresses()[0]->getIso(),
                    'fda' => '',
                    'eori' => '',
                    'notify' => '0',
                    'tvaNum' => $order->getCompany()->getVat(),
                    'acciseNum' => '',
                    'licenceImportation' => '',
                    'email' => $order->getCompany()->getSeller()[0]->getEmail(),
                ],
                'destAddress' => [
                    'addressType' => 'particulier',
                    'company' => '',
                    'contact' => $order->getBuyer()->getFullName(),
                    'lastname' => '',
                    'firstname' => '',
                    'phone' => $order->getBuyer()->getAddresses()[0]->getPhoneNumber(),
                    'address' => $order->getBuyer()->getAddresses()[0]->getStreet(),
                    'address2' => '',
                    'postalCode' => $order->getBuyer()->getAddresses()[0]->getZipCode(),
                    'city' => $order->getBuyer()->getAddresses()[0]->getCity(),
                    'country' => 'FR',
                    'state' => $order->getBuyer()->getAddresses()[0]->getProvince(),
                    'notify' => '0',
                    'saveAddress' => '0',
                    'addressName' => '',
                    'tvaSociety' => '',
                    'acciseNum' => '',
                    'licenceImportation' => '',
                    'destTax' => '',
                    'email' => $order->getBuyer()->getEmail(),
                ],
                'packages' => $packageList,
                'carrier' => $carrierDetails,
                'details' => $commodityDetails,
                'insurance' => '0',
                // 'insurancePrice' => '',
                'emailDutiesTaxes' => '0',
                'totalValue' => $order->getTotalAmount(),
                // 'instructions' => '', 
                'devise' => 'EUR',
                'detailsType' => 'vente',
                'circulation' => 'CRD',
                // 'reference' => '',
                // 'dutiesTaxes' => '',
                // 'colaAttachments[]' => '',
                // 'colaAttachments[name]' => '',
                // 'colaAttachments[file]' => '',
                // 'champagneAttachments[]' => '',
                // 'champagneAttachments[name]' => '',
                // 'champagneAttachments[file]' => '',
                'hourMini' => '10:10:00',
                'hourLimit' => '18:00:00',
                'nbBottles' => $order->getTotalQuantity(),
                // 'nbMagnums' => '',
                'wineType' => 'tranquille',
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

        $decodedPayload = $response->toArray();
        // dd($decodedPayload);

        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]
        // dump($content);

        // dd($response);
        // $statusCode = $response->getStatusCode();
        // // dump($statusCode);
        // // $statusCode = 200;
        // // die;
        // $contentType = $response->getHeaders()['content-type'][0];
        // // dd($contentType);
        // // $contentType = 'application/json'
        // $content = $response->getContent();
        // // dd($content);
        // // $content = '{"id":521583, "name":"symfony-docs", ...}'
        // $content = $response->toArray();
        // // dump($content[0]['price']);
        // // dump($content[0]['name']);
        // // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]
        // // die;



        return $content;
    }

    public function getShippingLabel(Order $order)
    {

        $response = $this->client
        ->request(
            'GET',
            'http://vignoblexport-fr.publish-it.fr/api/expedition/get-label',
            ['headers' => [
                'X-AUTH-TOKEN' => $_ENV['VIGNOBLEXPORT_TOKEN'],
            ],
            'query' => [
                'expeditionId' => $order->getReference(),
            ]
        ]);

        $statusCode = $response->getStatusCode();
        $contentType = $response->getHeaders()['content-type'][0];
        $content = $response->getContent();
        $content = $response->toArray();
             


        return $content['directLink'];
    }
}