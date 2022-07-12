<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', options:[
                "attr"=>["class"=>"form-control-mb4"],
                "label_attr"=>["class"=>"form-label"]
            ])

            ->add('description', options:[
                "attr"=>["class"=>"form-control-mb4"],
                "label_attr"=>["class"=>"form-label"]
            ])

            ->add('contenue', options:[
                "attr"=>["class"=>"form-control-mb4"],
                "label_attr"=>["class"=>"form-label"]
            ])

            ->add('Envoyer', SubmitType::class, options:[
                "attr"=>["class"=>"btn btn-primary text-uppercase disabled"]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
