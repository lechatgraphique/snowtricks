<?php


namespace App\Controller;

use App\Entity\User;
use App\Form\EditProfileType;
use App\Form\RegistrationType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;

class SecurityController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/login", name="auth_login")
     * @return Response
     */
    public function login(): Response
    {
        return $this->render('auth/login.html.twig', []);
    }

    /**
     * @Route("/register", name="auth_register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param ObjectManager $om
     * @return Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder, ObjectManager $om): Response
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);
            $user->setRoles(['ROLE_USER']);

            $om->persist($user);
            $om->flush();

            return $this->redirectToRoute('auth_login');
        }

        return $this->render('auth/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("profile/edit", name="user_edit")
     * @param UserPasswordEncoderInterface $encoder
     * @param ObjectManager $om
     * @param Request $request
     * @return Response
     */
    public function edit(UserPasswordEncoderInterface $encoder, ObjectManager $om, Request $request): Response
    {
        $user = $this->security->getUser();

        $form = $this->createForm(EditProfileType::class, $user);

        $form->handleRequest($request);

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

            $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);

            $om->persist($user);
            $om->flush();

            $this->addFlash(
                'success',
                'Votre profil a bien été mis à jour'
            );

            return $this->redirectToRoute('user_edit');
        }

        return $this->render('profile/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/logout", name="auth_logout")
     */
    public function logout()
    {

    }
}
