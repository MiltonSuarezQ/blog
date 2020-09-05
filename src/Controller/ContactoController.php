<?php

namespace App\Controller;

use App\Entity\Contacto;
use App\Form\ContactoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ContactoController extends AbstractController
{
    /**
     * @Route("/contacto", name="contacto")
     */
    public function index(Request $request, SluggerInterface $slugger)
    {
        $messagge = new Contacto();
        $form = $this->createForm(ContactoType::class, $messagge);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($messagge);
            $em->flush();
            $this->addFlash('mensaje','Mensaje enviado exitosamente');
            return $this->redirectToRoute('contacto');
        }
        return $this->render('contacto/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
