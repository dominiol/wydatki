<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Form\TransactionAddType;
use App\Util\TransactionManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TransactionController extends Controller
{
    /**
     * @Route("/w/transaction/add", name="transaction_add")
     */
    public function add(Request $request)
    {
        $transaction = new Transaction();

        $form = $this->createForm(TransactionAddType::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($transaction);
            $em->flush();

            $this->addFlash('info', 'Dodano transakcję!');

            if ($transaction->getIsPlanned()) {
                return $this->redirectToRoute('transaction_list_planned');
            }

            return $this->redirectToRoute('transaction_list');
        }

        return $this->render('transaction/add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/w/transaction/list", name="transaction_list")
     */
    public function list(TransactionManager $transactionManager)
    {
        $transactions = $transactionManager->getStandardTransactions();

        return $this->render('transaction/list.html.twig', [
            'transactions' => $transactions
        ]);
    }

    /**
     * @Route("/w/transaction/list/planned", name="transaction_list_planned")
     */
    public function listPlanned(TransactionManager $transactionManager)
    {
        $transactions = $transactionManager->getPlannedTransactions();

        return $this->render('transaction/list_planned.html.twig', [
            'transactions' => $transactions
        ]);
    }
}
