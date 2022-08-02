<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class Home extends AbstractController
{
    private $user;

    public function __construct(UsersRepository $users)
    {
        $this->user = $users;
    }
    
    /**
     * @Route("/", name="home")
     * @return Response
     */

    public function index(ManagerRegistry $doctrine,Request $res): Response
    {
        // on crée un enregistrement dans notre base donnée grace à Doctrine
        // $object = new User;
        // $object->setUsername('Wissem')
        //     ->setEmail('Wissem@live.fr')
        //     ->setArticle('Mon Article')
        //     ->setMessage('Mon Super Message');
        // $em = $doctrine->getManager();
        // $em->persist($object);
        // $em->flush();
        // appeler le repo en utilisant doctrine
        // $info=$doctrine->getRepository(User::class);
        // dump($info);
        $info = $this->user->find(1);
        //dump($info);
        return $this->render('pages/home.html.twig',[
            'nav' => 'acceuil'
        ]);
    }
}