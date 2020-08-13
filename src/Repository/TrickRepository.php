<?php

namespace App\Repository;

use App\Entity\Trick;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Request\ArgumentValueResolver\Psr7ServerRequestResolver;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * @method Trick|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trick|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trick[]    findAll()
 * @method Trick[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct( ManagerRegistry $registry)
    {
        parent::__construct($registry, Trick::class);
    }

    /**
     * @param int $page
     * @param int $maxPerPage
     * @return Paginator
     */
    public function findAllForPaginateAndSort($page, $maxPerPage)
    {
        if ($page <= 1) {
            $page = 1;
        }

        $trickResults = ($page*$maxPerPage) - $maxPerPage;

        $query = $this->createQueryBuilder('t')
            ->orderBy('t.createdAt', 'DESC')
            ->setFirstResult($trickResults)
            ->setMaxResults($maxPerPage);

        $pagination = new Paginator($query);

        return $pagination;
    }
}