<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Factory\CategoryFactory;
use App\Factory\CommentFactory;
use App\Factory\ContactFactory;
use App\Factory\PostFactory;
use App\Factory\UserFactory;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        // for($i=0; $i<20; $i++){
        //     $post= new Post();
        //     $post->setTitre('Mon titre'.$i);
        //     $post->setDescription('Mon description'.$i);
        //     $post->setCreatedAT(new DateTime() );
        //     $post->setContenue('Mon contenue'.($i+1));

        //     $manager->persist($post);
        // }

        // $manager->flush();
        UserFactory::createOne();
        
        CategoryFactory::createMany(5);
        
        ContactFactory::createMany(6);

        PostFactory::createMany(10, 
        function(){
            return ['category'=> CategoryFactory::random()];
        });

        CommentFactory::createMany(8, function(){
            return ['user'=>UserFactory::random(),'post'=> PostFactory::random()];
        });





    
      
    }
}
