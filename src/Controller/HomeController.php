<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Utilisateur;
use App\Entity\Contact;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function myhome(EntityManagerInterface $entityManager, Request $request): Response {
        $session = $request->getSession();

        if ($session->get('user', null) == null) {
            return new RedirectResponse('login');
        }

        $user =  $session->get('user');

        $contacts = $this->getContacts($entityManager, $user->getIdNom());

        return $this->render('home/index.html.twig', [
            'user' => $user,
            'user_contact' => $user,
            'contacts' => $contacts
        ]);
    }
    #[Route('/', name: 'root')]
    public function root(Request $request): Response {
        $session = $request->getSession();

        if ($session->get('user', null) == null) {
            return $this->redirectToRoute('app_login');
        }
        return $this->redirectToRoute('app_home');
    }
    #[Route('/home/friends/{id}', name: 'app_home_friends')]
    public function homeOther(EntityManagerInterface $entityManager, Request $request, string $id): Response{
        $session = $request->getSession();

        if ($session->get('user', null) == null) {
            return new RedirectResponse('login');
        }

        $user =  $session->get('user');

        $contacts = $this->getContacts($entityManager, $id);
        $user_contact = $this->getUtilisateur($entityManager, $id);

        return $this->render('home/index.html.twig', [
            'user' => $user,
            'user_contact' => $user_contact,
            'contacts' => $contacts
        ]);
    }


    private function getContacts(EntityManagerInterface $entityManager, int $user_id): array {
        $ContactRepository = $entityManager->getRepository(Contact::class);
        $UtilisateurRepository = $entityManager->getRepository(Utilisateur::class);
        $contacts = $ContactRepository->findBy(array(
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

    private function getUtilisateur(EntityManagerInterface $entityManager, int $user_id) {
        $UtilisateurRepository = $entityManager->getRepository(Utilisateur::class);
        $user = $UtilisateurRepository->findOneBy(array(
                'id_nom' => $user_id)
        );

        return $user;
    }
}
