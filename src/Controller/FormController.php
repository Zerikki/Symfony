<?php

namespace App\Controller;

use Twig\Environment;
use App\Entity\Form;
use App\Form\FormFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormController extends AbstractController
{
    #[Route('/form', name: 'app_form')]
    public function show(Environment $twig, Request $request, EntityManagerInterface $entityManager)
    {
        $nom = new Form();

        $form = $this->createForm(FormFormType::class, $nom);

        $form->handleRequest($request);

        if ($form ->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($nom);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');

        }

        return new Response($twig->render('form/form.html.twig', [
            'Table_form' => $form->createView()
        ]));
    }
}
