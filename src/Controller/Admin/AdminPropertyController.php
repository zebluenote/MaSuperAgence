<?php
namespace App\Controller\Admin;

use App\Entity\Property;
use App\Entity\Option;
use App\Form\PropertyType;
use App\Form\OptionType;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class AdminPropertyController extends AbstractController
{

  /**
   * @var PropertyRepository
   */
    private $repository;
  /**
   * @var ObjectManager
   */
    private $om;

    public function __construct(PropertyRepository $repository, ObjectManager $om)
    {
        $this->repository = $repository;
        $this->om = $om;
    }

    /**
     * @Route("/admin", name="admin.property.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $properties = $this->repository->findAll();
        return $this->render('admin/property/index.html.twig', compact('properties'));
    }

    /**
     * @Route("admin/property/create", name="admin.property.new")
     */
    public function new(Request $request)
    {
      $property = new Property();
      $form = $this->createForm(PropertyType::class, $property);
      $form->handleRequest($request);

      if ( $form->isSubmitted() && $form->isValid() ) {
        $this->om->persist($property);
        $this->om->flush();
        $this->addFlash('success', 'Ce bien a été enregistré avec succès.');
        return $this->redirectToRoute('admin.property.index');
      }

      return $this->render('admin/property/new.html.twig', [
        'property' => $property,
        'form' => $form->createView()
      ]);
    }

    /**
     * @Route("/admin/property/{id}", name="admin.property.edit", requirements={"id": "[0-9]*"}, methods="GET|POST")
     * @param Property $property
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Property $property, Request $request)
    {

      $form = $this->createForm(PropertyType::class, $property);
      $form->handleRequest($request);

      if ( $form->isSubmitted() && $form->isValid() ) {
        $this->om->flush();
        $this->addFlash('success', 'Ce bien a été modifié avec succès.');
        return $this->redirectToRoute('admin.property.index');
      }

      return $this->render('admin/property/edit.html.twig', [
        'property' => $property,
        'form' => $form->createView()
      ]);
    }

    /**
     * @Route("/admin/property/{id}", name="admin.property.delete", requirements={"id": "[0-9]*"}, methods="DELETE")
     * @param Property $property
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Property $property, Request $request)
    {
      if ( $this->isCsrfTokenValid('delete'.$property->getId(), $request->get('_token')) ) {
        $this->om->remove($property);
        $this->om->flush();
        $this->addFlash('success', 'Ce bien a été supprimé avec succès.');
      }
      return $this->redirectToRoute('admin.property.index');
    }

}
