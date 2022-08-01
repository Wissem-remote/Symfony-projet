<?php

namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class Skills extends AbstractController
{

    /**
     * @Route("/Accesoiries", name="skills.index")
     * @return Response
     */

    public function index()
    {
        return $this->render('skills/index.html.twig',[
            'nav' => 'accesoiries'
        ]);
    }
}