<?php

namespace App\Service;

use App\Entity\Order;
use App\Repository\PackageRepository;
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
        // $truc = ['treg'],['vedfvq'];
        // dd($packageList);

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

        $statusCode = $response->getStatusCode();
        $contentType = $response->getHeaders()['content-type'][0];
        $content = $response->getContent();
        $content = $response->toArray();

        return $content[0];
    }

    public function createShipment(Order $order)
    {

        // $packageList = $this->selectPackage($order);

        foreach($order->getOrderProducts() as $orderProduct) {

            $product = [
                'appellation' => $orderProduct->getProduct()->getAppellation()->getName(),
                'origin' => $order->getCompany()->getSeller()[0]->getAddresses()[0]->getCountry(),
                // 'description' => $orderProduct->getProduct()->getDescription(),
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
        // $carrier = $this->estimateShippingCosts($order);

        $response = $this->client
        ->request(
            'POST',
            'http://vignoblexport.fr/api/expedition/create',
            ['headers' => [
                'X-AUTH-TOKEN' => $_ENV['VIGNOBLEXPORT_TOKEN'],
            ],
            'body' => [
                // 'expAddress[]' => '',
                'expAddress[addressType]' => 'societe',
                'expAddress[company]' => $order->getCompany()->getName(),
                'expAddress[contact]' => $order->getCompany()->getSeller()[0]->getFullName(),
                'expAddress[phone]' => $order->getCompany()->getSeller()[0]->getAddresses()[0]->getPhoneNumber(),
                'expAddress[address]' => $order->getCompany()->getSeller()[0]->getAddresses()[0]->getStreet(),
                // 'expAddress[address2]' => '',
                'expAddress[postalCode]' => $order->getCompany()->getSeller()[0]->getAddresses()[0]->getZipCode(),
                'expAddress[city]' => $order->getCompany()->getSeller()[0]->getAddresses()[0]->getCity(),
                // 'expAddress[state]' => $order->getCompany()->getSeller()[0]->getAddresses()[0]->getProvince(),
                'expAddress[country]' => $order->getCompany()->getSeller()[0]->getAddresses()[0]->getIso(),
                // 'expAddress[fda]' => '',
                // 'expAddress[eori]' => '',
                'expAddress[notify]' => '0',
                'expAddress[tvaNum]' => $order->getCompany()->getVat(),
                // 'expAddress[acciseNum]' => '',
                // 'expAddress[licenceImportation]' => '',
                'expAddress[email]' => $order->getBuyer()->getEmail(),
                // 'destAddress[]' => '',
                'destAddress[addressType]' => 'particulier',
                // 'destAddress[company]' => '',
                'destAddress[contact]' => $order->getBuyer()->getFullName(),
                // 'destAddress[lastname]' => '',
                // 'destAddress[firstname]' => '',
                'destAddress[phone]' => $order->getBuyer()->getAddresses()[0]->getPhoneNumber(),
                'destAddress[address]' => $order->getBuyer()->getAddresses()[0]->getStreet(),
                // 'destAddress[address2]' => '',
                'destAddress[postalCode]' => $order->getBuyer()->getAddresses()[0]->getZipCode(),
                'destAddress[city]' => $order->getBuyer()->getAddresses()[0]->getCity(),
                'destAddress[country]' => 'FR',
                // 'destAddress[state]' => $order->getBuyer()->getAddresses()[0]->getProvince(),
                // 'destAddress[notify]' => '0',
                // 'destAddress[saveAddress]' => '0',
                // 'destAddress[addressName]' => '',
                // 'destAddress[tvaSociety]' => '',
                // 'destAddress[acciseNum]' => '',
                // 'destAddress[licenceImportation]' => '',
                // 'destAddress[destTax]' => '',
                'destAddress[email]' => $order->getBuyer()->getEmail(),
                // 'packages' => $packageList,
                'packages[0][nb]' => 4,
                'packages[0][weight]' => 20,
                'packages[0][width]' => 50,
                'packages[0][height]' => 40,
                'packages[0][depth]' => 45,
                'packages[1][nb]' => 1,
                'packages[1][weight]' => 10,
                'packages[1][width]' => 27,
                'packages[1][height]' => 40,
                'packages[1][depth]' => 39,
                'carrier[pickupDate]' => '2020-07-28',
                'carrier[name]' => 'dhl',
                'carrier[service]' => 'DHL DOMESTIC EXPRESS',
                'carrier[serviceCode]' => 'N',
                'carrier[price]' => 126.49,
                'carrier[surcharges]' => [],
                'carrier[local]' => 'N',
                'carrier[cutoff]' => '12:00:00',
                'carrier[pickupTime]' => '14:00:00',
                'carrier[deliveryDate]' => '2020-07-29',
                'carrier[deliveryTime]' => '23:59:00',
                'carrier[pickupAccessDelay]' => 120,
                // 'carrier[saturdayDelivery]' => null,
                'details' => $details,
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


        // dd($response);
        $statusCode = $response->getStatusCode();
        // dump($statusCode);
        // $statusCode = 200;
        // die;
        $contentType = $response->getHeaders()['content-type'][0];
        // dd($contentType);
        // $contentType = 'application/json'
        $content = $response->getContent();
        // dd($content);
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();
        // dump($content[0]['price']);
        // dump($content[0]['name']);
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]
        // die;
        return $content;
    }
}