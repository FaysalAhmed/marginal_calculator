<?php

namespace App\Controller;

use App\Entity\Sell;
use App\Form\Type\PurchaseType;
use App\Form\Type\SellType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SellController extends AbstractController
{
    /**
     * @Route("/sell", name="sell")
     */
    public function index()
    {
        return $this->render('sell/index.html.twig', [
            'controller_name' => 'SellController',
        ]);
    }

    /**
     * @Route("/sell/add", methods={"GET"}, name="sell_add")
     * @return Response
     */
    public function add() : Response
    {
        $sell = new Sell();
        $form = $this->createForm(SellType::class,$sell,[
            'action' => $this->generateUrl('post_sell_add'),
            'method' => 'POST'
        ]);
        return $this->render('sell/add.html.twig',['form'=>$form->createView()]);
    }

    /**
     * @Route("sell/add", methods={"POST"}, name="post_sell_add")
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return Response
     */
    public function postAdd(Request $request, ValidatorInterface $validator) : Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $sell = new Sell();
        $form=$this->createForm(SellType::class, $sell);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $sell = $form->getData();
            $entityManager->persist($sell);
            $entityManager->flush();
            $this->addFlash('success', 'Added a sell');
            return $this->redirectToRoute('sell');
        } else {
            $this->addFlash('danger','error while adding sells');
            return $this->redirectToRoute('sell_add');
        }
    }
}
