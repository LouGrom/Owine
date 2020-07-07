<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BoardController extends AbstractController
{
    /**
     * @Route("/board", name="board")
     */
    public function board()
    {
        return $this->render('board/board.html.twig');
    }
}
