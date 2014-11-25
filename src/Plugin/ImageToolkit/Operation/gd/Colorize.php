<?php

/**
 * @file
 * Contains \Drupal\image_effects\Plugin\ImageToolkit\Operation\gd\Colorize.
 */

namespace Drupal\image_effects\Plugin\ImageToolkit\Operation\gd;

use Drupal\Core\ImageToolkit\GDImageToolkitOperationBase;
use Drupal\Component\Utility\String;

/**
 * Defines GD2 colorize operation.
 *
 * @ImageToolkitOperation(
 *   id = "gd_colorize",
 *   toolkit = "gd",
 *   operation = "colorize",
 *   label = @Translation("Colorize"),
 *   description = @Translation("Apply colorize filter to the image")
 * )
 */

class Colorize extends GDImageToolkitOperationBase {

  /**
   * {@inheritdoc}
   */
  protected function arguments() {
    return array(
      'red' => array(
        'description' => 'The red component',
      ),
      'blue' => array(
        'description' => 'The blue component',
      ),
      'green' => array(
        'description' => 'The green component',
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function validateArguments(array $arguments) {
    // Assure integers for all arguments.
    $arguments['red'] = (int) round($arguments['red']);
    $arguments['blue'] = (int) round($arguments['blue']);
    $arguments['green'] = (int) round($arguments['green']);

    // Fail when width or height are 0 or negative.
    if ($arguments['red'] <= 0 || $arguments['red'] > 255) {
      throw new \InvalidArgumentException(String::format("Invalid (@value) specified for the image red component", array('@value' => $arguments['red'])));
    }
    if ($arguments['blue'] <= 0 || $arguments['blue'] > 255) {
      throw new \InvalidArgumentException(String::format("Invalid (@value) specified for the image blue component", array('@value' => $arguments['blue'])));
    }
    if ($arguments['green'] <= 0 || $arguments['green'] > 255) {
      throw new \InvalidArgumentException(String::format("Invalid (@value) specified for the image green component", array('@value' => $arguments['green'])));
    }

    return $arguments;
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(array $arguments = array()) {
    // Create a new resource of the required dimensions, and copy and resize
    // the original resource on it with resampling. Destroy the original
    // resource upon success.
    $original_resource = $this->getToolkit()->getResource();
    $data = array(
      'red' => $arguments['red'],
      'blue' => $arguments['blue'],
      'green' => $arguments['green'],
      'extension' => image_type_to_extension($this->getToolkit()->getType(), FALSE),
      'transparent_color' => $this->getToolkit()->getTransparentColor()
    );
    if ($this->getToolkit()->apply('create_new', $data)) {
      if (imagefilter($original_resource,IMG_FILTER_COLORIZE,$arguments['red'],$arguments['blue'],$arguments['green'])) {
        return TRUE;
      }
    }
    return FALSE;
  }

}
