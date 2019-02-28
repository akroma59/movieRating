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
use App\Form\EvaluationType;


class EvaluationController extends AbstractController
{
    /**
     * @Route("/update/eval/{id}", name="update.eval")
     */
    public function updateEval(Evaluation $evaluation, Request $request)
    {
      $entityManager = $this->getDoctrine()->getManager();

      $form = $this->createForm(EvaluationType::class, $evaluation);

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $data = $form->getData();
        $evaluation->setGrade($data->getGrade());
        $evaluation->setComment($data->getComment());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($evaluation);
        $entityManager->flush();
        return $this->redirectToRoute('profil.id');
        dump($data);
      }
    
        return $this->render('test/update.html.twig', [
        'form' => $form->createView() 
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

        $form = $this->createForm(EvaluationType::class, $eval);

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








?>