<?php
// $Id: views-view-fields.tpl.php,v 1.6 2008/09/24 22:48:21 merlinofchaos Exp $
/**
 * @file views-view-fields.tpl.php
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->separator: an optional separator that may appear before a field.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
?>
<?php 
	global $base_url;
	$path = $base_url . '/' . file_stream_wrapper_get_instance_by_scheme('public')->getDirectoryPath() . '/';
  switch ($fields['type']->content) {
  case 'Article':
  	$fields['title']->content = "<img src='$path/article.png' />&nbsp;<a href='" . $fields['path']->content . "'>" . $fields['title']->content . "</a>";
  	break;
  case 'Country':
  	$fields['title']->content = "<img src='$path/country.png' />&nbsp;" . $fields['title']->content;
  	break;
  case 'Course':
  	$fields['title']->content .= "&nbsp;<a href='http://myschool.edu/courses/?course=" . $fields['nid']->content . "'><small>(more info)</small></a>";
  	break;
  case 'Extension':
  	$fields['title']->content = "<a href='" . $fields['path']->content . "'>" . $fields['title']->content . "</a>&nbsp;<img src='$path/phone.png' />";
  	break;
  case 'Employee':
  	$fields['title']->content = "<a href='" . $fields['path']->content . "'><img src='$path/employee.png' border='0' />&nbsp;" . $fields['title']->content . "</a>";
  	break;
  default:
  	break;
  }
  unset($fields['path']);
  unset($fields['nid']);
  unset($fields['type']);
?>
<?php foreach ($fields as $id => $field): ?>
  <?php if (!empty($field->separator)): ?>
    <?php print $field->separator; ?>
  <?php endif; ?>

  <<?php print $field->inline_html;?> class="views-field-<?php print $field->class; ?>">
    <?php if ($field->label): ?>
      <label class="views-label-<?php print $field->class; ?>">
        <?php print $field->label; ?>:
      </label>
    <?php endif; ?>
      <?php
      // $field->element_type is either SPAN or DIV depending upon whether or not
      // the field is a 'block' element type or 'inline' element type.
      ?>
      <<?php print $field->element_type; ?> class="field-content"><?php print $field->content; ?></<?php print $field->element_type; ?>>
  </<?php print $field->inline_html;?>>
<?php endforeach; ?>
