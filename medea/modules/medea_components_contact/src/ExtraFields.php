<?php

namespace Drupal\medea_components_contact;

use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityFormBuilderInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ExtraFields.
 */
class ExtraFields implements ExtraFieldsInterface {
  use StringTranslationTrait;
  /**
   * Service entity_type.manager.
   *
   * @var Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Service entity.form_builder.
   *
   * @var Drupal\Core\Entity\EntityFormBuilderInterface
   */
  protected $formBuilder;

  /**
   * Constructs a new ExtraFields object.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, EntityFormBuilderInterface $form_builder) {
    $this->entityTypeManager = $entity_type_manager;
    $this->formBuilder = $form_builder;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      // Load the services required to construct this class.
      $container->getParameter('entity_type.manager'),
      $container->getParameter('entity.form_builder')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function entityExtraFieldInfo() {
    $extra = [];

    $extra['paragraph']['contact_form']['display']['contact_form'] = [
      'label' => 'Contact form',
      'description' => 'Render webform contact form. Pseudo_field created on the medea_components_contact module.',
      'weight' => 0,
      'visible' => TRUE,
    ];

    return $extra;
  }

  /**
   * {@inheritdoc}
   */
  public function paragraphView(array &$build, EntityInterface $entity, EntityViewDisplayInterface $display, $view_mode) {
    // Generate the view for employee_list field.
    if (!$display->getComponent('contact_form')) {
      return;
    }

    // Get the contact form.
    $form = $this->entityTypeManager->getStorage('webform')->load('contact')->getSubmissionForm();

    $build['contact_form'] = $form;
  }


}
