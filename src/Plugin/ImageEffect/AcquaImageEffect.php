<?php
/**
 * @file
 * Contains \Drupal\imagefield_effects\Plugin\ImageEffect.
 */
namespace Drupal\imagefield_effects\Plugin\ImageEffect;

use Drupal\Core\Image\ImageInterface;
use Drupal\image\ImageEffectBase;

/**
 * Acqua (grayscale yellow) an image resource.
 *
 * @ImageEffect(
 *   id = "image_acqua",
 *   label = @Translation("Acqua"),
 *   description = @Translation("Acqua converts an image to grayscale yellow.")
 * )
 */
class AcquaImageEffect extends ImageEffectBase {

  /**
   * {@inheritdoc}
   */
  public function applyEffect(ImageInterface $image) {
    if (!$image->apply('colorize', array(
      'red' => 50,
      'blue' => 100,
      'green' => 0
    ))
    ) {
      $this->logger->error('Image colorize failed using the %toolkit toolkit on %path (%mimetype, %dimensions)', array(
        '%toolkit' => $image->getToolkitId(),
        '%path' => $image->getSource(),
        '%mimetype' => $image->getMimeType(),
        '%dimensions' => $image->getWidth() . 'x' . $image->getHeight()
      ));
      return FALSE;
    }
    return TRUE;
  }

}
