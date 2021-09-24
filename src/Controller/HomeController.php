<?php

namespace App\Controller;

use App\Entity\TypeVoiture;
use App\Entity\Voiture;
use App\Form\FormVoitureType;
use App\Repository\TypeVoitureRepository;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Config\Doctrine\Orm\EntityManagerConfig;
use Symfony\Component\HttpFoundation\Request;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(VoitureRepository $repository): Response
    {
        $voiture = $repository->findAll();
        dump($voiture);

        $form = $this->createForm(FormVoitureType::class);


        return $this->render('home/index.html.twig', [
            'voitures' => $voiture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/contact ", name="contact")
     */
    public function contact(VoitureRepository $repository): Response
    {

        return $this->render('home/contact.html.twig');
    }
    /*
       /**
        * @Route("/typeVoiture/{id}", name="edite")
        */
    //name="edite" c'est ce qui va nous permettre de passer à une autre page

   /*
    public function edites($id, TypeVoitureRepository $repository, Voiture $repository2)
    {


        $form = $this->createForm(FormVoitureType::class);

        $typeVoiture = $repository2->getIdTypeVoiture();

        $libelleVoiture = $repository->findOneBy(['id' => $typeVoiture]);
        dump($libelleVoiture);

        return $this->render('home/edite.html.twig', [
            'voitures' => $repository2,
            'form' => $form->createView()

        ]);

    }*/

    /**
     * @Route("/typeVoiture/{id}", name="edite")
     */
    public function editer(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $voiture = $entityManager->getRepository(Voiture::class)->find($id);
        $form = $this->createForm(FormVoitureType::class, $voiture);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->flush();

            return $this->redirectToRoute("home");
        }

        return $this->render("home/edite.html.twig", [
            "form_title" => "Modifier un produit",
            "formEdite" => $form->createView(),
        ]);
    }

       /**
        * @Route("/voiture", name="ajouter")
        */
        public function ajouter (Request $request) : Response
        {
            $voiture = new Voiture();
            $form = $this->createForm(FormVoitureType::class, $voiture);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid())
            {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($voiture);
                $entityManager->flush();

                return $this->redirectToRoute("home");
            }

            return $this->render('home/voitureAjouter.html.twig', [
                "form_title" => "Ajouter un produit",
                "formAjouter" => $form->createView(),

            ]);
        }

        /**
         * @Route("/delete/{id}", name="delete")
         */
        public function deleteVoiture(int $id): Response
        {
            $entityManager = $this->getDoctrine()->getManager();
            $voiture = $entityManager->getRepository(Voiture::class)->find($id);
            $entityManager->remove($voiture);
            $entityManager->flush();

            return $this->redirectToRoute("home");
        }



}
