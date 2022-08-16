<?php

namespace App\Repository;

use App\Entity\Etudiant;
use App\Entity\Fillier;
use App\Entity\Niveau;
use App\Entity\Promotion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Etudiant>
 *
 * @method Etudiant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Etudiant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Etudiant[]    findAll()
 * @method Etudiant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtudiantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Etudiant::class);
    }

    public function add(Etudiant $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Etudiant $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Etudiant[] Returns an array of Etudiant objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    public function findEtudiantByPromotion(Promotion $value)
    {
        return $this->createQueryBuilder('e')
            ->join('e.fillier','f')
            ->andWhere('f.promotion=:val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
            ;
    }


    public function findScolariterterTotalByPromotion(Promotion $value)
    {
        return $this->createQueryBuilder('e')
            ->join('e.fillier','f')
            ->andWhere('f.promotion=:val')
            ->setParameter('val', $value)
            ->select("SUM(e.scolariter_payer) as payer")
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }
}
