<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Article;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('contenu')
            // ->add('Enregistrer', SubmitType::class)
            ->add('auteur', EntityType::class, [
                'class' => Auteur::class, 
                'query_builder' => function (EntityRepository $er){
                    return $er->createQueryBuilder('a')
                            ->orderBy('a.nom, a.prenom', 'ASC');
                }, 
                'choice_label' => 'fullName'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
