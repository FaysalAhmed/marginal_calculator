<?php

namespace App\Controller;

use App\Entity\Inventory;
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
        $profit = $this->getDoctrine()->getRepository(Sell::class)->getTotalProfit();

        return $this->render('welcome/index.html.twig',['profit'=>$profit['profit']]);
    }

    /**
     * @Route("/reset")
     */
    public function resetDB()
    {
        $this->getDoctrine()->getRepository(Inventory::class)->dropAll();
        $this->getDoctrine()->getRepository(Sell::class)->dropAll();
        $this->addFlash('success','Database Reset Complete');
        return $this->redirectToRoute('welcome');
    }
} 