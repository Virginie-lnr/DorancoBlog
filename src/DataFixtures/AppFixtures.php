<?php

namespace App\DataFixtures;

use Faker;
use Faker\Factory;
use App\Entity\Auteur;
use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        
        // for($i = 0; $i <10; $i ++){
            // on prend la feuille et on crée un nouvel article avec les propriétés nécessaires
        //     $article = new Article();
        // on remplit les propriétés avec les donnés 
        //     $article
        //         ->setTitre($faker->sentence(6))
        //         ->setContenu($faker->realText(800))
        //         ->setDateCreation(new \DateTime('now'));
        // persit = mettre l'article dans l'enveloppe
        //     $manager->persist($article);
        // }
        // flush = fermer l'enveloppe et l'envoyer 
        // $manager->flush();

        for($i = 0; $i <10; $i ++){
            $auteur = new Auteur();
            $auteur
                ->setNom($faker->lastName())
                ->setPrenom($faker->firstName())
                ->setDateDeNaissance(new \DateTime('now'));
            $manager->persist($auteur);
        }
        $manager->flush();
    }
}
