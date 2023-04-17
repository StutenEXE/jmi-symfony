<?php

namespace App\Controller;

use App\Form\LoginType;
use App\Form\SignupType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SecurityController extends AbstractController
{

    #[Route('/login', name: 'app_login')]
    public function login(EntityManagerInterface $entityManager, Request $request): Response
    {
        $utilisateur = new Utilisateur();
        $session = $request->getSession();
        $session->set('user', null);

        $form = $this->createForm(LoginType::class, $utilisateur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $data = $form->getData();

            $UtilisateurRepository = $entityManager->getRepository(Utilisateur::class);
            $utilisateur = $UtilisateurRepository->findOneBy(array(
                'nom' => $utilisateur->getNom(),
                'num' => $utilisateur->getNum())
            );

            if ($utilisateur != null) {
                $session->set('user', $utilisateur);
 
                return new RedirectResponse('home');
            }

            return $this->render('security/login.html.twig', [
                'error' => "Nom ou num incorrect",
                'form' => $form->createView()
            ]);
        }

        return $this->render('security/login.html.twig', [
            'error' => '',
            'form' => $form->createView()
        ]);
    }

    #[Route('/signup', name: 'app_signup')]
    public function signup(EntityManagerInterface $entityManager, Request $request): Response
    {
        $utilisateur = new Utilisateur();
        $session = $request->getSession();
        $session->set('user', null);

        $form = $this->createForm(SignupType::class, $utilisateur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $data = $form->getData();

            $UtilisateurRepository = $entityManager->getRepository(Utilisateur::class);
//            $utilisateur = $this->mapFormToUtilisateur();

            if ($utilisateur != null) {
                $UtilisateurRepository->save($utilisateur);
                $session->set('user', $utilisateur);
                return new RedirectResponse('home');
            }
            return $this->render('security/signup.html.twig', [
                'error' => "Nom ou num incorrect",
                'form' => $form->createView()
            ]);
        }

        return $this->render('security/signup.html.twig', [
            'error' => '',
            'form' => $form->createView()
        ]);
    }
    #[Route('/logout', name: 'logout')]
    public function logout(Request $request){
        $session = $request->getSession();

        if (!$session->get('user', null) == null) {
            $session->remove('user');
        }
        return $this->redirectToRoute('app_home');
    }
//    private function mapFormToUtilisateur($formData): Utilisateur {
//        $user = new Utilisateur($formData['nom'], $formData['prenom'], $formData['num'], $formData['email']);
//        return $user;
//    }
}
