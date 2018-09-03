<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;


class SecurityController extends AbstractController
{
    /**
     * @Route("/security", name="security")
     */
    public function login(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = new User();
        $form = $this->createFormBuilder($user)
            ->add('email', EmailType::class)
            ->add('password',PasswordType::class)
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user_login = $repository->findOneBy(['email' => $user->getEmail()]);
            if($user_login != null){
                if($user_login->getPassword() == $user->getPassword()){
                    $this->addFlash(
                        'notice',
                        'Login success !'
                    );
                    if(!$request->cookies->has('user_name')){
                        $cookie = new Cookie('user_name', $user_login->getUsername(), time() + 3600); 
                        $response = new Response();
                        $response->headers->setCookie($cookie);
                    }
                    return $this->redirectToRoute('homepage');
                }
                else{
                    $this->addFlash(
                        'notice',
                        'Login error email or password not valid !'
                    );
                }
            }            
        }
        
        return $this->render(
           'security/login.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // Create a new blank user and process the form
        $user = new User();
        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class)
            ->add('email', EmailType::class)
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => 'Confirm Password'],
                ])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Set their role
            $user->setRole('user');
            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
