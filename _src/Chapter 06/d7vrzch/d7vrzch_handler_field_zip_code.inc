<?php
// $Id: $

/**
 * Field handler to format a zip code.
 *
 * @ingroup views_field_handlers
 */
class d7vrzch_handler_field_zip_code extends views_handler_field_field 	{
  function option_definition() {
    $options = parent::option_definition();

    //$options['display_zip_totals'] = array('default' => FALSE);
	$options['display_zip_totals'] = array(
	  'contains' => array(
	    'display_zip_totals' => array('default' => FALSE),
	  )
	);

    return $options;
  }

  /**
   * Provide link to the page being visited.
   */
  function options_form(&$form, &$form_state) {
    parent::options_form($form, $form_state);
    $form['display_zip_totals'] = array(
      '#title' => t('Display Zip total'),
      '#description' => t('Appends in parenthesis the number of nodes containing the same zip code'),
      '#type' => 'checkbox',
      '#default_value' => !empty($this->options['display_zip_totals']),
    );
    $form['type'] = array(
      '#type' => 'select',
      '#title' => t('Formatter'),
      '#options' => array(
          t('Zip+4 or Zip'),
          t('Zip'),
          t('Alphanumeric')
      ),
      '#default_value' => $this->options['type'],
    );
  }

  function pre_render(&$values) {
    if (isset($this->view->build_info['summary']) || empty($values)) { // || !$this->defer_query) {
      return parent::pre_render($values);
    }
    static $entity_type_map;

    if (!empty($values)) {
      // Cache the entity type map for repeat usage.
      if (empty($entity_type_map)) {
        $entity_type_map = db_query('SELECT etid, type FROM {field_config_entity_type}')->fetchAllKeyed();
      }

      // Create an array mapping the Views values to their object types.
      $objects_by_type = array();

      foreach ($values as $key => $object) {
        // Derive the entity type. For some field types, etid might be empty.
        if (isset($object->{$this->aliases['etid']}) && isset($entity_type_map[$object->{$this->aliases['etid']}])) {
          $entity_type = $entity_type_map[$object->{$this->aliases['etid']}];
          $entity_id = $object->{$this->field_alias};
          $objects_by_type[$entity_type][$key] = $entity_id;
        }
      }

      // Load the objects.
      foreach ($objects_by_type as $entity_type => $oids) {
        $objects = entity_load($entity_type, $oids);

        foreach ($oids as $key => $entity_id) {
          $values[$key]->_field_cache[$this->field_alias] = array(
            'entity_type' => $entity_type,
            'object' => $objects[$entity_id],
          );
        }
      }
    }
  }
 
  function render($values) {
    $value = $values->_field_cache[$this->field_alias]['object']->{$this->definition['field_name']}['und'][0]['safe_value'];
    $newvalue = $this->_make_zip($value, $this->options['type']);

    if (!empty($this->options['display_zip_totals'])) {
        $result = db_query("SELECT count(*) AS recs FROM {field_data_field_zip_code} WHERE field_zip_code_value = :zip",array(':zip' => $value));
        foreach ($result as $item) {
        	$newvalue .= ' (' . $item->recs . ')';
        }
    }
    
    return $newvalue;
  }

  function _make_zip($value, $zip_type=2) {
  // remove the hyphen if present
  $zip = explode('-', $value);
  switch ($zip_type) {
          case 0: // zip+4 or zip depending on size
          	if (is_numeric($zip[0])) {
          		$value = $zip[0];
          		if (sizeof($zip) > 1) {
          			if (is_numeric($zip[1])) {
          				$value .= '-' . $zip[1];
          			}
          		} 
          		else {
          			if (strlen($zip[0]) > 5) {
          				$value = substr($zip[0],0,5);
          				if (strlen($zip[0]) == 9) {
          					$value .= '-' . substr($zip[0],5,4);
          				}
          			}
          		}
          	}
          	break;
          	case 1: // zip (trim to 5)
          		if (is_numeric($zip[0]) && strlen($zip[0] >= 5)) {
          			$value = substr($zip[0],0,5);
          		}
          		break;
          	case 2: // no format change
          		break;
          }
      return $value;
  }
}