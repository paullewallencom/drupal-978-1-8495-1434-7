<?php
// $Id: views-view-table.tpl.php,v 1.8 2009/01/28 00:43:43 merlinofchaos Exp $
/**
 * @file views-view-table.tpl.php
 * Template to display a view as a table.
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $header: An array of header labels keyed by field id.
 * - $fields: An array of CSS IDs to use for each field id.
 * - $class: A class or classes to apply to the table, based on settings.
 * - $row_classes: An array of classes to apply to each row, indexed by row
 *   number. This matches the index in $rows.
 * - $rows: An array of row items. Each row is an array of content.
 *   $rows are keyed by row number, fields within rows are keyed by field ID.
 * @ingroup views_templates
 */
?>
<?php
$header['title'] = 'Title';
$header['Article'] = 'Article';
$header['Country'] = 'Country';
$header['Course'] = 'Course';
$header['Employee'] = 'Employee';
$header['Extension'] = 'Extension';
$header['Other'] = 'Other';
$fields['Article'] = 'type';
$fields['Country'] = 'type';
$fields['Course'] = 'type';
$fields['Employee'] = 'type';
$fields['Extension'] = 'type';
$fields['Other'] = 'type';

foreach ($rows as $count => $row) {
    $rows[$count]['Article'] = '&nbsp;';
    $rows[$count]['Country'] = ' ';
    $rows[$count]['Course'] = ' ';
    $rows[$count]['Employee'] = ' ';
    $rows[$count]['Extension'] = ' ';
    $rows[$count]['Other'] = ' ';
    $type = (in_array($row['type'],array('Article','Country','Course','Employee','Extension'))) ? $row['type'] : 'Other';
    $rows[$count][$type] = ($type == 'Other') ? $rows[$count]['type'] : 'X';
    unset($rows[$count]['type']);
}
unset($header['type']);
?>
<table class="<?php print $class; ?>">
  <?php if (!empty($title)) : ?>
    <caption><?php print $title; ?></caption>
  <?php endif; ?>
  <thead>
    <tr>
      <?php foreach ($header as $field => $label): ?>
        <th class="views-field views-field-<?php print $fields[$field]; ?>">
          <?php print $label; ?>
        </th>
      <?php endforeach; ?>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($rows as $count => $row): ?>
      <tr class="<?php print implode(' ', $row_classes[$count]); ?>">
        <?php foreach ($row as $field => $content): ?>
          <td class="views-field views-field-<?php print $fields[$field]; ?>">
            <?php print $content; ?>
          </td>
        <?php endforeach; ?>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
