<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    private CategoryRepository $repo;
    public function __construct(CategoryRepository $repo)
    {
        $this->repo = $repo;
    }

    #[ROUTE('/category', name:'category.index')]
    public function index(): Response
    {
        $categories=$this->repo->findAll();
        return $this->render('category/index.html.twig', ['categories'=>$categories]);
    }


    // ajouter category
    #[ROUTE('/category/create', name: 'category.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $category = new Category();
        $form=$this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->repo->add($category, true);
            return $this->redirect('/');
        }
        return $this->renderForm('category/create.html.twig', ['form'=>$form, 'category'=>$category]);
    }

    #[ROUTE('/category/{id}', name: 'category.show', methods: ['GET'])]
    public function show($id): Response
    {
        $category = $this->repo->find($id);
        $posts = $category->getPost();
        return $this->render('/category/show.html.twig', ['posts' => $posts, 'category' => $category]);
    }

    // delete
    #[ROUTE('/category/delete/{id}', name: 'category.delete', methods: ['POST'])]
    public function delete($id)
    {
        $category = $this->repo->find($id);
        $posts = $category->getPost();

        // methode isEmpty pour verifier si la category ne contient pas de post
        // si la category ne contient pas de post on l'a suprime
        if ($posts->isEmpty()) {
            $this->repo->remove($category, true);
        }
        return $this->redirect('/');
    }

}
