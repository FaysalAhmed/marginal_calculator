<?php

namespace App\Controller;

use App\Entity\Purchase;
use App\Entity\Sell;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeController extends AbstractController
{
    /**
     * @Route("/", name="welcome")
     */
    public function index()
    {
        // show the welcome page
        // we will have a profit history. we will fetch latest profit from DB.
        //
        $profit = 0;
       return $this->render('welcome/index.html.twig');
    }

    /**
     * @Route("/reset")
     */
    public function resetDB()
    {
        $this->getDoctrine()->getRepository(Purchase::class)->dropAll();
        $this->getDoctrine()->getRepository(Sell::class)->dropAll();
        $this->addFlash('success','Database Reset Complete');
        return $this->redirectToRoute('welcome');
    }
} 