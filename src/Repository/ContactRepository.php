<?php

namespace App\Repository;

use App\Entity\Contact;
use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contact>
 *
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    public function save(Contact $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Contact $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function deleteContactByID(int $UserID){
        $qb = $this->createQueryBuilder('c')
            ->delete()
            ->where('c.id_nom = :id OR c.id_contact = :id')
            ->setParameter('id',$UserID)
        ;
        $query = $qb->getQuery();
        $query->getResult();
    }

    public function getContacts(EntityManagerInterface $entityManager, int $user_id): array {
        $UtilisateurRepository = $entityManager->getRepository(Utilisateur::class);
        $contacts = $this->findBy(array(
                'id_nom' => $user_id)
        );
        $contactsAsUser = array();
        foreach($contacts as $contactId) {
            array_push($contactsAsUser,
                $UtilisateurRepository->findOneBy(array(
                    'id_nom' => $contactId->getIdContact()))
                );
        }

        return $contactsAsUser;
    }
//    /**
//     * @return Contact[] Returns an array of Contact objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Contact
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
