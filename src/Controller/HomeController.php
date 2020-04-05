<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
/**
 *
 */
class HomeController
{

  function __construct($twig)
  {
    $this->twig = $twig;
  }

  public function index(): Response {

    return new Response('Salut les gens');

  }

}
