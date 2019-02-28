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


class UserController extends AbstractController
{

    /**
     * @Route("/profil", name="profil.id")
     */
    public function profil()
    {
      $evals = $this->getDoctrine()->getRepository(Evaluation::class)->getEvalByUser($this->getUser());
      dump($evals);
      return $this->render('test/profil.html.twig', [
        'evals' => $evals,
      ]);
    }
}
