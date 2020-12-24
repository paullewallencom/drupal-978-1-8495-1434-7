<?php
// $Id:
/**
 * Implements hook_views_data_alter()
 */
function d7vrzch_views_data_alter(&$data) {
    //drupal_set_message('<pre>'.print_r($data,1).'</pre>');
  $data['field_data_field_zip_code']['entity_id']['field']['handler'] = 'd7vrzch_handler_field_zip_code';
}
/**
 * Implements hook_views_handlers() to register all of the basic handlers
 * views uses.
 */
function d7vrzch_views_handlers() {
  return array(
    'handlers' => array(
      'd7vrzch_handler_field_zip_code' => array(
        'parent' => 'views_handler_field',
      ),
    ),
  );
}
