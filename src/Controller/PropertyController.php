<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 */
class PropertyController extends AbstractController
{

  function __construct()
  {
    // code...
  }

  /**
   * @Route("/biens", name="property.index")
   * @return Response
   */
  public function index(): Response
  {
    // return new Response("Liste des biens");
    return $this->render('property/index.html.twig',[
      'current_menu' => 'properties'
    ]);
  }

}
