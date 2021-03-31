<?php

namespace App\Repository;

use App\Document\EmailSchedule;
use App\Document\User;
use Doctrine\ODM\MongoDB\DocumentManager;

/**
 * @method EmailSchedule|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmailSchedule|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmailSchedule[]    findAll()
 * @method EmailSchedule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmailScheduleRepository extends InjectableRepository
{
    public function __construct(DocumentManager $dm)
    {
        parent::__construct($dm, EmailSchedule::class);
    }

    public function findScheduledAndNotSent()
    {
        $qb = $this->createQueryBuilder();

        $qb
            ->field('isSent')->equals(false)
            ->field('scheduledOn')->lte(new \DateTime());

        return $qb
            ->getQuery()
            ->execute();
    }

    public function findAllPaginatedForUser(array $sortColumn, int $offset, int $limit, User $user)
    {
        $qb = $this->createQueryBuilder();

        $qb
            ->field('owner')->references($user)
            ->sort($sortColumn)
            ->limit($limit)
            ->skip($offset);

        return $qb
            ->getQuery()
            ->execute();
    }

    public function countAllForUser(User $user)
    {
        $qb = $this->createQueryBuilder();

        $qb
            ->field('owner')->references($user);

        return $qb
            ->count()
            ->getQuery()
            ->execute();
    }
}
