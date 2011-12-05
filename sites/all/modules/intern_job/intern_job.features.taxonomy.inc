<?php

/**
 * Implementation of hook_taxonomy_default_vocabularies().
 */
function intern_job_taxonomy_default_vocabularies() {
  return array(
    'city' => array(
      'name' => '工作地点',
      'description' => '中国城市',
      'help' => '',
      'relations' => '1',
      'hierarchy' => '0',
      'multiple' => '1',
      'required' => '1',
      'tags' => '1',
      'module' => 'features_city',
      'weight' => '0',
      'nodes' => array(
        'job' => 'job',
      ),
    ),
    'degree' => array(
      'name' => '学历',
      'description' => '学历',
      'help' => '',
      'relations' => '1',
      'hierarchy' => '0',
      'multiple' => '1',
      'required' => '0',
      'tags' => '1',
      'module' => 'features_degree',
      'weight' => '0',
      'nodes' => array(
        'job' => 'job',
      ),
    ),
    'salary' => array(
      'name' => '薪水',
      'description' => '',
      'help' => '',
      'relations' => '1',
      'hierarchy' => '0',
      'multiple' => '0',
      'required' => '0',
      'tags' => '1',
      'module' => 'features_salary',
      'weight' => '0',
      'nodes' => array(
        'job' => 'job',
      ),
    ),
  );
}
