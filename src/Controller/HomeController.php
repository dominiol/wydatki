<?php

namespace App\Controller;

use App\Util\TransactionManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class HomeController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function index(AuthorizationCheckerInterface $authorizationChecker)
    {
        if ($authorizationChecker->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('summary');
        }

        return $this->redirectToRoute('authenticate');
    }

    /**
     * @Route("/w/summary", name="summary")
     */
    public function summary(TransactionManager $transactionManager)
    {
        $balance = $transactionManager->getAccountBalance();
        $estimatedBalance = $transactionManager->getEstimatedAccountBalance();
        $allowedPricePerDay = $transactionManager->getAllowedPricePerDay();
        $plannedOutgoingsTotalValue = $transactionManager->getPlannedOutgoingsTotalValue();
        $plannedIncomingsTotalValue = $transactionManager->getPlannedIncomingsTotalValue();

        return $this->render('home/summary.html.twig', [
            'balance' => $balance,
            'estimatedBalance' => $estimatedBalance,
            'allowedPricePerDay' => $allowedPricePerDay,
            'plannedOutgoingsTotalValue' => $plannedOutgoingsTotalValue,
            'plannedIncomingsTotalValue' => $plannedIncomingsTotalValue
        ]);
    }
}
