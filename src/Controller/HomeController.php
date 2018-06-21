<?php

namespace App\Controller;

use App\Util\TransactionManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function index(TransactionManager $transactionManager)
    {
        $balance = $transactionManager->getAccountBalance();
        $estimatedBalance = $transactionManager->getEstimatedAccountBalance();
        $allowedPricePerDay = $transactionManager->getAllowedPricePerDay();

        return $this->render('home/index.html.twig', [
            'balance' => $balance,
            'estimatedBalance' => $estimatedBalance,
            'allowedPricePerDay' => $allowedPricePerDay
        ]);
    }
}
