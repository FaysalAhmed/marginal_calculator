<?php
/**
 * Purchase Controller
 *
 * PHP version 7
 *
 * @category Controller
 *
 * @package App\Controller
 *
 * @author Faysal Ahmed <faysal.ahmed833@gmail.com>
 *
 * @license custom license http://www.eskimi.com/
 *
 * @link http://www.eskimi.com/
 */

namespace App\Controller;

use App\Entity\Inventory;
use App\Form\Type\PurchaseType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Purchase Controller class
 *
 * PHP version 7
 *
 * @category Controller
 *
 * @package App\Controller
 *
 * @author Faysal Ahmed <faysal.ahmed833@gmail.com>
 *
 * @license custom license http://www.eskimi.com/
 *
 * @link http://www.eskimi.com/
 */
class PurchaseController extends AbstractController
{
    /**
     * Add a purchase view
     *
     * @Route("/purchase/add", methods={"GET"}, name="purchase_add")
     *
     * @return Response
     */
    public function add(): Response
    {
        $purchase = new Inventory();
        $form = $this->createForm(
            PurchaseType::class,
            $purchase,
            [
                'action' => $this->generateUrl('post_purchase_add'),
                'method' => 'POST'
            ]
        );
        return $this
            ->render('purchase/add.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Index entry point for Purchase Controller
     *
     * @Route("/inventory", methods={"GET"}, name="purchase")
     *
     * @return Response
     */
    public function index(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Inventory::class);
        $purchases = $repository->findAll();

        return $this
            ->render('purchase/index.html.twig', ['purchases' => $purchases]);
    }

    /**
     * Post entry point for Adding a purchase
     *
     * @param Request            $request   Request object
     * @param ValidatorInterface $validator to validate the input
     *
     * @Route("/purchase/add",methods={"POST"}, name="post_purchase_add")
     *
     * @return Response
     */
    public function postAdd(
        Request $request
    ): Response {
        $entityManager = $this->getDoctrine()->getManager();

        $purchase = new Inventory();
        $form = $this->createForm(PurchaseType::class, $purchase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $purchase = $form->getData();
            $entityManager->persist($purchase);
            $entityManager->flush();
            $this->addFlash('success', 'Added a purchase');
            return $this->redirectToRoute('purchase');
        } else {
            $this->addFlash('danger', 'error while adding purchase');
            return $this->redirectToRoute("purchase_add");
        }
    }
}
