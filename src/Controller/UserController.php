<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();        
        $users = $entityManager->getRepository(User::class)->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    public function detail(int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();        
        $user = $entityManager->getRepository(User::class)->find($id);

        return $this->render('user/detail.html.twig', [
            'user' => $user,
        ]);
    }

    public function create(Request $request)
    {
        $user =new User();

        $form = $this->createFormBuilder($user)
        ->add('username',TextType::class, array(
            'attr' => array(
                'class' => 'form-control'
            )
        ))
        ->add('email',EmailType::class, array(
            'attr' => array(
                'class' => 'form-control'
            )
        ))
        ->add('password', PasswordType::class, array(
            'attr' => array(
                'class' => 'form-control'
            )))
        ->add('role', ChoiceType::class, array(
            'label' => 'Role',
            'choices'  => array(
                'Student' => 'student',
                'Teacher' => 'teacher',
            ),
            'attr' => array(
                'class' => 'form-control'
            )))
        ->add('create', SubmitType::class, array(
            'label' => 'Create user',
            'attr' => array(
                'class' => 'btn btn-primary'
            )))
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $user = $form->getData();
    
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash(
                'notice',
                'Create user '.$user->getUsername().' success !'
            );
            return $this->redirectToRoute('user_list');
        }   

        return $this->render('user/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function edit(Request $request, int $id)
    {
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($id);   

        $form = $this->createFormBuilder($user)
        ->add('username',TextType::class, array(
            'attr' => array(
                'class' => 'form-control'
            )
        ))
        ->add('email',EmailType::class, array(
            'attr' => array(
                'class' => 'form-control'
            )
        ))
        ->add('password', PasswordType::class, array(
            'attr' => array(
                'class' => 'form-control'
            )))
        ->add('role', ChoiceType::class, array(
            'label' => 'Role',
            'choices'  => array(
                'Student' => 'student',
                'Teacher' => 'teacher',
            ),
            'attr' => array(
                'class' => 'form-control'
            )))
        ->add('create', SubmitType::class, array(
            'label' => 'Update user',
            'attr' => array(
                'class' => 'btn btn-primary'
            )))
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $user = $form->getData();
    
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash(
                'notice',
                'Update user '.$user->getUsername().' success !'
            );
            return $this->redirectToRoute('user_list');
        }   

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    public function delete(int $id)
    {    
        $entityManager = $this->getDoctrine()->getManager();        
        $user = $entityManager->getRepository(User::class)->find($id);   
        $this->addFlash(
            'notice',
            'Delete user '.$user->getUsername().' success !'
        );
        $entityManager->remove($user);
        $entityManager->flush();

        
        return $this->redirectToRoute('user_list');
    }
}
