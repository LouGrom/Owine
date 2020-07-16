<?php

namespace App\Controller;

use App\Repository\DestinationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/destination")
 */
class DestinationController extends AbstractController
{
    /**
     * @Route("/{id}/add", name="add_destination")
     */
    public function addDestination($id, DestinationRepository $destinationRepository)
    {
        $destination = $destinationRepository->find($id);
        $company = $this->getUser()->getCompany();
        $company->addDestination($destination);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

    }

    /**
     * @Route("/{id}/remove", name="remove_destination")
     */
    public function removeDestination($id, DestinationRepository $destinationRepository)
    {
        $destination = $destinationRepository->find($id);
        $company = $this->getUser()->getCompany();
        $company->removeDestination($destination);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
    }
}
