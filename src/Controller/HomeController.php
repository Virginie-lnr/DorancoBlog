<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index(): Response
    {
        // $val = array(
        //     'prenom' => 'Virginie',
        //     'nom' => 'Lenoir',
        //     'age' => 26
        // );

        // return $this->render('home/main.html.twig', [
        //     'valeur' => $val
        // ]);

        // $em = $this->getDoctrine()->getManager();

        // $dernierArticle = $em->getRepository(Article::class)->findOneBy([], ['dateCreation' => 'DESC']);

        $dernierArticle = $this->getDoctrine()->getRepository(Article::class)->findOneBy([], ['dateCreation' => 'DESC']); 

        // dump($dernierArticle); 
        // dd(); 
        
        return $this->render('home/main.html.twig', [
            'dernierArticle' => $dernierArticle
        ]);
    }
}
