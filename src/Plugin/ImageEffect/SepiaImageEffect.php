<?php
/**
 * @file
 * Contains \Drupal\imagefield_effects\Plugin\ImageEffect.
 */

namespace Drupal\imagefield_effects\Plugin\ImageEffect;

use Drupal\Core\Image\ImageInterface;
use Drupal\image\ImageEffectBase;


/**
 * Sepia (grayscale yellow) an image resource.
 *
 * @ImageEffect(
 *   id = "image_sepia",
 *   label = @Translation("Sepia"),
 *   description = @Translation("Sepia converts an image to grayscale yellow.")
 * )
 */
class SepiaImageEffect extends ImageEffectBase {

  /**
   * {@inheritdoc}
   */
  public function applyEffect(ImageInterface $image) {
    if (!$image->desaturate()) {
      $this->logger->error('Image desaturate failed using the %toolkit toolkit on %path (%mimetype, %dimensions)', array('%toolkit' => $image->getToolkitId(), '%path' => $image->getSource(), '%mimetype' => $image->getMimeType(), '%dimensions' => $image->getWidth() . 'x' . $image->getHeight()));
      return FALSE;
    }
    if (!$image->apply('colorize',100,50,0)) {
      $this->logger->error('Image sepia failed using the %toolkit toolkit on %path (%mimetype, %dimensions)', array('%toolkit' => $image->getToolkitId(), '%path' => $image->getSource(), '%mimetype' => $image->getMimeType(), '%dimensions' => $image->getWidth() . 'x' . $image->getHeight()));
      return FALSE;
    }
    return TRUE;
  }

}
