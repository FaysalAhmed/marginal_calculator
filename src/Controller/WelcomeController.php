<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        // show the welcome page
        // we will have a profit history. we will fetch latest profit from DB.
        //
        $profit = 0;
       return $this->render('welcome/index.html.twig');
    }
} 