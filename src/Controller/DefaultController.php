<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepage()
    {
        return $this->render('default/homepage.html.twig');
    }

    /**
     * @Route("/legal-mentions", name="legal_mentions")
     */
    public function legal()
    {
        return $this->render('default/legal_mentions.html.twig');
    }
}
