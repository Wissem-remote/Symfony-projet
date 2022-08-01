<?php

namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class Boutique extends AbstractController
{

    /**
     * @Route("/Boutique", name="store.index")
     * @return Response
     */

    public function index()
    {
        return $this->render('store/index.html.twig',[
            'nav' => 'boutique'
        ]);
    }
}