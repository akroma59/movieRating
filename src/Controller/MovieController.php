<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Movie;
use App\Entity\User;
use App\Entity\Evaluation;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class MovieController extends AbstractController
{

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
      $bestEvals = $this->getDoctrine()->getRepository(Evaluation::class)->getBestEval($movie);
      $worstEvals = $this->getDoctrine()->getRepository(Evaluation::class)->getWorstEval($movie);
        return $this->render('test/single.html.twig', [
          "movie" => $movie, "bestEvals" => $bestEvals, "worstEvals" => $worstEvals
        ]);
    }
}
