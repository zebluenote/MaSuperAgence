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

    // Exemple d'enregistrement d'un bien dans la base
    // $property = new Property();
    // $property->setTitle('Mon deuxième bien')
    //   ->setPrice(450000)
    //   ->setRooms(5)
    //   ->setBedrooms(3)
    //   ->setDescription('Une autre petite description')
    //   ->setSurface(85)
    //   ->setFloor(4)
    //   ->setHeat(0)
    //   ->setCity('Gif-sur-Yvette')
    //   ->setAddress('10 avenue du Général Leclerc')
    //   ->setPostalCode('91190');
    // $em = $this->getDoctrine()->getManager();
    // $em->persist($property);
    // $em->flush();

    $prop = $this->repository->findAll();
    dump($prop);


    // return new Response("Liste des biens");
    return $this->render('property/index.html.twig',[
      'current_menu' => 'properties'
    ]);
  }

}
