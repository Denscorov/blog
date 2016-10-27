<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\User;
use BlogBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class AdminController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('BlogBundle:Admin:login.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
        ));
    }

    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $encoder = $this->get('blog.user.pass.encoder');
            $user->setPassword($encoder->encodePassword($user->getPassword(), $user->getSalt()));
            $role = $this->getDoctrine()->getRepository('BlogBundle:Role')->findOneBy(['role' => 'ROLE_USER']);
            $user->addRole($role);
            $em = $this->getDoctrine()->getManager();
            $em->persist($role);
            $em->persist($user);
            $em->flush();

            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->get('security.token_storage')->setToken($token);
            $this->get('session')->set('_security_main', serialize($token));
            return $this->redirectToRoute('home');
        }

        return $this->render('BlogBundle:Admin:register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function adminAction()
    {
        return $this->render('BlogBundle:Admin:index.html.twig');
    }

    /**
     * @Route("/access", name="access")
     */
    public function accessAction()
    {
        return $this->render('BlogBundle:Admin:access_denied.html.twig');
    }
}