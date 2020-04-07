<?php

namespace App\Controller;

// use Symfony\Component\Form\Extension\Core\Type\FormType;
// use Symfony\Component\Form\Extension\Core\Type;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

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
  public function index(PaginatorInterface $paginator, Request $request): Response
  {
    // 1. Création manuelle d'une entité qui va représenter notre recherche
    //    src\Entity\PropertySearch.php

    // 2. Création via la console d'un formulaire
    //    php bin/console make:form
    //        name of the form class PropertySearchType
    //        name of Entity \App\Entity\PropertySearch
    //    fichier créé : src\Form\PropertySearchType.php
    //        compléter/paramétrer manuellement ce fichier

    // 3. Gérer le traitement dans ce controller
    $search = new PropertySearch();
    $form = $this->createForm(PropertySearchType::class, $search);
    $form->handleRequest($request);

    $properties = $paginator->paginate(
    $this->repository->findAllVisibleQuery($search),
    $request->query->getInt('page', 1),
    12
    );
    return $this->render('property/index.html.twig',[
      'current_menu' => 'properties',
      'properties' => $properties,
      'form' => $form->createView()
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
