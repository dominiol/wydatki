<?php

namespace App\Util;

use Doctrine\ORM\EntityManager;

/**
 * Transactions helper class
 * @package App\Util
 */
class TransactionManager
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getStandardTransactions() {
        $query = $this->em->createQuery('SELECT t FROM App:Transaction t WHERE t.isPlanned = 0 ORDER BY t.createdAt DESC');

        return $query->getResult();
    }

    public function getPlannedTransactions() {
        $query = $this->em->createQuery('SELECT t FROM App:Transaction t WHERE t.isPlanned = 1 ORDER BY t.createdAt DESC');

        return $query->getResult();
    }

    public function getAccountBalance() {
        $query = $this->em->createQuery('SELECT SUM(t.value) FROM App:Transaction t WHERE t.isPlanned = 0');

        return $query->getSingleScalarResult();
    }

    public function getEstimatedAccountBalance() {
        $query = $this->em->createQuery('SELECT SUM(t.value) FROM App:Transaction t');

        return $query->getSingleScalarResult();
    }

    public function getPlannedOutgoingsTotalValue() {
        $query = $this->em->createQuery('SELECT SUM(t.value) FROM App:Transaction t WHERE t.isPlanned = 1 AND t.value < 0');

        return $query->getSingleScalarResult();
    }

    public function getPlannedIncomingsTotalValue() {
        $query = $this->em->createQuery('SELECT SUM(t.value) FROM App:Transaction t WHERE t.isPlanned = 1 AND t.value > 0');

        return $query->getSingleScalarResult();
    }

    public function getAllowedPricePerDay() {
        $query = $this->em->createQuery('SELECT SUM(t.value) FROM App:Transaction t');
        $estimatedBalance = $query->getSingleScalarResult();

        $remainingDaysOfMonth = date('t') - date('d');

        return round($estimatedBalance / $remainingDaysOfMonth, 2);
    }
}