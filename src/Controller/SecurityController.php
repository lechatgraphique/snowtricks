<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Form\EditPasswordType;
use App\Form\EditProfileType;
use App\Form\RegistrationType;
use Doctrine\Persistence\ObjectManager;
use http\Exception;
use phpDocumentor\Reflection\Types\This;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Swift_Mailer;
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
     * @param Swift_Mailer $mailer
     * @return Response
     * @throws \Exception
     */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder, Swift_Mailer $mailer): Response
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
                ->setActivated(false)
                ->setToken(md5(random_bytes(10)));

            $manager->persist($user);
            $manager->flush();

            $message = (new \Swift_Message('Validation de votre compte SnowTricks'))
                ->setFrom('noreply@snowtricks.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView('email/validation.html.twig', [
                        'user' => $user
                    ]),
                    'text/html'
                )
            ;

            $mailer->send($message);

            $this->addFlash(
                'success',
                "Compte crée avec succès ! Veuillez valider votre compte via le mail qui vous a été envoyé pour pouvoir vous connecter !"
            );

            return $this->redirectToRoute('account.login');
        }

        return $this->render('account/registration.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Validation de l'email après une inscription
     *
     * @Route("/email-validation/{username}/{token}", name="email.validation")
     * @param User $user
     * @param $username
     * @param $token
     * @param ObjectManager $manager
     */
    public function emailValidation(User $user, $username, $token, ObjectManager $manager)
    {
        $objectManager = $this->getDoctrine()->getRepository('App:User');
        $user = $objectManager->find($user->getUsername());

        if ($token != null && $token === $user->getToken()) {
            $user->setActivated(true);
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre compte a été activé avec succès ! Vous pouvez désormais vous connecter !"
            );
        } else {
            $this->addFlash(
                'danger',
                "La validation de votre compte a échoué. Le lien de validation a expiré !"
            );
        }
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
            //$file = $user->getFile();

            // $name = md5(uniqid()) . '.' . $file->getClientOriginalExtension();

            //$path = 'img/users';
            //$file->move($path, $name);

            //$user->setImagePath($path);
            //$user->setImageName($name);

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
