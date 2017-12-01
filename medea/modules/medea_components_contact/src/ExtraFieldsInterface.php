<?php

namespace Drupal\medea_components_contact;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\Display\EntityViewDisplayInterface;

/**
 * Interface ExtraFieldsInterface.
 */
interface ExtraFieldsInterface {

  /**
   * Generates the array of extra fields.
   *
   * @see hook_entity_extra_field_info().
   */
  public function entityExtraFieldInfo();

  /**
   * Hook hook_ENTITY_TYPE_view() implementation.
   *
   * @see hook_ENTITY_TYPE_view().
   */
  public function paragraphView(array &$build, EntityInterface $entity, EntityViewDisplayInterface $display, $view_mode);
}
