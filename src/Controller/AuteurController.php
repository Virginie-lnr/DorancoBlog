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
            return $this->redirectToRoute('monblog_auteurs_showall');
        }

        return $this->render('auteur/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/auteurs/tous-les-auteurs", name="monblog_auteurs_showall")
     */
    public function showAll(){
        $allAuteurs = $this->getDoctrine()->getRepository(Auteur::class)->findAll(); 
        
        return $this->render('auteur/showAll.html.twig', [
            'allAuteurs' => $allAuteurs
        ]);
    }

    /**
     * @Route("/auteur/{id<\d+>}", name="monblog_auteur_show")
     */
    public function show($id){
        $auteur = $this->getDoctrine()->getRepository(Auteur::class)->find($id);

        return $this->render('auteur/show.html.twig', [
            'auteur' => $auteur
        ]);
    }

    /**
     * @Route("/auteur/mettre-a-jour/{id<\d+>}", name="monblog_auteur_update")
     */
    public function update(Request $request, $id){

        $manager = $this->getDoctrine()->getManager(); 

        $auteur = $manager->getRepository(Auteur::class)->find($id);

        // création d'un formulaire qui récupère les données 
        $form = $this->createForm(AuteurType::class, $auteur); 

        // traitements des données 
        $form->handleRequest($request); 

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($auteur); 
            $manager->flush(); 
            return $this->redirectToRoute('monblog_auteurs_showall');
        }

        return $this->render('auteur/create.html.twig', [
            'form' => $form->createView(),
            'auteur' => $auteur
        ]); 
    }

    /**
     * @Route("/auteur/delete/{id<\d+>}", name="monblog_auteur_delete")
     */
    public function delete($id){
        $manager = $this->getDoctrine()->getManager(); 

        $auteur = $manager->getRepository(Auteur::class)->find($id); 

        $manager->remove($auteur); 
        $manager->flush(); 

        return $this->redirectToRoute('monblog_auteurs_showall'); 
    }
}
