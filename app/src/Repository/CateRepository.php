<?php
/**
 * Cate repository.
 */

namespace App\Repository;

use App\Entity\Cate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;



/**
 * Class CateRepository.
 *
 * @method Cate|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cate|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cate[]    findAll()
 * @method Cate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CateRepository extends ServiceEntityRepository
{
    /**
     * Items per page.
     *
     * Use constants to define configuration options that rarely change instead
     * of specifying them in app/config/config.yml.
     * See https://symfony.com/doc/current/best_practices.html#configuration
     *
     * @constant int
     */
    const PAGINATOR_ITEMS_PER_PAGE = 3;

    /**
     * CateRepository constructor.
     *
     * @param \Doctrine\Common\Persistence\ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cate::class);
    }

    /**
     * Query all records.
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->orderBy('c.updatedAt', 'DESC');
    }

    /**
     * Get or create new query builder.
     *
     * @param \Doctrine\ORM\QueryBuilder|null $queryBuilder Query builder
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('c');
    }

    /**
     * Save record.
     *
     * @param \App\Entity\Cate $cate Cate entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Cate $cate): void
    {
        $this->_em->persist($cate);
        $this->_em->flush($cate);
    }

    /**
     * Delete record.
     *
     * @param \App\Entity\Cate $cate Cate entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Cate $cate): void
    {
        $this->_em->remove($cate);
        $this->_em->flush($cate);
    }

}