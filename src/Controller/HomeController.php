<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(Request $request)
    {        
        if($request->cookies->get('user_name') != null){
            return $this->render('home/index.html.twig', [
                'controller_name' => 'HomeController',
            ]);
        }
        else{
            return $this->redirectToRoute('loginpage');
        }
        
    }
}
