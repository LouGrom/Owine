<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\DeliveryAddress;
use App\Entity\Product;
use App\Entity\ProductCategory;
use App\Entity\ProductBrand;
use App\Entity\Carrier;
use App\Entity\Color;
use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // On configure dans quelle langue nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');


        $seller = new User();
        $buyer = new User();
        $admin = new User();
        
        $seller->setRoles(['ROLE_USER', 'ROLE_SELLER']);
        $buyer->setRoles(['ROLE_USER', 'ROLE_BUYER']);
        $admin->setRoles(['ROLE_USER', 'ROLE_ADMIN']);

        $seller->setCompanyName($faker->company." ".$faker->companySuffix);

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

        $buyer->setAddress($faker->streetAddress);
        $seller->setAddress($faker->streetAddress);
        $admin->setAddress($faker->streetAddress);

        $buyer->setZipCode($faker->postcode);
        $seller->setZipCode($faker->postcode);
        $admin->setZipCode($faker->postcode);

        $buyer->setCity($faker->city);
        $seller->setCity($faker->city);
        $admin->setCity($faker->city);

        $buyer->setCountry($faker->country);
        $seller->setCountry($faker->country);
        $admin->setCountry($faker->country);

        $buyer->setPhoneNumber($faker->phoneNumber);
        $seller->setPhoneNumber($faker->phoneNumber);
        $admin->setPhoneNumber($faker->phoneNumber);

        $seller->setSiretNumber($faker->siret);
        $seller->setVatNumber($faker->vat);
        
        $address = new DeliveryAddress();

        $address->setFirstname($buyer->getFirstname());
        $address->setLastname($buyer->getLastname());
        $address->setAddress($buyer->getAddress());
        $address->setZipCode($buyer->getZipCode());
        $address->setCity($buyer->getCity());
        $address->setCountry($buyer->getCountry());
        $address->setPhoneNumber($buyer->getPhoneNumber());
        $address->setBuyer($buyer);

        $buyer->addDeliveryAddress($address);
        $seller->addDeliveryAddress($address);
        $admin->addDeliveryAddress($address);

        $seller->setCreatedAt($faker->unique()->dateTime($max = 'now', $timezone = null));
        $buyer->setCreatedAt($faker->unique()->dateTime($max = 'now', $timezone = null));
        $userSeller[] = $seller;
        $userBuyer[] = $buyer;

        $manager->persist($buyer);
        $manager->persist($seller);
        $manager->persist($admin);
        $manager->persist($address);
        $manager->flush();


        // On crée 10 personnes et leur adreses de livraison  
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            
            $address = new DeliveryAddress();
            $user->setRoles(['ROLE_USER', $faker->randomElement(array('ROLE_BUYER', 'ROLE_SELLER'))]);
            
            if(in_array("ROLE_SELLER", $user->getRoles())) {
                $user->setCompanyName($faker->company." ".$faker->companySuffix);
            }
            
            $user->setEmail($faker->email);
            $user->setPassword(password_hash("banane", PASSWORD_DEFAULT));
            $user->setFirstname($faker->firstName);
            $user->setLastname($faker->lastName);
            $user->setAddress($faker->streetAddress);
            $user->setZipCode($faker->postcode);
            $user->setCity($faker->city);
            $user->setCountry($faker->country);
            $user->setPhoneNumber($faker->phoneNumber);
            $user->setSiretNumber($faker->siret);
            $user->setVatNumber($faker->vat);
            
            $address->setFirstname($user->getFirstname());
            $address->setLastname($user->getLastname());
            $address->setAddress($user->getAddress());
            $address->setZipCode($user->getZipCode());
            $address->setCity($user->getCity());
            $address->setCountry($user->getCountry());
            $address->setPhoneNumber($user->getPhoneNumber());
            $address->setBuyer($user);
            $user->addDeliveryAddress($address);

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

        // On crée 4 marques
        $brand_name = ['Fabigeon', 'La villageoise', 'Cellier des Dauphins', 'Cambras'];
        for($i = 0; $i < count($brand_name); $i++){

            $brand = new ProductBrand();
            $brand->setName($brand_name[$i]);
            $brand->setSelectionFilter($i);

            // Tableau des objets ProductBrand
            $brandList[] = $brand;

            $manager->persist($brand);
        }
        
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

        // On crée 4 Types
        $type_name = ['Cuit', 'Effervescent', 'Tranquille', 'Crémeux'];
        for($i = 0; $i < count($type_name); $i++){
            $type = new Type();
            $type->setName($type_name[$i]);

            // Tableau des objets ProductCategory
            $typeList[] = $type;
            $manager->persist($type);
        }

        // On crée 5 couleurs
        $color_name = ['Rouge', 'Blanc', 'Rosé', 'Blouge', 'F0F'];
        for($i = 0; $i < count($color_name); $i++){
            $color = new Color();
            $color->setName($color_name[$i]);

            // Tableau des objets ProductCategory
            $colorList[] = $color;
            $manager->persist($color);
        }

        // On crée 50 produits
        for ($i = 0; $i < 50; $i++) {

            $product = new Product();

            $product->setAppellation($faker->departmentName);
            $product->setArea($faker->region);

            $product->setType($faker->randomElement($typeList));

            $product->setCuveeDomaine("Château " . $faker->firstName());
            $product->setCapacity($faker->randomDigit);
            $product->setVintage($faker->numberBetween($min=2000, $max=2020));

            $product->setColor($faker->randomElement($colorList));

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
        
        // On crée 30 commandes
        for ($i = 0; $i < 30; $i++) {

            $total_quantity = 0;
            $total_amount = 0;

            $order = new Order();

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
                $order_product->setProductId($oneProduct);
                $order->setTotalQuantity($total_quantity);
                $order->setTotalAmount($total_amount);
                $order_product->setOrderId($order);
                
                $manager->persist($order_product);
            }
            
            
            $manager->persist($order);
        }
        
        
        $manager->flush(); 
    }
}
