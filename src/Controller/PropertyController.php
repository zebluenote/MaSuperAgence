<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 */
class PropertyController extends AbstractController
{

  /**
   * @var PropertyRepository
   */
  private $repository;

  function __construct(PropertyRepository $repository)
  {
    $this->repository = $repository;
  }

  /**
   * @Route("/biens", name="property.index")
   * @return Response
   */
  public function index(): Response
  {
    return $this->render('property/index.html.twig',[
      'current_menu' => 'properties'
    ]);
  }


  /**
   * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
   * @param Property $property
   * @return Response
   */
  public function show(Property $property, string $slug): Response
  {
    // $property = $this->repository->find($id);
    if ( $property->getSlug() !== $slug )
    {
      return $this->redirectToRoute('property.show',[
        'id' => $property->getId(),
        'slug' => $property->getSlug()
      ], 301); // 301 : Permanent redirection
    }
    return $this->render('property/show.html.twig', [
      'property' => $property,
      'current_menu' => 'properties'
    ]);
  }

}
