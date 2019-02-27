<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Movie;
use App\Entity\Evaluation;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TestController extends AbstractController
{


    /**
     * fonction fète pr tester ds trucs
     * @Route("/test", name="test")
     */
    public function test()
    {
        $movies = $this->getDoctrine()->getRepository(Movie::class)->findAll();
        //fonction qui essé de calc moyen note flm mais prblm
        // for ($i=0; $i < count($movies) ; $i++) {
        //   $notes = $movies[$i]->getEvaluations()->getGrade();
        // }
        return $this->render('test/index.html.twig', [
          "movies" => $movies
        ]);
    }

    /**
     * @Route("", name="index")
     */
    public function index()
    {
        $movies = $this->getDoctrine()->getRepository(Movie::class)->findAll();
        return $this->render('test/index.html.twig', [
          "movies" => $movies
        ]);
    }

    /**
     * @Route("/single/{id}", name="single_id")
     */
    public function show(Movie $movie)
    {
      $id = $movie->getId();
        return $this->render('test/single.html.twig', [
          "movie" => $movie, 
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/evaluation/{id}", name="evaluation_id")
     *
     */      
    public function rate(Movie $movie, Request $request)
    {
        $eval = new Evaluation();

        $form = $this->createFormBuilder($eval)
            ->add('comment', TextType::class)
            ->add('grade', IntegerType::class)
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          $eval->setMovie($movie);
          $eval->setUser($this->getUser());
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($eval);
          $entityManager->flush();
          return $this->redirectToRoute('index');

        }

        return $this->render('test/evaluation.html.twig', [
          "movie" => $movie,
          "form" => $form->createView()
        ]);
    }
}
