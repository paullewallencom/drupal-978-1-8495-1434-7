<?php
// $Id: views-view-unformatted.tpl.php,v 1.6.6.1 2010/03/29 20:05:38 dereine Exp $
/**
 * @file views-view-unformatted.tpl.php
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<style type="text/css">
#cc-container {
  width: 180px;
}
.cc-odd, .cc-even {
  padding: 6px;
  border: 4px solid black;
  width: 120px;
  position: relative;
  text-align: center;
}
.cc-odd {
  left: 0;
  background-color: #aaa;
}
.cc-even {
  left: 60px;
  background-color: #eee;
}
.cc-value {
  font-size: 36px;
}
</style>
<?php $ctr = sizeof($rows) + 1; ?>
<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
  <div id="cc-container">
<?php foreach ($rows as $id => $row): ?>
  <div class="cc-<?php echo ($ctr % 2) ? 'odd' : 'even'; ?>">
      <?php $ctr--; ?>
      <div class="cc-value"><?php echo $ctr; ?></div>
      <div class="<?php print $classes_array[$id]; ?>">
        <?php print $row; ?>
      </div>
  </div>
<?php endforeach; ?>
  </div>