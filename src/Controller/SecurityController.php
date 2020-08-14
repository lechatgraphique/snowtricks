<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Form\RegistrationType;
use Doctrine\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/login", name="account.login")
     * @param AuthenticationUtils $utils
     * @return Response
     */
    public function login(AuthenticationUtils $utils): Response
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();

        return $this->render('account/login.html.twig', [
            'error' => $error,
            'username' => $username
        ]);
    }


    /**
     * @Route("/registration", name="account.registration")
     * @param Request $request
     * @param ObjectManager $manager
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     * @throws \Exception
     */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $file = $user->getFile();

            $name = md5(uniqid()) . '.' . $file->guessExtension();

            $path = 'img/users';
            $file->move($path, $name);

            $user->setPicturePath($path);
            $user->setPictureName($name);

            $password = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password)
                ->setCreatedAt(new \DateTime)
                ->setActivated(true)
                ->setToken(md5(random_bytes(10)));

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Compte crée avec succès !"
            );

            return $this->redirectToRoute('account.login');
        }

        return $this->render('account/registration.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Afficher et traiter le formulaire de modification de profil
     *
     * @Route("/account/profile", name="account.profile.edit")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function profile(Request $request, ObjectManager $manager)
    {
        $user = $this->getUser();

        $form = $this->createForm(AccountType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Les modifications du profil ont été enregistrées avec succès !'
            );
        }

        return $this->render('account/profile.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/logout", name="account.logout")
     */
    public function logout()
    {

    }
}
