<?php
// $Id: views-view-field.tpl.php,v 1.1 2008/05/16 22:22:32 merlinofchaos Exp $
 /**
  * This template is used to print a single field in a view. It is not
  * actually used in default Views, as this is registered as a theme
  * function which has better performance. For single overrides, the
  * template is perfectly okay.
  *
  * Variables available:
  * - $view: The view object
  * - $field: The field handler object that can process the input
  * - $row: The raw SQL result that can be used
  * - $output: The processed output that will normally be used.
  *
  * When fetching output from the $row, this construct should be used:
  * $data = $row->{$field->field_alias}
  *
  * The above will guarantee that you'll always get the correct data,
  * regardless of any changes in the aliasing that might happen if
  * the view is modified.
  */
?>
<?php 
 $degree = 'normal';
 $field_values = split(',',$output);
 $nid = $field_values[1];
 $output = $field_values[0];  
 $has_comments = TRUE;
 if ($output==0){
 	$degree = 'none';
 	$has_comments = FALSE;
 	$output = t('no rates');
 } elseif ($output>=80){
 	$degree = 'great';
 } elseif ($output<60){
 	$degree = 'bad' ;
 }
?>
<div class="company-rate">

   <?php print t('Company Rating').':'?>

<span class="company-rate-value-<?php print $degree?>">    
    <?php print $output; ?>    
</span>
   <?php if($has_comments):?>
       <a href="/54intern/node/<?php print $nid?>/talk">
          <span title='<?php print t('view company comments')?>' class="view-comments">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
       </a>    
    <?php endif;?>
</div>

