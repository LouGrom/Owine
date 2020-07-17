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
        $entityManager = $this->getDoctrine()->getManager();
        $packageDatas = explode('-', $packageDatas);
        $packageId = $packageDatas[0];
        $quantity = $packageDatas[1];
        $height =  $packageDatas[2];
        $length = $packageDatas[3];
        $width = $packageDatas[4];
        $weight = $packageDatas[5];        
        
        $package = new Package();
        // On peut récupérer l'utilisateur courant avec $this->getUser()
        $company = $this->getUser()->getCompany();

        // On vérifie qu'un format de carton n'existe pas déjà dans le profil de l'utilisateur
        $result = $packageRepository->findExistingPackage($company->getId(), $packageId);
        
        //Si un format de carton existe déjà, alors on récupère le premier résultat
        if (isset($result[0])) {
            $package = $result[0];
            $allPackages = $packageRepository->findAll();
            foreach($allPackages as $onePackage) {
                if($quantity == $onePackage->getBottleQuantity() && $package->getId() != $onePackage->getId()) {
                    return $this->addFlash("danger", "Le format de carton existe déjà !");
                }
            }
        } else {
            $allPackages =$packageRepository->findAll();
            foreach($allPackages as $onePackage) {
                if($quantity == $onePackage->getBottleQuantity()) {
                    return $this->addFlash("danger", "Le format de carton existe déjà !");
                }
            }
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
        $company->removePackage($package);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        $this->addFlash("success", "Le format de carton a bien été supprimé de vos préférences d'expédition !");
        return new JsonResponse(Response::HTTP_OK);
    }
}
