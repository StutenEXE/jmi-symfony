<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DataController extends AbstractController
{
    #[Route('/data/userPersonalInfo/{nom}', name: 'userInfo')]
    public function userPersonalInfo(EntityManagerInterface $entityManager,String $nom): Response
    {
        $UtilisateurRepository = $entityManager->getRepository(Utilisateur::class);
        $user = $UtilisateurRepository->findBy(array(
                'nom' => $nom)
        )[0];

        return new Response(json_encode([
            'id_nom' => $user->getIdNom(),
            'nom' => $user->getNom(),
            'prenom' =>$user->getPrenom(),
            'email' =>$user->getEmail()
        ]));
    }
}
