<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Form\EditPasswordType;
use App\Form\EditProfileType;
use App\Form\RegistrationType;
use Doctrine\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @var Security
     */
    private Security $security;

    /**
     * @var ObjectManager
     */
    private ObjectManager $objectManager;

    public function __construct(Security $security, ObjectManager $objectManager)
    {
        $this->security = $security;
        $this->objectManager = $objectManager;
    }

    /**
     * @Route("/login", name="auth.login")
     * @param AuthenticationUtils $utils
     * @return Response
     */
    public function login(AuthenticationUtils $utils): Response
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();

        return $this->render('auth/login.html.twig', [
            'error' => $error,
            'username' => $username
        ]);
    }

    /**
     * @Route("/register", name="auth.register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);
            $user->setRoles(['ROLE_USER']);

            $this->objectManager->persist($user);
            $this->objectManager->flush();

            return $this->redirectToRoute('auth_login');
        }

        return $this->render('auth/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("profile/edit", name="user_edit")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function edit(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = $this->security->getUser();

        $form = $this->createForm(EditProfileType::class, $user);
        $form->handleRequest($request);

        $formPassword = $this->createForm(EditPasswordType::class, $user);
        $formPassword->handleRequest($request);

        if($formPassword->isSubmitted() && $formPassword->isValid()) {

            if(!password_verify($formPassword->get('oldPassword')->getData(), $user->getPassword())){

                $this->addFlash(
                    'danger',
                    'le mot de passe ne correspond pas à votre mot de passe actuel'
                );

                return $this->redirectToRoute('user_edit');
            }

            if($formPassword->get('newPassword')->getData() != $formPassword->get('confirmPassword')->getData()) {

                $this->addFlash(
                    'danger',
                    'les mots de passe saisis ne correspondent pas'
                );
                return $this->redirectToRoute('user_edit');
            }

            $hash = $encoder->encodePassword($user, $formPassword->get('newPassword')->getData());
            $user->setPassword($hash);

            $this->objectManager->flush();

            $this->addFlash(
                'success',
                'Votre mot de passe a bien été mis à jour'
            );

            return $this->redirectToRoute('user_edit');

        }

        if($form->isSubmitted() && $form->isValid()) {


            $avatarFile = $form->get('avatar')->getData();
            if ($avatarFile) {
                $filename = uniqid().'.'.$avatarFile->guessExtension();
                try {
                    $avatarFile->move(
                        $this->getParameter('profile_directory'),
                        $filename
                    );
                } catch (FileException $e) { }
                $user->setAvatar($filename);
            }

            $this->objectManager->flush();

            $this->addFlash(
                'success',
                'Votre profil a bien été mis à jour'
            );

            return $this->redirectToRoute('user_edit');
        }



        return $this->render('profile/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'form_password' => $formPassword->createView()
        ]);
    }

    /**
     * @Route("profile/{id}/delete", name="edit_profile_delete")
     * @param User $user
     * @return Response
     */
    public function delete(User $user): Response
    {
        if($user === $this->getUser()) {
            $this->get('security.token_storage')->setToken(null);
            $this->objectManager->remove($user);
            $this->objectManager->flush();
        }

        return $this->redirectToRoute('home_index');
    }

    /**
     * @Route("/logout", name="auth.logout")
     */
    public function logout()
    {

    }
}
