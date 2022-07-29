<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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

            ->add('Category', EntityType::class, [
                "class" => Category::class,
                "choice_label" => "name"// choice_label correspond au nom de chacun de mes choix
            ])

            ->add('description', options:[
                "attr"=>["class"=>"form-control-mb4"],
                "label_attr"=>["class"=>"form-label"]
            ])

            ->add('contenue', options:[
                "attr"=>["class"=>"form-control-mb4"],
                "label_attr"=>["class"=>"form-label"]
            ])

            ->add('ImageFileName', FileType::class,  options:[
                "attr"=>["class"=>"form-control-mb4"]
            ])

            ->add('Envoyer', SubmitType::class, options:[
                "attr"=>["class"=>"btn btn-primary text-uppercase"]
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
