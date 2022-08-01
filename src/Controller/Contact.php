<?php

namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class Contact extends AbstractController
{

    /**
     * @Route("/Contact", name="contact")
     * @return Response
     */

    public function index()
    {
        return $this->render('pages/contact.html.twig',[
            'nav' => 'contact'
        ]);
    }
}