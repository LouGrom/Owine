<?php

namespace App\Controller;

use App\Entity\Company;
use App\Form\CompanyType;
use App\Repository\CompanyRepository;
use App\Repository\DestinationRepository;
use App\Repository\PackageRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/company")
 */
class CompanyController extends AbstractController
{
    /**
     * @Route("/", name="company_list", methods={"GET"})
     */
    public function index(CompanyRepository $companyRepository): Response
    {
        return $this->render('company/list.html.twig', [
            'companies' => $companyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/infos/edit", name="edit_company")
     */
    public function editCompany()
    {
        $formValues = $_POST['company'];
        $company = $this->getUser()->getCompany();

        if(!empty($formValues['name'])) {
            $company->setName($formValues['name']);
        }
        if(!empty($formValues['siret'])) {
            $company->setSiret($formValues['siret']);
        }
        if (!empty($formValues['vat'])) {
            $company->setVat($formValues['vat']);
        }
        if (!empty($formValues['presentation'])) {
            $company->setPresentation($formValues['presentation']);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($company);
        $entityManager->flush();

        $this->addFlash("success", "Les informations de votre entreprise ont bien été modifiées");

        return $this->redirectToRoute('company_profile');
    }

    /**
     * @Route("/profile", name="company_profile", methods={"GET"})
     */
    public function profile(DestinationRepository $destinationRepository, PackageRepository $packageRepository)
    {

        $company = $this->getUser()->getCompany();
        $form = $this->createForm(CompanyType::class, $company);
        // dump($company);
        
        return $this->render('company/profile.html.twig', [
            'destinations' => $destinationRepository->findAll(),
            'packages' => $packageRepository->findAllByBottleQuantity($company->getId()),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/show", name="company_show", methods={"GET"})
     */
    public function sortBySeller(ProductRepository $productRepository, CompanyRepository $companyRepository, $id)
    {
        $company = $companyRepository->find($id);

        $seller = $company->getSeller();
        $sellerId = $seller[0]->getId();
        
        return $this->render('company/show.html.twig', [
            'products' => $productRepository->findAllByCompany($id),
            'company' => $company,
        ]);
    }

    /**
     * @Route("/{id}/delete", name="company_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Company $company): Response
    {
        if ($this->isCsrfTokenValid('delete'.$company->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($company);
            $entityManager->flush();

            $this->addFlash("success","La boutique a bien été supprimée");
        }

        return $this->redirectToRoute('company_index');
    }

}
