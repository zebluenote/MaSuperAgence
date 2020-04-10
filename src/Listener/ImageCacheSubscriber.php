<?php
namespace App\Listener;

use App\Entity\Property;

use Doctrine\Common\EventSubscriber;

use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageCacheSubscriber implements EventSubscriber
{

  /**
   * @var CacheManager
   */
  private $cacheManager;

  /**
   * @var UploaderHelper
   */
  private $uploaderHelper;

  public function __construct(CacheManager $cacheManager, UploaderHelper $uploaderHelper)
  {
    $this->cacheManager = $cacheManager;
    $this->uploaderHelper = $uploaderHelper;
  }

  public function getSubscribedEvents()
  {
    return [
      'preRemove',
      'preUpdate'
    ];
  }

  /**
   * Traitement à effectuer sur le cache avant la suppression d'une entité
   */
  public function preRemove(LifecycleEventArgs $args)
  {
    $entity = $args->getEntity();
    // Si l'entité courante n'est pas de type Property (bien immobilier) alors on ne fait rien
    if ( !$entity instanceof Property ) {
      return;
    }
    $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
  }

  /**
   * Traitement à effectuer sur le cache avant de mettre à jour une entité
   */
  public function preUpdate(PreUpdateEventArgs $args)
  {
    $entity = $args->getEntity();
    dump($entity);
    // Si l'entité courante n'est pas de type Property (bien immobilier) alors on ne fait rien
    if ( !($entity instanceof Property) ) {
      dump(['entity is not an instance of Property']);
      return;
    }
    dump(['entity is an instance of Property']);
    // Si l'image associée est du type UploadedFile, cela signifie que l'on est en train d'uploader une nouvelle image pour le bien immobilier courant
    // alors on souhaite nettoyer le cache
    if ( $entity->getImageFile() instanceof UploadedFile ) {
      dump(['imageFile is an instance of UploadedFile']);
      dump($entity->getImageFile());
      dump($this->cacheManager);
      dump($this->uploaderHelper->asset($entity, 'imageFile'));
      if ( null !== $this->uploaderHelper->asset($entity, 'imageFile') ) {
        $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
      } else {
        dump(['imageFile is null']);
      }
    } else {
      dump(['imageFile is not an instance of UploadedFile']);
      dump($entity->getImageFile());
    }
  }

}
