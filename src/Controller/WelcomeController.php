<?php
/**
 * WelcomeController.php
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
use App\Entity\Sell;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * WelcomeController Class
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
class WelcomeController extends AbstractController
{
    /**
     * Main entry point of the system
     *
     * @Route("/", name="welcome")
     *
     * @return Response
     */
    public function index()
    {
        $profit = $this->getDoctrine()->getRepository(Sell::class)->getTotalProfit();

        return $this->render(
            'welcome/index.html.twig',
            ['profit'=>$profit]
        );
    }

    /**
     * Reset Datbase Entry Point
     *
     * @Route("/reset")
     *
     * @return RedirectResponse
     */
    public function resetDB()
    {
        $this->getDoctrine()->getRepository(Inventory::class)->dropAll();
        $this->getDoctrine()->getRepository(Sell::class)->dropAll();
        $this->addFlash('success', 'Database Reset Complete');
        return $this->redirectToRoute('welcome');
    }
}
