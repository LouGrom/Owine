<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\DeliveryAddress;
use App\Entity\Product;
use App\Entity\ProductCategory;
use App\Entity\ProductBrand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        // On créé 40 personnes
        for ($i = 0; $i < 40; $i++) {
            $user = new User();
            $address = new DeliveryAddress();
            $user->setRole($faker->randomElement(array('buyer', 'seller')));
            if($user->getRole == 'seller') {
                $user->setCompanyName($faker->company()->companySuffix());
            }
            $user->setEmail($faker->email);
            $user->setPassword($faker->numberBetween(10000000, 99999999));

            $user->setFirstname($faker->firstName);
            $address->setFirstname($user->getFirstname);

            $user->setLastname($faker->lastName);
            $address->setLastname($user->getLastname);

            $user->setAddress($faker->streetAddress);
            $address->setAddress($user->getAddress);

            $user->setZipCode($faker->postcode);
            $address->setZipCode($user->getZipCode);

            $user->setCity($faker->city);
            $address->setCity($user->getCity);

            $user->setCountry($faker->country);
            $address->setCountry($user->getCountry);

            $user->setPhoneNumber($faker->phoneNumber);
            $address->setPhoneNumber($user->getPhoneNumber);

            $user->setSiretNumber($faker->siret);
            $user->setVatNumber($faker->vat);

            $address->setBuyer($user);
            $user->setDeliveryAddress($address);

            if($user->getRole == "seller"){
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
            $brandList[] = $brand;

            $manager->persist($brand);
        }

        $category_name = ['AOC', 'AOVDQS', 'Vin de pays', 'Vin de table'];
        for($i = 0; $i < count($category_name); $i++){

            $category = new ProductCategory();
            $category->setName($category_name[$i]);
            $category->setSelectionFilter($i);
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
            $product->setHsCode($faker->randomNumber(15));
            $product->setDescription($faker->paragraph(5));
            $product->setStatus($faker->randomNumber(0,1));
            $product->setSeller(array_rand($userSeller));
            $product->setBrand(array_rand($brandList));
            $product->setCategory(array_rand($categoryList));

            $productList[] = $product;

            $manager->persist($product);
        }

        $manager->flush();
    }
}
