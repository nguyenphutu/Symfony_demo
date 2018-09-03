<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Student;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class StudentController extends AbstractController
{
    /**
     * @Route("/student", name="student")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();        
        $students = $entityManager->getRepository(Student::class)->findAll();

        return $this->render('student/index.html.twig', [
            'students' => $students,
        ]);
    }

    public function detail(int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();        
        $student = $entityManager->getRepository(Student::class)->find($id);

        return $this->render('student/detail.html.twig', [
            'student' => $student,
        ]);
    }

    public function create(Request $request)
    {
        $student =new Student();

        $form = $this->createFormBuilder($student)
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
            'label' => 'Create Student',
            'attr' => array(
                'class' => 'btn btn-primary'
            )))
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $student = $form->getData();
    
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($student);
            $entityManager->flush();
            $this->addFlash(
                'notice',
                'Create student '.$student->getFullname().' success !'
            );
            return $this->redirectToRoute('student_list');
        }   

        return $this->render('student/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function edit(Request $request, int $id)
    {
        $student = $this->getDoctrine()->getManager()->getRepository(Student::class)->find($id);   

        $form = $this->createFormBuilder($student)
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
            'label' => 'Update Student',
            'attr' => array(
                'class' => 'btn btn-primary'
            )))
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $student = $form->getData();
    
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($student);
            $entityManager->flush();
            $this->addFlash(
                'notice',
                'Update student '.$student->getFullname().' success !'
            );
            return $this->redirectToRoute('student_list');
        }   

        return $this->render('student/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    public function delete(int $id)
    {    
        $entityManager = $this->getDoctrine()->getManager();        
        $student = $entityManager->getRepository(Student::class)->find($id);   
        $this->addFlash(
            'notice',
            'Delete student '.$student->getFullname().' success !'
        );
        $entityManager->remove($student);
        $entityManager->flush();

        
        return $this->redirectToRoute('student_list');
    }
}
