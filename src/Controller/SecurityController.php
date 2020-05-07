<?php


namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
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

            $om->persist($user);
            $om->flush();

            return $this->redirectToRoute('auth_login');
        }

        return $this->render('auth/register.html.twig', [
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
