<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\LoginType;
use App\Form\SignupType;
use PHPUnit\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\UriSafeTokenGenerator;
use Symfony\Component\Security\Csrf\CsrfToken;
class SecurityController extends AbstractController
{

    #[Route('/login', name: 'app_login')]
    public function login(CsrfTokenManagerInterface $csrfTokenManager, EntityManagerInterface $entityManager, Request $request): Response
    {
        $tokenGenerator = new UriSafeTokenGenerator();
        $csrfToken = $csrfTokenManager->getToken('my_csrf_token_name');
        $csrfTokenValue = $csrfToken->getValue();

        $utilisateur = new Utilisateur();
        $session = $request->getSession();
        $session->set('user', null);

        $form = $this->createForm(LoginType::class, $utilisateur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $submittedToken = $request->request->get('_token');
            if (!$csrfTokenManager->isTokenValid(new CsrfToken('my_csrf_token_name', $submittedToken))) {
                throw new \Exception('Invalid CSRF token');
            }
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
                'form' => $form->createView(),
                'csrf_token_value' => $csrfTokenValue,
            ]);
        }

        return $this->render('security/login.html.twig', [
            'error' => '',
            'form' => $form->createView(),
            'csrf_token_value' => $csrfTokenValue,
        ]);
    }

    #[Route('/signup', name: 'app_signup')]
    public function signup(CsrfTokenManagerInterface $csrfTokenManager,EntityManagerInterface $entityManager, Request $request): Response
    {
        $tokenGenerator = new UriSafeTokenGenerator();
        $csrfToken = $csrfTokenManager->getToken('my_csrf_token_name');
        $csrfTokenValue = $csrfToken->getValue();

        $utilisateur = new Utilisateur();
        $session = $request->getSession();
        $session->set('user', null);

        $form = $this->createForm(SignupType::class, $utilisateur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $submittedToken = $request->request->get('_token');
            if (!$csrfTokenManager->isTokenValid(new CsrfToken('my_csrf_token_name', $submittedToken))) {
                throw new \Exception('Invalid CSRF token');
            }

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
                'form' => $form->createView(),
                'csrf_token_value' => $csrfTokenValue,
            ]);
        }

        return $this->render('security/signup.html.twig', [
            'error' => '',
            'form' => $form->createView(),
            'csrf_token_value' => $csrfTokenValue,
        ]);
    }
    #[Route('/logout', name: 'logout')]
    public function logout(Request $request):Response{
        $session = $request->getSession();

        if (!$session->get('user', null) == null) {
            $session->remove('user');
        }
        return $this->redirectToRoute('app_home');
    }
    #[Route('/deleteAccount', name: 'deleteAccount')]
    public function deleteAccount(CsrfTokenManagerInterface $csrfTokenManager,EntityManagerInterface $entityManager,Request $request):Response{

        $contactRepository = $entityManager->getRepository(Contact::class);
        $user = $request->getSession()->get('user');

        try{
            $id = $user->getIdNom();
            $entity = $entityManager->merge($user);
            $entityManager->remove($entity);
            $contactRepository->deleteContactByID($id);
            $entityManager->flush();
            return $this->redirectToRoute('app_signup');
        }
        catch (Exception $e){
            return $this->redirectToRoute('app_home');
        }

    }
    private function deleteUser(EntityManagerInterface $entityManager, int $userID){

    }
//    private function mapFormToUtilisateur($formData): Utilisateur {
//        $user = new Utilisateur($formData['nom'], $formData['prenom'], $formData['num'], $formData['email']);
//        return $user;
//    }
}
