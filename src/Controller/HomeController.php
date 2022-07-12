<?php

namespace App\Controller;

use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

#[ROUTE('/home/about', name:'home.about')]
public function about():Response
{
    return $this->render('home/about.html.twig');
}


#[ROUTE('/contact', name:'home.contact')]
public function contact(): Response
{
    return $this->render('contact.html.twig');
}

}
