<?php

namespace App\Service;

use App\Entity\Order;
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
        // On récupère les formats de cartons que le vendeur a renseigné dans son profil
        $sellerPackages = $order->getCompany()->getPackages();
        // on boucle sur ces formats pour les lister dans un tableau en fonction du nb de btles
        foreach($sellerPackages as $sellerPackage) {
            $sellerNbBottles[] = $sellerPackage->getBottleQuantity();
        }
        if(empty($sellerNbBottles)){
            $sellerNbBottles = [0];
        }
        $useable = null;
        // On récupère alors les réponses que nous a retourné l'API en fonction du nombre de bouteilles de la commande
        // L'API va nous retourner plusieurs choix sur lesquels nous allons pouvoir boucler
        foreach($packages as $choice) {
            // On va examiner chacun de ces choix pour vérifier si cela correspond aux formats de cartons dont le vendeur dispose
            foreach($choice as $nbPacks) {
                // Avant de vérifier un nouveau choice, on initialise $success à true.
                $success = true;
                // Pour chaque choice proposé, on vérifie les formats de carton.
                foreach ($nbPacks as $choiceDetails) {
                    // Pour chaque format de cartons dont le vendeur ne dispose pas,
                    // on attribue la valeur false à $success
                    if(!in_array($choiceDetails['nbBottles'], $sellerNbBottles)){
                        $success = false;
                    }
                }
                // Dès que $success passe à true, c'est que le vendeur dispose 
                // du/des formats de cartons du choice
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
        // Si le vendeur n'a aucun format de carton compatible 
        // on désigne par défaut le premier choix proposé par l'API
        if($success == false) {
            $useable = $packages[0]['choice1'];
        }
        // On considère le poids d'une bouteille de vin tranquille par défaut
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
                    'postalCode' => $order->getCompany()->getSeller()[0]->getAddresses()[0]->getZipCode(),
                    'city' => $order->getCompany()->getSeller()[0]->getAddresses()[0]->getCity(),
                    'state' => $order->getCompany()->getSeller()[0]->getAddresses()[0]->getProvince(),
                    'country' => $order->getCompany()->getSeller()[0]->getAddresses()[0]->getIso(),
                    'tvaNum' => $order->getCompany()->getVat(),
                    'email' => $order->getCompany()->getSeller()[0]->getEmail(),
                ],
                'destAddress' => [
                    'addressType' => 'particulier',
                    'contact' => $order->getBuyer()->getFullName(),
                    'phone' => $order->getBuyer()->getAddresses()[0]->getPhoneNumber(),
                    'address' => $order->getBuyer()->getAddresses()[0]->getStreet(),
                    'postalCode' => $order->getBuyer()->getAddresses()[0]->getZipCode(),
                    'city' => $order->getBuyer()->getAddresses()[0]->getCity(),
                    'country' => 'FR',
                    'state' => $order->getBuyer()->getAddresses()[0]->getProvince(),
                    'email' => $order->getBuyer()->getEmail(),
                ],
                'packages' => $packageList,
                'carrier' => $carrierDetails,
                'details' => $commodityDetails,
                'insurance' => '0',
                'emailDutiesTaxes' => '0',
                'totalValue' => $order->getTotalAmount(),
                'devise' => 'EUR',
                'detailsType' => 'vente',
                'circulation' => 'CRD',
                'hourMini' => '10:10:00',
                'hourLimit' => '18:00:00',
                'nbBottles' => $order->getTotalQuantity(),
                'wineType' => 'tranquille',
            ]
        ]);
        $statusCode = $response->getStatusCode();
        $contentType = $response->getHeaders()['content-type'][0];
        $content = $response->getContent();
        $content = $response->toArray();
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