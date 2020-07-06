<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\DeliveryAddress;
use App\Entity\Product;
use App\Entity\ProductCategory;
use App\Entity\ProductBrand;
use App\Entity\Carrier;
use App\Entity\Order;
use App\Entity\OrderProduct;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // On configure dans quelle langue nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        // On crée 40 personnes et leur adreses de livraison  
        for ($i = 0; $i < 40; $i++) {
            $user = new User();
            $address = new DeliveryAddress();
            $user->setRole($faker->randomElement(array('buyer', 'seller')));
            
            if($user->getRole() == 'seller') {
                $user->setCompanyName($faker->company." ".$faker->companySuffix);
            }
            
            $user->setEmail($faker->email);
            $user->setPassword($faker->numberBetween(500,1000));

            $user->setFirstname($faker->firstName);
            $address->setFirstname($user->getFirstname());

            $user->setLastname($faker->lastName);
            $address->setLastname($user->getLastname());

            $user->setAddress($faker->streetAddress);
            $address->setAddress($user->getAddress());

            $user->setZipCode($faker->postcode);
            $address->setZipCode($user->getZipCode());

            $user->setCity($faker->city);
            $address->setCity($user->getCity());

            $user->setCountry($faker->country);
            $address->setCountry($user->getCountry());

            $user->setPhoneNumber($faker->phoneNumber);
            $address->setPhoneNumber($user->getPhoneNumber());

            $user->setSiretNumber($faker->siret);
            $user->setVatNumber($faker->vat);

            $address->setBuyer($user);
            $user->addDeliveryAddress($address);

            $user->setCreatedAt($faker->unique()->dateTime($max = 'now', $timezone = null));
            $user->setUpdatedAt($faker->unique()->dateTime($max = 'now', $timezone = null));

            // On stock les objets User dans un tableau pour les utiliser plus tard
            if($user->getRole() == "seller"){
                $userSeller[] = $user;
            } else {
                $userBuyer[] = $user;
            }

            $manager->persist($user);
            $manager->persist($address);
        }

        
        $brand_name = ['Fabigeon', 'La villageoise', 'Cellier des Dauphins', 'Cambras'];
        for($i = 0; $i < count($brand_name); $i++){

            $brand = new ProductBrand();
            $brand->setName($brand_name[$i]);
            $brand->setSelectionFilter($i);

            // Tableau des objets ProductBrand
            $brandList[] = $brand;

            $manager->persist($brand);
        }

        $category_name = ['AOC', 'AOVDQS', 'Vin de pays', 'Vin de table'];
        for($i = 0; $i < count($category_name); $i++){

            $category = new ProductCategory();
            $category->setName($category_name[$i]);
            $category->setSelectionFilter($i);

            // Tableau des objets ProductCategory
            $categoryList[] = $category;

            $manager->persist($category);
        }

        for ($i = 0; $i < 50; $i++) {

            $product = new Product();

            $product->setAppellation($faker->departmentName);
            $product->setArea($faker->region);
            $product->setType($faker->randomElement(array('cuit', 'effervescent', 'tranquille', 'crémeux')));
            $product->setCuveeDomaine("Château " . $faker->firstName());
            $product->setCapacity($faker->randomDigit);
            $product->setVintage($faker->numberBetween($min=2000, $max=2020));
            $product->setColor($faker->randomElement(array('Rouge', 'Blanc', 'Rosé', 'Blouge', 'F0F')));
            $product->setAlcoholVolume($faker->randomFloat(1, 5, 50));
            $product->setPrice($faker->randomFloat(1));
            $product->setHsCode($faker->randomNumber(5));
            $product->setDescription($faker->paragraph(5));
            $product->setStatus($faker->numberBetween(0,1));
            $product->setSeller($userSeller[array_rand($userSeller)]);
            $product->setBrand($brandList[array_rand($brandList)]);
            $product->addCategory($categoryList[array_rand($categoryList)]);
            $product->stockQuantity($faker->numberBetween(0,1500));
            $user->setCreatedAt($faker->unique()->dateTime($max = 'now', $timezone = null));

            //Tableau des objects ProductList
            $productList[] = $product;

            $manager->persist($product);
        }


        $carrier_name = ['TNT', 'Vignoblexport', 'UPS', 'La Poste', 'Colissimo', 'Deliveroo', 'Uber Eat'];
        $carrier_mode=['Brouette', 'Tabouret', 'Fabigeon'];
       
        for($i = 0; $i < count($carrier_name); $i++){

            $carrier = new Carrier();
            $carrier->setName($carrier_name[$i]);
            $carrier->setMode($carrier_mode[array_rand($carrier_mode)]);
            // $carrier_mode[1]  <---- array_rand($carrier_mode) <----- 0-2

            // Tableau des objets carrier
            $carrier[] = $carrier;

            $manager->persist($carrier);
        }
        
        for ($i = 0; $i < 15; $i++) {

            $total_quantity = 0;
            $total_amount = 0;

            $order = new Order();

            $order->setTrackingNumber($faker->bothify('##?###??##?#?'));

            $order->setBuyer($userBuyer[array_rand($userBuyer)]);

            $nbr_products = random_int(1, 5);
            for ($k = 0; $k <= $nbr_products; $k++) {
                $order_product = new OrderProduct();

                $quantity = random_int(1,50);

                $order->addProduct($productList[array_rand($productList)]);
                
            }

            $order->setBuyer($faker->unique()->dateTime($max = 'now', $timezone = null));

            // $order->setSeller()

        }
        
        
        $manager->flush(); 
    }
}
