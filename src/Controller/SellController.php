<?php
/**
 * SellController.php
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

use App\Entity\Sell;
use App\Form\Type\SellType;
use App\Service\ProfitCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Sell Controller class
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
class SellController extends AbstractController
{
    /**
     * Index entry point
     *
     * @Route("/sell", name="sell")
     *
     * @return Response
     */
    public function index(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Sell::class);
        $sells = $repository->findAll();

        return $this->render(
            'sell/index.html.twig',
            [
                'controller_name' => 'SellController',
                'sells' => $sells
            ]
        );
    }

    /**
     * Add entry point to show add form
     *
     * @Route("/sell/add", methods={"GET"}, name="sell_add")
     *
     * @return Response
     */
    public function add(): Response
    {
        $sell = new Sell();

        $form = $this->createForm(
            SellType::class,
            $sell,
            [
                'action' => $this->generateUrl('post_sell_add'),
                'method' => 'POST'
            ]
        );

        return $this->render('sell/add.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Store Sell data from add form
     *
     * @param Request $request Request Object
     * @param ProfitCalculator $calculator Class to calculate the profit
     *
     * @Route("sell/add", methods={"POST"}, name="post_sell_add")
     *
     * @return Response
     */
    public function postAdd(
        Request $request,
        ProfitCalculator $calculator
    ): Response {
        $entityManager = $this->getDoctrine()->getManager();

        $sell = new Sell();
        $form = $this->createForm(SellType::class, $sell);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sell = $form->getData();
            if ($sell->getQuantity() == 0) {
                $this->addFlash('danger', 'Quantity can not be 0');
                return $this->redirectToRoute('sell_add');
            }
            $profit = $calculator->calculate($sell, $entityManager);
            if ($profit == -1) {
                $this->addFlash('danger', 'Not enough item in inventory');
                return $this->redirectToRoute('sell_add');
            }
            $sell->setProfit($profit);
            $entityManager->persist($sell);
            $entityManager->flush();

            $this->addFlash('success', 'Added a sell');

            return $this->redirectToRoute('sell');
        } else {
            $this->addFlash('danger', 'error while adding sells');

            return $this->redirectToRoute('sell_add');
        }
    }
}
