<?php

namespace App\Controller;

use DateTime;
use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article")
     */
    public function showAll(): Response
    {
        $allArticles = $this->getDoctrine()->getRepository(Article::class)->findAll(); 

        // dump($allArticles); 
        // dd(); 

        return $this->render('article/showAll.html.twig', [
            'allArticles' => $allArticles
        ]);
    }

    public function show($id){
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        // dump($article); 
        // dd(); 

        if(!$article){
            throw $this->createNotFoundException("il n'y a aucun article à cet id");
        };

        return $this->render('article/show.html.twig', [
            'article' => $article
        ]);
    }

    public function create(Request $request){
        // on instancie un article pour avoir un objet vide que le formulaire pourra remplir
        $article = new Article(); 

        // on crée un form de type ArticleType et on le lie à notre objet $article
        $form = $this->createForm(ArticleType::class, $article); 

        // on transmet la requete au formulaire pour qu'il ait accès aux données 
        // et on ajoute l'objet Request en paramètre de la méthode create() pour qu'il reconnaisse le $request
        $form->handleRequest($request); 

        // on vérifie que le formulaire a été envoyé et qu'il est valide 
        if($form->isSubmitted() && $form->isValid()){
            // on définit la date car l'utilisateur ne remplira pas la date dans le formulaire donc on récupère 
            // la date et l'heure au moment de l'envoie du formulaire
            
            // $article->setDateCreation(new \DateTime('now')); 

            // récupérer le manager
            $manager = $this->getDoctrine()->getManager(); 
            $manager->persist($article); 
            $manager->flush(); 

            // redirige vers la page de tous les articles 
            return $this->redirectToRoute('monblog_articles_showall');
        }
        
        return $this->render('article/create.html.twig', [
            // on crée la vue du formulaire
            'form' => $form->createView()
        ]); 
    }

    public function update(Request $request, $id){
        $manager = $this->getDoctrine()->getManager(); 

        $article = $manager->getRepository(Article::class)->find($id); 

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request); 

        if($form->isSubmitted() && $form->isValid()){

            $article->setDateCreation(new \DateTime('now'));

            $manager->persist($article); 

            $manager->flush(); 
            
            return $this->redirectToRoute('monblog_articles_showall');

        }

        return $this->render('article/create.html.twig', [
            // on crée la vue du formulaire
            'form' => $form->createView(), 
            'article' => $article
        ]); 
    }

    public function delete($id){
        $manager = $this->getDoctrine()->getManager(); 

        $article = $manager->getRepository(Article::class)->find($id); 

        $manager->remove($article);
        $manager->flush(); 

        return $this->redirectToRoute('monblog_articles_showall'); 
    }
}
