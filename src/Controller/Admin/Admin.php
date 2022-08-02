<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;

class Admin extends AbstractController
{
    private $user;

    public function __construct(ArticleRepository $users)
    {
        $this->user = $users;
    }
    
    
    #[Route("/admin", name:"admin" )]
    

    public function index(ManagerRegistry $doctrine,): Response
    {

        $info = $this->user->findAll();
        //dump($info);
        
        return $this->render('admin/admin.html.twig',[
            'nav' => 'Admin',
            'infos' => array_reverse($info)
            ]);
    }

    /**
     * @Route("/admin/add", name="admin.add")
     * @return Response
     */

    public function addArtcle(ManagerRegistry $doctrine, Request $request,  SluggerInterface $slugger): Response
    {

        $info = $this->user->findAll();
        //dump($info);
        // on fait passer notre class Article #table
        $article = new Article;
        // on crée notre formulaire grace Article en lui donnant comme Image notre class Article
        $form = $this->createForm(ArticleType::class,$article);
        // on fait passser nos information passer en post en POST 
        $form->handleRequest($request);
        // onn test si notre formulaire est Submit
        if($form->isSubmitted()){
            $brochureFile = $form->get('image')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
                if ($brochureFile) {
                        $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                        // this is needed to safely include the file name as part of the URL
                        $safeFilename = $slugger->slug($originalFilename);
                        $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                        // Move the file to the directory where brochures are stored
                        try {
                            $brochureFile->move(
                                $this->getParameter('article_image'),
                                $newFilename
                            );
                        } catch (FileException $e) {
                            // ... handle exception if something happens during file upload
                        }

                        // updates the 'brochureFilename' property to store the PDF file name
                        // instead of its contents
                            $article->setImage($newFilename);
                }
                $entityManager = $doctrine->getManager();
                $entityManager->persist($article);
                $entityManager->flush();
                return $this->redirectToRoute('admin',['info' => 'success']);
        }

        return $this->render('admin/add.html.twig',[
            'nav' => 'add',
            'form' => $form->createView()
        ]);
    }
    #[Route("/admin/edit/{id?O}", name:"admin.edit" )]

    public function editArtcle(Article $article = null, ManagerRegistry $doctrine, Request $request,$id): Response
    {

        $info = $this->user->findAll();
        //dump($info);
        // on check si article est egale a null on l'instancie à zero
        if(!$article){
              // on fait passer notre class Article #table
            $article = new Article;
        }
      
       
        // on crée notre formulaire grace Article en lui donnant comme Image notre class Article
        $form = $this->createForm(ArticleType::class,$article);
        // on fait passser nos information passer en post en POST 
        $form->handleRequest($request);
        // onn test si notre formulaire est Submit
        if($form->isSubmitted()){
                $entityManager = $doctrine->getManager();
                $entityManager->persist($article);
                $entityManager->flush();
                return $this->redirectToRoute('admin',['update' => 'success']);
        }

        return $this->render('admin/add.html.twig',[
            'nav' => 'add',
            'form' => $form->createView()
        ]);
    }

    #[Route("/admin/delete/{id?O}", name:"admin.delete" )]

    public function deleteArtcle(Article $article = null, ManagerRegistry $doctrine, Request $request,$id): Response
    {
        if(!$article){
            // on fait passer notre class Article #table
            return $this->redirectToRoute('admin');
        }
        if($article->getImage() != null){
            $filesystem = new Filesystem();
            $projectDir = $this->getParameter('kernel.project_dir');
            $filesystem->remove($projectDir.'/public/uploads/article/'.$article->getImage());
        }
        $entityManager = $doctrine->getManager();
        $entityManager->remove($article);
        $entityManager->flush();
        return $this->redirectToRoute('admin',['delete' => 'success']);
    }
}