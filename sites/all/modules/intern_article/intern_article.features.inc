<?php

/**
 * Implementation of hook_ctools_plugin_api().
 */
function intern_article_ctools_plugin_api() {
  list($module, $api) = func_get_args();
  if ($module == "strongarm" && $api == "strongarm") {
    return array("version" => 1);
  }
}

/**
 * Implementation of hook_node_info().
 */
function intern_article_node_info() {
  $items = array(
    'article' => array(
      'name' => t('专访'),
      'module' => 'features',
      'description' => t('企业或实习生专访'),
      'has_title' => '1',
      'title_label' => t('标题'),
      'has_body' => '1',
      'body_label' => t('内容'),
      'min_word_count' => '50',
      'help' => '',
    ),
  );
  return $items;
}
