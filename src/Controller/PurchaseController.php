<?php

namespace App\Controller;

use App\Entity\Purchase;
use App\Form\Type\PurchaseType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PurchaseController extends AbstractController
{
    /**
     * @Route("/purchase/add", methods={"GET"},name="purchase_add")
     */
    public function add() : Response
    {
        $purchase = new Purchase();
        $form = $this->createForm(PurchaseType::class,$purchase,[
            'action' => $this->generateUrl('post_purchase_add'),
            'method' => 'POST'
        ]);
        return $this->render('purchase/add.html.twig', ['form'=>$form->createView()]);
    }

    /**
     * @Route("/purchase/add",methods={"POST"}, name="post_purchase_add")
     */
    public function postAdd(Request $request, ValidatorInterface $validator) : Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $purchase = new Purchase();
        $form = $this->createForm(PurchaseType::class, $purchase);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $purchase = $form->getData();
            $entityManager->persist($purchase);
            $entityManager->flush();
            // TODO: show the list
            return new Response("test");
        } else {
            $this->addFlash('error','error while adding purchase');
            return $this->redirectToRoute("purchase_add");
        }

    }
}