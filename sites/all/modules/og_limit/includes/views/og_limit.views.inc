<?php
// $Id: og_limit.views.inc,v 1.1.2.10 2011/01/13 05:54:54 hosszukalman Exp $
/**
 * @file
 *
 *
 *
 * @author Kálmán Hosszu - hosszu.kalman@gmail.com - http://www.kalman-hosszu.com
 */

/**
 * Implementation of hook_views_data().
 */
function og_limit_views_data() {
  $data = array();

  $data['og_limit']['table']['group'] = t('Organic groups limit');

  $data['og_limit']['table']['join'] = array(
    'node' => array(
      'left_field' => 'nid',
      'field' => 'nid',
    ),
  );

  $data['og_limit']['signup_limit'] = array(
    'title' => t('Organic groups join limit'),
    'help' => t('Number of join limit'),
    'field' => array(
      'handler' => 'views_handler_field_numeric',
      'click sortable' => TRUE,
    ),
    'filter' => array(
      'handler' => 'views_handler_filter_numeric',
    ),
    'sort' => array(
      'handler' => 'views_handler_sort',
    ),
    'argument' => array(
      'handler' => 'views_handler_argument_numeric',
    ),
  );

  return $data;
}