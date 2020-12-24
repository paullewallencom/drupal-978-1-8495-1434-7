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
.article-1 {
    background-color: #ffaaaa;
    font-size: 14pt;
    border: 4px solid black
}
.article-2 {
    background-color: #aaffaa;
    font-size: 12pt;
    border: 4px solid black
}
.article-3 {
    background-color: #aaaaff;
    font-size: 10pt;
    border: 4px solid black
}
.node {border: 0}
</style>
<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
<table id="articles-table">
    <tr>
        <td rowspan="2" class="article-1"><?php print $rows[0];?></td>
        <td class="article-2"><?php print $rows[1];?></td>
    </tr>
    <tr>
        <td class="article-3"><?php print $rows[2];?></td>
    </tr>
</table>