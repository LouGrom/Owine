<?php

namespace App\Controller;

use App\Entity\Package;
use App\Repository\PackageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/package")
 */
class PackageController extends AbstractController
{
    /**
     * @Route("/{packageDatas}/add", name="add_package")
     */
    public function addPackage($packageDatas, PackageRepository $packageRepository)
    {
        $packageDatas = explode('-', $packageDatas);
        $quantity = $packageDatas[0];
        $height =  $packageDatas[1];
        $length = $packageDatas[2];
        $width = $packageDatas[3];
        $weight = $packageDatas[4];        
        
        $package = new Package();
        $entityManager = $this->getDoctrine()->getManager();
        // On peut récupérer l'utilisateur courant avec $this->getUser()
        $company = $this->getUser()->getCompany();

        // On vérifie qu'un format de carton n'existe pas déjà dans le profil de l'utilisateur
        $result = $packageRepository->findExistingPackage($company->getId(), $quantity);
        
        //Si un format de carton existe déjà, alors on récupère le premier résultat
        if (isset($result[0])) {
            $package = $result[0];
        }
            $package->setBottleQuantity($quantity);
            $package->setHeight($height);
            $package->setLength($length);
            $package->setWidth($width);
            $package->setWeight($weight);

        $entityManager->persist($package);
        
        $company->addPackage($package);
        $entityManager->flush();

        $this->addFlash("success","Le format de carton a bien été ajouté à vos préférences d'expédition !");
        return new JsonResponse(Response::HTTP_OK);
    }

    /**
     * @Route("/{id}/remove", name="remove_package")
     */
    public function removeDestination($id, PackageRepository $packageRepository)
    {
        $package = $packageRepository->find($id);
        $company = $this->getUser()->getCompany();
        $company->removeDestination($package);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
    }
}
