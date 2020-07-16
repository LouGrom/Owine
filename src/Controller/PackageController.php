<?php

namespace App\Controller;

use App\Repository\PackageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/destination")
 */
class PackageController extends AbstractController
{
    /**
     * @Route("/{id}/add", name="add_package")
     */
    public function addDestination($id, PackageRepository $packageRepository)
    {
        $package = $packageRepository->find($id);
        $company = $this->getUser()->getCompany();
        $company->addDestination($package);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
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
