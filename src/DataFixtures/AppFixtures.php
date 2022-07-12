<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Factory\CategoryFactory;
use App\Factory\PostFactory;
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
        CategoryFactory::createMany(5);

        PostFactory::createMany(10, 
        function(){
            return ['category'=> CategoryFactory::random()];
        });


    
      
    }
}
