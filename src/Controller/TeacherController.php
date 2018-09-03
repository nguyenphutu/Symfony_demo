<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Teacher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TeacherController extends AbstractController
{
    /**
     * @Route("/teacher", name="teacher")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();        
        $teachers = $entityManager->getRepository(Teacher::class)->findAll();

        return $this->render('teacher/index.html.twig', [
            'teachers' => $teachers,
        ]);
    }

    public function detail(int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();        
        $teacher = $entityManager->getRepository(Teacher::class)->find($id);

        return $this->render('teacher/detail.html.twig', [
            'teacher' => $teacher,
        ]);
    }

    public function create(Request $request)
    {
        $teacher =new Teacher();

        $form = $this->createFormBuilder($teacher)
        ->add('fullname',TextType::class, array(
            'attr' => array(
                'class' => 'form-control'
            )
        ))
        ->add('dateofbirth', DateType::class, array(
            'attr' => array(
                'class' => 'form-control'
            )))
        ->add('create', SubmitType::class, array(
            'label' => 'Create teacher',
            'attr' => array(
                'class' => 'btn btn-primary'
            )))
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $teacher = $form->getData();
    
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($teacher);
            $entityManager->flush();
            $this->addFlash(
                'notice',
                'Create teacher '.$teacher->getFullname().' success !'
            );
            return $this->redirectToRoute('teacher_list');
        }   

        return $this->render('teacher/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function edit(Request $request, int $id)
    {
        $teacher = $this->getDoctrine()->getManager()->getRepository(Teacher::class)->find($id);   

        $form = $this->createFormBuilder($teacher)
        ->add('fullname',TextType::class, array(
            'attr' => array(
                'class' => 'form-control'
            ),
        ))
        ->add('dateofbirth', DateType::class, array(
            'attr' => array(
                'class' => 'form-control'
            )))
        ->add('create', SubmitType::class, array(
            'label' => 'Update Teacher',
            'attr' => array(
                'class' => 'btn btn-primary'
            )))
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $teacher = $form->getData();
    
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($teacher);
            $entityManager->flush();
            $this->addFlash(
                'notice',
                'Update teacher '.$teacher->getFullname().' success !'
            );
            return $this->redirectToRoute('teacher_list');
        }   

        return $this->render('teacher/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    public function delete(int $id)
    {    
        $entityManager = $this->getDoctrine()->getManager();        
        $teacher = $entityManager->getRepository(Teacher::class)->find($id);   
        $this->addFlash(
            'notice',
            'Delete teacher '.$teacher->getFullname().' success !'
        );
        $entityManager->remove($teacher);
        $entityManager->flush();

        
        return $this->redirectToRoute('teacher_list');
    }
}
