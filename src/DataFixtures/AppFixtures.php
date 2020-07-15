<?php

namespace App\DataFixtures;

use App\Entity\Appellation;
use App\Entity\User;
use App\Entity\Address;
use App\Entity\Product;
use App\Entity\ProductCategory;
use App\Entity\ProductBrand;
use App\Entity\Carrier;
use App\Entity\Color;
use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Entity\Type;
use App\Entity\Company;
use App\Entity\Cart;
use App\Entity\Destination;
use App\Entity\Package;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use Xvladqt\Faker\LoremFlickrProvider;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // On configure dans quelle langue nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');
        $faker->addProvider(new LoremFlickrProvider($faker));

        // ----------------------------------------------------------- Destination -----------------------------------------------------------------

        $countryList= [
            'National' => [
                'France' => 'FR'
            ],
            'Europe' =>[
                'Allemagne' => 'DE',
                'Espagne' => 'ES',
                'Belgique' => 'BE',
                'Royaume-Uni' => 'GB',
                'Finlande' => 'FI'
            ],
            'World' =>[
                'États-Unis' => 'US',
                'Australie' => 'AU',
                'Chine' => 'CN',
                'Corée du Sud' => 'KR',
                'Guatemala' => 'GT'
            ]
        ];

        foreach($countryList as $region => $array) {

            foreach($array as $country => $iso) {

                $destination = new Destination();

                $destination->setZone($region);
                $destination->setCountry($country);
                $destination->setIso($iso);

                $destinationList[] = $destination;

                $manager->persist($destination);
                $manager->flush();
            }
        }

        // --------------------------------------------------------- Seller/Buyer/Admin de test --------------------------------------------
        // On crée un user de chaque role 
        $seller = new User();
        $buyer = new User();
        $admin = new User();
        $company = new Company();
        $buyerAddress = new Address();
        $sellerAddress = new Address();
        $adminAddress = new Address();
        
        
        $seller->setRoles(['ROLE_USER', 'ROLE_SELLER']);
        $buyer->setRoles(['ROLE_USER', 'ROLE_BUYER']);
        $admin->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        
        // On crée une company à notre seller@mail.fr
        $company->setName($faker->company." ".$faker->companySuffix);
        $company->setSiret($faker->siret);
        $company->setVat($faker->vat);
        $company->setPicture($faker->imageUrl(450,275,['wine']));
        $destinations = $faker->randomELements($destinationList, 4);
        foreach ($destinations as $destination) {
            $company->addDestination($destination);
        }
        
        for($i = 0; $i < random_int(3,5); $i++) {

            $package = new Package();

            $package->setBottleQuantity(random_int(1,12));
            $package->setHeight($faker->randomFloat(2, 38, 45));
            $package->setLength($faker->randomFloat(2, 14, 50));
            $package->setWidth($faker->randomFloat(2, 14, 45));
            $package->setWeight($faker->randomFloat(2, 2, 20));

            $company->addPackage($package);
            
            $manager->persist($package);
        }

        // On crée un tableau de paragraphes
        $paragraphs = $faker->paragraphs(3);
        $presentation = "";
        // Puis on prend chaque paragraphe séparemment
        foreach($paragraphs as $text)
        {
            // Pour les concaténer bout à bout dans $presentation
            $presentation = $presentation . $text . "\n";
        }
        // On enregistre ensuite ce texte dans l'objet Company
        $company->setPresentation($presentation);

        $company->setValidated(1);
        $manager->persist($company);

                
        $seller->setCompany($company);

        $seller->setEmail('seller@mail.fr');
        $buyer->setEmail('buyer@mail.fr');
        $admin->setEmail('admin@mail.fr');

        $seller->setPassword(password_hash("banane", PASSWORD_DEFAULT));
        $buyer->setPassword(password_hash("banane", PASSWORD_DEFAULT));
        $admin->setPassword(password_hash("banane", PASSWORD_DEFAULT));

        $buyer->setFirstname($faker->firstName);
        $buyer->setLastname($faker->lastName);

        $seller->setFirstname($faker->firstName);
        $seller->setLastname($faker->lastName);

        $admin->setFirstname($faker->firstName);
        $admin->setLastname($faker->lastName);

        $buyerAddress->setFirstname($buyer->getFirstname());
        $buyerAddress->setLastname($buyer->getLastname());
        $buyerAddress->setZipCode($faker->postcode);
        $buyerAddress->setCity($faker->city);
        $buyerAddress->setCountry($faker->country);
        $buyerAddress->setPhoneNumber($faker->phoneNumber);
        $buyerAddress->setStreet($faker->streetAddress);
        $buyerAddress->setType(['DELIVERY_ADDRESS', 'BILLING_ADDRESS']);
        $buyer->addAddress($buyerAddress);

        $sellerAddress->setFirstname($seller->getFirstname());
        $sellerAddress->setLastname($seller->getLastname());
        $sellerAddress->setZipCode($faker->postcode);
        $sellerAddress->setCity($faker->city);
        $sellerAddress->setCountry($faker->country);
        $sellerAddress->setPhoneNumber($faker->phoneNumber);
        $sellerAddress->setStreet($faker->streetAddress);
        $sellerAddress->setType(['COMPANY_ADDRESS']);
        $seller->addAddress($sellerAddress);

        $adminAddress->setFirstname($admin->getFirstname());
        $adminAddress->setLastname($admin->getLastname());
        $adminAddress->setZipCode($faker->postcode);
        $adminAddress->setCity($faker->city);
        $adminAddress->setCountry($faker->country);
        $adminAddress->setPhoneNumber($faker->phoneNumber);
        $adminAddress->setStreet($faker->streetAddress);
        $admin->addAddress($adminAddress);

        $seller->setCreatedAt($faker->unique()->dateTime($max = 'now', $timezone = null));
        $buyer->setCreatedAt($faker->unique()->dateTime($max = 'now', $timezone = null));
        $admin->setCreatedAt($faker->unique()->dateTime($max = 'now', $timezone = null));
        $userSeller[] = $seller;
        $userBuyer[] = $buyer;

        $manager->persist($buyer);
        $manager->persist($seller);
        $manager->persist($admin);
        $manager->persist($buyerAddress);
        $manager->persist($sellerAddress);
        $manager->persist($adminAddress);
        
        $manager->flush();

        // ------------------------------------------------------------------ User Random ----------------------------------------------------------
        // On crée 30 personnes et leur adreses de livraison  
        for ($i = 0; $i < 30; $i++) {
            $user = new User();
            
            $address = new Address();
            $user->setRoles(['ROLE_USER', $faker->randomElement(array('ROLE_BUYER', 'ROLE_SELLER'))]);
            
            // Si l'utilisateur créé est un SELLER, on lui crée une Company
            if(in_array("ROLE_SELLER", $user->getRoles())) {

                $address->setType(['COMPANY_ADDRESS']);

                $company = new Company();
                        
                $company->setName($faker->company." ".$faker->companySuffix);
                $company->setSiret($faker->siret);
                $company->setVat($faker->vat);
                $company->setValidated(0);
                $company->setPicture($faker->imageUrl(450,275,['wine']));
                $destinations = $faker->randomELements($destinationList, random_int(2,7));
                foreach ($destinations as $destination) {
                    $company->addDestination($destination);
                }
                // On crée un tableau de paragraphes
                $paragraphs = $faker->paragraphs(3);
                $presentation = "";
                // Puis on prend chaque paragraphe séparemment
                foreach($paragraphs as $text)
                {
                    // Pour les concaténer bout à bout dans $presentation
                    $presentation = $presentation . $text . "\n";
                }
                // On enregistre ensuite ce texte dans l'objet Company
                $company->setPresentation($presentation);

                for($j = 0; $j < random_int(3,5); $j++) {

                    $package = new Package();

                    $package->setBottleQuantity(random_int(1,12));
                    $package->setHeight($faker->randomFloat(2, 38, 45));
                    $package->setLength($faker->randomFloat(2, 14, 50));
                    $package->setWidth($faker->randomFloat(2, 14, 45));
                    $package->setWeight($faker->randomFloat(2, 2, 20));

                    $company->addPackage($package);
                    
                    $manager->persist($package);
                }

                $manager->persist($company);

                $user->setCompany($company);
            } else {
                $address->setType(['DELIVERY_ADDRESS','BILLING_ADDRESS']);
            }
            
            $user->setEmail($faker->email);
            $user->setPassword(password_hash("banane", PASSWORD_DEFAULT));
            $user->setFirstname($faker->firstName);
            $user->setLastname($faker->lastName);

            $address->setFirstname($user->getFirstname());
            $address->setLastname($user->getLastname());
            $address->setZipCode($faker->postcode);
            $address->setCity($faker->city);
            $address->setCountry($faker->country);
            $address->setPhoneNumber($faker->phoneNumber);
            $address->setStreet($faker->streetAddress);

            $user->addAddress($address);

            $user->setCreatedAt($faker->unique()->dateTime($max = 'now', $timezone = null));

            // On stock les objets User dans un tableau pour les utiliser plus tard
            if(in_array("ROLE_SELLER", $user->getRoles())){
                $userSeller[] = $user;
            } else {
                $userBuyer[] = $user;
            }

            $manager->persist($user);
            $manager->persist($address);
        }

        // ----------------------------------------------------------- ProductBrand Random -----------------------------------------------------------------
        // On crée 4 marques
        $brand_name = ['Fabigeon', 'La villageoise', 'Cellier des Dauphins', 'Cambras'];
        for($i = 0; $i < count($brand_name); $i++){

            $brand = new ProductBrand();
            $brand->setName($brand_name[$i]);
            $brand->setSelectionFilter($i);
            $brand->setPicture($faker->imageUrl(200,200,['logo']));

            // Tableau des objets ProductBrand
            $brandList[] = $brand;

            $manager->persist($brand);
        }


        // ----------------------------------------------------------- ProductCategory Random -----------------------------------------------------------------
        // On crée 4 categories
        $category_name = ['AOC', 'AOVDQS', 'Vin de pays', 'Vin de table'];
        for($i = 0; $i < count($category_name); $i++){

            $category = new ProductCategory();
            $category->setName($category_name[$i]);
            $category->setSelectionFilter($i);

            // Tableau des objets ProductCategory
            $categoryList[] = $category;

            $manager->persist($category);
        }

        // ----------------------------------------------------------- ProductType Random -----------------------------------------------------------------
        // On crée 4 Types
        $type_name = ['Cuit', 'Effervescent', 'Tranquille', 'Crémeux'];
        for($i = 0; $i < count($type_name); $i++){
            $type = new Type();
            $type->setName($type_name[$i]);

            // Tableau des objets ProductCategory
            $typeList[] = $type;
            $manager->persist($type);
        }

        // ----------------------------------------------------------- Color Random -----------------------------------------------------------------
        // On crée 5 couleurs
        $color_name = ['Rouge', 'Blanc', 'Rosé', 'Blouge', 'F0F'];
        for($i = 0; $i < count($color_name); $i++){
            $color = new Color();
            $color->setName($color_name[$i]);

            // Tableau des objets ProductCategory
            $colorList[] = $color;
            $manager->persist($color);
        }


        // ----------------------------------------------------------- Appellation Random -----------------------------------------------------------------
        // On crée les appellations
        $appellation_name = ['Alsace Edelzwicker', 'Alsace Gewurztraminer', 'Alsace Sylvaner', 'Alsace Grand Cru', 'Alsace Pinot noir'];
        for($i = 0; $i < count($appellation_name); $i++){
            $appellation = new Appellation();
            $appellation->setName($appellation_name[$i]);

            // Tableau des objets appellation
            $appellationList[] = $appellation;
            $manager->persist($appellation);
        }


        // ----------------------------------------------------------- Product Random -----------------------------------------------------------------
        // On crée 100 produits
        for ($i = 0; $i < 100; $i++) {

            $product = new Product();

            $product->setArea($faker->region);
            $product->setAppellation($faker->randomElement($appellationList));

            $product->setType($faker->randomElement($typeList));

            $product->setCuveeDomaine("Château " . $faker->firstName());
            $product->setCapacity($faker->randomElement([500, 750, 1000, 1500]));
            $product->setVintage($faker->numberBetween($min=2000, $max=2020));

            $product->setColor($faker->randomElement($colorList));
            $product->setPicture($faker->imageUrl(450, 275, ['wine'], true));


            $product->setAlcoholVolume($faker->randomFloat(1, 5, 50));
            $product->setPrice($faker->randomFloat(2, 5, 100));
            $product->setHsCode($faker->randomNumber(5));
            $product->setDescription($faker->paragraph(5));
            $product->setStatus($faker->numberBetween(0,1));
            $product->setSeller($userSeller[array_rand($userSeller)]);
            $product->setBrand($brandList[array_rand($brandList)]);
            $product->addCategory($categoryList[array_rand($categoryList)]);
            $product->setStockQuantity($faker->numberBetween(0,1500));
            $user->setCreatedAt($faker->unique()->dateTime($max = 'now', $timezone = null));

            //Tableau des objects ProductList
            $productList[] = $product;

            $manager->persist($product);
        }

        // ----------------------------------------------------------- Carrier Random -----------------------------------------------------------------
        // On crée 7 transporteurs et 3 modes de transport
        $carrier_name = ['TNT', 'Vignoblexport', 'UPS', 'La Poste', 'Colissimo', 'Deliveroo', 'Uber Eat'];
        $carrier_mode=['Brouette', 'Tabouret', 'Fabigeon'];
       
        for($i = 0; $i < count($carrier_name); $i++){

            $carrier = new Carrier();
            $carrier->setName($carrier_name[$i]);
            $carrier->setMode($carrier_mode[array_rand($carrier_mode)]);
            // $carrier_mode[1]  <---- array_rand($carrier_mode) <----- 0-2

            // Tableau des objets carrier
            $carrierList[] = $carrier;

            $manager->persist($carrier);
        }
        
        // ----------------------------------------------------------- Order Random -----------------------------------------------------------------
        // On crée 30 commandes
        for ($i = 0; $i < 30; $i++) {

            $total_quantity = 0;
            $total_amount = 0;

            $order = new Order();

            $order->setReference($faker->bothify('##?###??##?#?'));
            $order->setTrackingNumber($faker->bothify('##?###??##?#?'));
            $order->setBuyer($userBuyer[array_rand($userBuyer)]);
            $order->setCarrier($carrierList[array_rand($carrierList)]);
            $order->setCreatedAt($faker->unique()->dateTime($max = 'now', $timezone = null));
            $order->setStatus(array_rand([0,1]));
            
            // Chaque commande contiendra entre 1 et 5 produits différents
            $nbr_products = random_int(1, 5);
            for ($k = 0; $k <= $nbr_products; $k++) {
                $order_product = new OrderProduct();

                // On ajoute un produit aléatoire parmi ceux existants (qu'on a sauvegardé plus tôt dans un array)
                $oneProduct = $productList[array_rand($productList)];

                // Ces objets sont commandés dans une certaine quantité
                $quantity = random_int(1, 50);
                $order_product->setQuantity($quantity);
                $total_quantity += $quantity;
                $total_amount += $oneProduct->getPrice() * $quantity;
                
                // On ajoute le vendeur du produit à la liste des vendeurs
                $order->addSeller($oneProduct->getSeller());
                $order_product->setProduct($oneProduct);
                $order->setTotalQuantity($total_quantity);
                $order->setTotalAmount($total_amount);
                $order_product->setOrder($order);
                
                $manager->persist($order_product);
            }
            
            
            $manager->persist($order);
        }


        // ----------------------------------------------------------- Cart Random -----------------------------------------------------------------
        // On crée 100 Cart
        for ($i = 0; $i < 100; $i++) {

            $cart = new Cart();
            $oneProduct = $productList[array_rand($productList)];
            $cart->setUser($userBuyer[array_rand($userBuyer)]);
            $cart->setProduct($oneProduct);
            $cart->setQuantity(random_int(1,3600));
            $cart->setTotalAmount($oneProduct->getPrice() * $cart->getQuantity());

            $manager->persist($cart);
        }
        
        
        $manager->flush(); 
    }
}
