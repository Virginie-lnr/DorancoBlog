<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Form\AuteurType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuteurController extends AbstractController
{
    /**
     * @Route("/auteur", name="auteur")
     */
    public function index(): Response
    {
        return $this->render('auteur/index.html.twig', [
            'controller_name' => 'AuteurController',
        ]);
    }

    /**
     * @Route("/auteur/create", name="monblog_auteur_create")
     */
    public function create(Request $request){
        $auteur = new Auteur(); 

        // créer un nouveau formulaire lié à l'entité Auteur et la variable auteur
        $form = $this->createForm(AuteurType::class, $auteur); 

        // traitement des données 
        $form->handleRequest($request); 

        if($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager(); 
            $manager->persist($auteur); 
            $manager->flush(); 
        }

        return $this->render('auteur/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
