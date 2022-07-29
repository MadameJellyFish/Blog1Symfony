<?php

namespace App\Controller;

use App\Entity\Like;
use App\Repository\LikeRepository;
use App\Repository\PostRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class LikeController extends AbstractController
{   
    
    private PostRepository $pRepo;
    private LikeRepository $lRepo;
    public function __construct(PostRepository $pRepo, LikeRepository $lRepo)
    {
        $this->pRepo = $pRepo;
        $this->lRepo = $lRepo;
    }


    #[Route('/like', name: 'app_like')]
    public function index(): Response
    {
        return $this->render('like/index.html.twig', [
            'controller_name' => 'LikeController',
        ]);
    }

    #[ROUTE('/like/create/{postId}', name:'like.create')]
    public function create($postId, Request $request): Response
    {   
    // dd('ici');
        $post = $this->pRepo->find($postId);
        $like = $this->lRepo->findOneBy(['post'=>$post, 'user'=>$this->getUser()]);
        // dd($like);
        if ($like==null) {
            // ajout
            $like = new Like;
            $like->setUser($this->getUser());
            $like->setPost($post);

            $this->lRepo->add($like, true);
        }else{
            // delete like
            $this->lRepo->remove($like, true);
        }
    
        $nbLikes = count($post->getLikes());
        return $this->json(['nbLikes'=>$nbLikes]);
        // data est nbLikes en js
        

    }
}
