<?php

/**
 * @file
 * Admin forms and pages.
 */

/**
 * Main Authcache configuration form
 */
function authcache_admin_config() {
  drupal_set_title(t('Authcache Configuration'));

  $form['roles'] = array(
    '#type' => 'fieldset',
    '#title' => t('Authcache Roles'),
    '#collapsible'   => TRUE,
  );
  $form['roles']['authcache_roles'] = array(
    '#title' => t('Enable caching for specified user roles'),
    '#description' => t('If no roles are selected, Authcache page caching will not be enabled.  Unchecked roles and the admin account (uid #1) will never be cached.'),
    '#type' => 'checkboxes',
    '#options' => _authcache_get_roles(TRUE),
    '#default_value' => variable_get('authcache_roles', array()),
  );

  $form['clear_sessions'] = array(
    '#title' => t('Invalidate all user sessions'),
    '#type'  => 'checkbox',
    '#description' => t('This is required when you first enable the Authcache module & anonymous caching, otherwise logged-in users may receive pages intended for anonymous visitors. All users will need to relogin after this.'),
  );

  $debug_all     = variable_get('authcache_debug_all', 0);
  $debug_users   = implode(', ', variable_get('authcache_debug_users', array()));
  $dev_query     = variable_get('dev_query', 0);
  $debug_page    = variable_get('authcache_debug_page', 0);

  $form['debug'] = array(
    '#type' => 'fieldset',
    '#title' => t('Authcache Debugging/Development'),
    '#description' => t("Debug mode will display the page's cache statistics, benchmarks, and Ajax calls."),
    '#collapsible' => TRUE,
    '#collapsed'   => (!$debug_all && !$debug_users && !$dev_query && !$debug_page),
  );
  $form['debug']['debug_all'] = array(
    '#title' => t('Enable debug mode for all roles.'),
    '#type' => 'checkbox',
    '#default_value' => $debug_all,
  );
  $form['debug']['debug_users'] = array(
    '#title' => t('Enable for specified users'),
    '#type' => 'textfield',
    '#description' => t('Enter a comma-delimited list of usernames to enable debug mode for.'),
    '#autocomplete_path' => 'user/autocomplete',
    '#default_value' => $debug_users,
  );
  $form['debug']['dev_query'] = array(
    '#title' => t('Benchmark database queries'),
    '#type' => 'checkbox',
    '#description' => t("This will display the number of queries used, query time, and the percentage related to the page's total render time."),
    '#default_value' => $dev_query,
  );
  $form['debug']['debug_page'] = array(
    '#title' => t('Disable saving pages to cache, but still serve "cached" pages'),
    '#type' => 'checkbox',
    '#description' => t('This prevents pages from being saved to the cache, but renders pages the same as if they were cached. This is useful during development if you find yourself manually clearing the cache too often.'),
    '#default_value' => $debug_page,
  );

  $form['adv'] = array(
    '#type' => 'fieldset',
    '#title' => t('Advanced'),
    '#collapsible' => TRUE,
    '#collapsed'   => (!variable_get('authcache_post', 0) && !variable_get('authcache_http200', 0) && !variable_get('authcache_noajax', 0)),
  );
  $form['adv']['noajax'] = array(
    '#type' => 'checkbox',
    '#title' => t("Don't cache Drupal Ajax requests"),
    '#default_value' => variable_get('authcache_noajax', 0),
    '#description' => t("Disable caching of Ajax requests, such as autocomplete."),
  );
  $form['adv']['http200'] = array(
    '#type' => 'checkbox',
    '#title' => t('Only cache HTTP 200 OK pages (exclude 404, 403, etc)'),
    '#default_value' => variable_get('authcache_http200', 0),
    '#description' => t("It's recommended to cache all Drupal pages, though error response pages can be excluded if required."),
  );
  $form['adv']['post'] = array(
    '#type' => 'radios',
    '#title' => t('Authcache Ajax Method (GET vs POST)'),
    '#options' => array(0 => 'Automatic', 1 => 'POST'),
    '#default_value' => variable_get('authcache_post', 0),
    '#description' => t('Automatic will use GET for the Authcache Ajax request and POST if the request is over 2,000 characters. You can explicitly require POST if needed, though GET is faster.'),
  );

  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Save & clear cached pages'),
  );

  //
  // Status messages
  //

  if (substr(variable_get('cache_inc', FALSE), -13) != 'authcache.inc') {
    drupal_set_message(t('Your settings.php file must be modified to enable Authcache ($conf[\'cache_inc\']). See <a href="@url">README.txt</a>.', array('@url' => base_path() . drupal_get_path('module', 'authcache') . '/README.txt')), 'error');
  }

  if (!variable_get('page_compression', TRUE)) {
    drupal_set_message(t('Note: Page compression is not enabled!  It is strongly recommend that you <a href="./../performance">turn this setting on</a> through Drupal to lower your cache memory and allow for faster page response times.'), 'warning');
  }

  return $form;
}


/**
 * Authcache config form submit
 */
function authcache_admin_config_validate($form, &$form_state) {

}

/**
 * Authcache config form submit
 */
function authcache_admin_config_submit($form, &$form_state) {
  global $user;

  $debug_user_ray = $cache_roles = array();

  // Roles
  $roles = $form_state['values']['authcache_roles'];
  foreach ($roles as $rid => $is_checked) {
    if ($is_checked) $cache_roles[$rid] = $rid;
  }

  // Debugging for users
  $debug_users = explode(',', $form_state['values']['debug_users']);
  foreach ($debug_users as $username) {
    $debug_user_ray[] = trim($username);
  }
  $form_state['values']['debug_users'] = $debug_user_ray;

  // Define/update page caching settings if needed
  $pagecaching = variable_get('authcache_pagecaching', FALSE);

  // Not defined, first config submit
  if (!$pagecaching) {
    variable_set('authcache_pagecaching', array(array(
      'option' => 0,
      'pages' => AUTHCACHE_NOCACHE_DEFAULT,
      'roles' => $cache_roles)
      ));
  }
  // User may have added new role; apply new roles to first page ruleset, just to be safe
  elseif ($cache_roles != variable_get('authcache_roles', $cache_roles)) {
    $pagecaching[0]['roles'] = $cache_roles;
    variable_set('authcache_pagecaching', $pagecaching);
  }

  // Clear sessions, except current user
  if ($form_state['values']['clear_sessions']) {
    db_query("DELETE FROM {sessions} WHERE sid <> '%s'", session_id());
    // Set cookie for current user
    authcache_user('login', $edit = NULL, $user);
    drupal_set_message(t('!num user sessions have been invalidated.', array('!num' => db_affected_rows())));
  }

  // Forcibly disable Drupal's built-in SQL caching (no need to cache page twice for anonymous users!)
  if (in_array(DRUPAL_ANONYMOUS_RID, $cache_roles) && variable_get('cache', CACHE_DISABLED) != CACHE_DISABLED) {
    variable_set('cache', CACHE_DISABLED);
    drupal_set_message(t("Drupal's built-in page caching for anonymous users has been disabled to avoid redundant caching."));
  }

  // Devel query logging
  variable_set('dev_query', $form_state['values']['dev_query']);


  // Delete variable if not in use
  foreach (array('debug_all', 'debug_page', 'debug_users', 'post', 'http200', 'noajax') as $key) {
    if ($value = $form_state['values'][$key]) {
      variable_set("authcache_{$key}", $value);
    }
    else {
      variable_del("authcache_{$key}");
    }
  }

  variable_set('authcache_roles', $cache_roles);

  drupal_set_message(t('Your Authcache settings have been saved.'));

  cache_clear_all('*', 'cache_page', TRUE);
  drupal_set_message(t('Cached pages cleared.'));
}


/**
 * Add new page caching rule to form (part of AHAH)
 */
function _authcache_pagecache_form($details) {
  $form['#tree'] = TRUE;
  $delta = $details['delta'];

  $roles = user_roles();
  $roles[DRUPAL_AUTHENTICATED_RID] .= t(' (without additional roles)');

  // Cacheability settings
  $options = array(t('Cache every page except the listed pages.'), t('Cache only the listed pages.'));
  $description = t("To delete this ruleset, leave the textbox empty.") . ' ' . t("Enter one page per line as Drupal paths. The '*' character is a wildcard. Example paths are '%blog' for the blog page and %blog-wildcard for every personal blog. %front is the front page.", array('%blog' => 'blog', '%blog-wildcard' => 'blog/*', '%front' => '<front>'));
  if (user_access('use PHP for block visibility')) {
    $options[] = t('Cache pages for which the following PHP code returns <code>TRUE</code> (PHP-mode, experts only).');
    $description .= t('If the PHP-mode is chosen, enter PHP code between %php. Note that executing incorrect PHP-code can severely break your Drupal site.', array('%php' => '<?php ?>'));
  }
  $form['fieldset'] = array(
    '#type'          => 'fieldset',
    '#title'         => t('Caching Ruleset') . '#' . ($delta + 1),
    '#collapsible'   => TRUE,
  );
  $form['fieldset']['option'] = array(
    '#type'          => 'radios',
    '#title'         => t('Cache specified pages'),
    '#options'       => $options,
    '#default_value' => $details['option'],
  );

  $form['fieldset']['pages'] = array(
    '#type'          => 'textarea',
    '#title'         => t('Pages'),
    '#description'   => $description,
    '#default_value' => $details['pages'],
  );
  $form['fieldset']['roles'] = array(
    '#title' => 'Apply to these roles',
    '#type' => 'checkboxes',
    '#options' => _authcache_get_roles(),
    '#default_value' => (is_array($details['roles'])) ? $details['roles'] : array(),
  );

  return $form;

}

/**
 * Page caching rules form
 */
function authcache_admin_pagecaching($form_state, $ahah_form = array()) {
  drupal_set_title(t('Authcache Page Caching Settings'));
  drupal_add_css(drupal_get_path('module', 'authcache') .'/authcache.css', 'module');

  if (!count(variable_get('authcache_roles', array()))) {
    drupal_set_message(t('You must first select roles to cache before defining page caching setting.'), 'error');
    return $form;
  }

  $form['#cache'] = TRUE;

  // The contents of ahah_form will either come from the db or from $form_state
  if (isset($form_state['ahah_form'])) {
    $ahah_form = $form_state['ahah_form'] + (array)$ahah_form;
  }

  // Default values
  if (empty($ahah_form)) {
    $ahah_form['ahah_form'] = variable_get('authcache_pagecaching', array(array()));
  }

  $form['ahah_wrapper'] = array(
    '#tree' => FALSE,
    '#prefix' => '<div class="clear-block" id="ahah-wrapper">',
    '#suffix' => '</div>',
  );

  $form['ahah_wrapper']['ahah']['#tree'] = TRUE;


  foreach ($ahah_form['ahah_form'] as $delta => $details) {
    $details = (isset($details['fieldset'])) ? $details['fieldset'] : $details; // fieldset inserted from AHAH postback
    $details['delta'] = $delta;

    $form['ahah_wrapper']['ahah'][$delta] = _authcache_pagecache_form($details);
  }

  // AHAH-enabled "Add" button
  $form['authcache_add_cache'] = array(
    '#type' => 'submit',
    '#value' => t('Add new ruleset') . '...',
    '#description' => t("If the above ruleset isn't, click here to add more choices."),
    '#submit' => array('authcache_ahah_add'),
    '#ahah' => array(
      'path' => 'authcache/ahah',
      'wrapper' => 'ahah-wrapper',
      'method' => 'replace',
      'effect' => 'fade',
    ),
    '#attributes' => array('class' => 'authcache-add'),
  );

  $form['nonhtmlfs'] = array(
    '#type' => 'fieldset',
    '#collapsible' => TRUE,
    '#collapsed' => (variable_get('authcache_nonhtml', AUTHCACHE_NONHTML_DEFAULT) == AUTHCACHE_NONHTML_DEFAULT),
    '#title' => t('Non-HTML Cached Pages'),
    '#description' => t('JavaScript is appended at the end of pages to support Ajax callbacks and page manipulation ("var authcacheFooter"). If you are experiencing issues for some content, you may disable this by entering pages below that you wish to cache but do not want JavaScript appended to.'),
    '#prefix' => '<br><hr size="1"><br>',
  );
  $form['nonhtmlfs']['nonhtml'] = array(
    '#type' => 'textarea',
    '#description' => t("Enter one page per line as Drupal paths. The '*' character is a wildcard. Example paths are '%blog' for the blog page and %blog-wildcard for every personal blog. %front is the front page. Content that begins with <code>&lt;?xml</code> (i.e., XML feeds) will not be cached. ", array('%blog' => 'blog', '%blog-wildcard' => 'blog/*', '%front' => '<front>')),
    '#default_value' => variable_get('authcache_nonhtml', AUTHCACHE_NONHTML_DEFAULT),
  );

  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Save & clear cached pages'),
    '#prefix' => '<br><hr size="1"><br>',
  );

  return $form;
}

/**
 * Page caching rules form submit
 */
function authcache_admin_pagecaching_submit($form, &$form_state) {

  // Ignore AHAH events
  if ($form_state['clicked_button']['#id'] == 'edit-submit') {
    $pagecaching = array();

    foreach ($form_state['values']['ahah'] as $key => $ray) {
      $values = $ray['fieldset'];
      if ($values['pages']) {
        $pagecaching[$key] = $values;
      }
      if (!array_sum($values['roles'])) {
        drupal_set_message(t('Ruleset #!key is disabled since no roles are associated with it.', array('!key' => ($key + 1))), 'warning');
      }
    }

    if (!empty($pagecaching)) {
      variable_set('authcache_pagecaching', $pagecaching);
    }
    else {
      variable_set('authcache_pagecaching', array(
        array(
          'option' => 0,
          'pages' => AUTHCACHE_NOCACHE_DEFAULT,
          'roles' => $cache_roles)
        )
      );
    }

    variable_set('authcache_nonhtml', $form_state['values']['nonhtml']);

    drupal_set_message(t('Your page caching settings have been saved.'));
    cache_clear_all();
    drupal_set_message(t('Cached pages cleared.'));

  }
}

/**
 * Authcache Ajax Blocks
 */
function authcache_admin_blocks() {
  drupal_set_title(t('Authcache Ajax Blocks'));

  if (!variable_get('block_cache', FALSE)) {
    drupal_set_message(t('Drupal core block cache is currently disabled. It is recommened you <a href="@performance_link">enable it</a>.', array('@performance_link' => url('admin/settings/performance'))), 'warning');
  }

  $form['#suffix'] = '';
  $form['#prefix'] = '<p>' .
    t('!blocks may be configured to load during the Authcache Ajax phase. This is useful for dynamic or user-centric content.', array('!blocks' => l(t('Blocks'), 'admin/build/block'))) .
    '</p><p>' .
    t('There is a performance disadvantage, however, as uncached blocks require a full Drupal bootstrap by loading all Drupal files and modules, increasing server load. To improve performance, blocks may be cached server-side (<a href="@performance_link">@is_enabled</a>) and locally on the user\'s browser by using "Minimum cache lifetime" on the block configuration page. This option also prevents jumpiness when navigating across pages.', array('@performance_link' => url('admin/settings/performance'), '@is_enabled' => variable_get('block_cache', FALSE) ? t('currently enabled') : t('currently disabled')))
    . '</p>';
  $blocks = array();
  $q = db_query("SELECT module,delta,region,title FROM {blocks} ORDER BY region, weight, module");
  while ($r = db_fetch_object($q)) {
    $blocks["$r->module-$r->delta"] = $r;
  }

  $header = array(t('Region'), t('Block'), t('Cache Lifetime'));
  $rows = array();

  if ($authcache_block = variable_get('authcache_block', array())) {
    foreach ($authcache_block as $block_id => $lifetime) {
      if (isset($blocks[$block_id])) {
        $block = $blocks[$block_id];

        if (!$block->title) {
          $info = module_invoke($block->module, 'block', 'list');
          if (isset($info[$block->delta])) {
            $block->title = $info[$block->delta]['info'];
          }
        }

        if (!$block->region) {
          $block->region = '<em>' . t('disabled') . '</em>';
        }

        $rows[] = array(
          $block->region,
          l($block->title, "admin/build/block/configure/$block->module/$block->delta", array('query' => array('destination' => 'admin/settings/performance/authcache/blocks'))),
          $lifetime . ' ' . t('seconds'),
        );

      }
    }
    $form['#suffix'] = theme('table', $header, $rows);
  }

  $form['#suffix'] .= '<em>' . t('To add an Authcache Ajax block, visit the !blocks page and click "configure" next to the block.', array('!blocks' => l(t('Blocks'), 'admin/build/block'))) . '</em>';
  return $form;
}


/**
 * Advanced Rulesets
 * @todo
 */
function authcache_admin_advanced() {
  drupal_set_title(t('Authcache Advanced Rulesets'));
  $form = array();

  if (!count(variable_get('authcache_roles', array()))) {
    drupal_set_message(t('You must first select roles to cache before setting up advanced caching.'), 'error');
    return $form;
  }

  $form['#prefix'] = 'test';
  return $form;
}

/**
 * @todo View all cached pages?
 */
function authcache_admin_lookup() {

}



/**
 * Generic AHAH menu callback (['#ahah']['path'])
 */
function authcache_ahah() {
  $form_state = array('storage' => NULL, 'submitted' => FALSE);
  $form_build_id = $_POST['form_build_id'];
  $form = form_get_cache($form_build_id, $form_state);
  $args = $form['#parameters'];
  $form_id = array_shift($args);
  $form['#post'] = $form_state['post'] = $_POST;
  $form['#redirect'] = $form['#programmed'] = FALSE;
  drupal_process_form($form_id, $form, $form_state);
  $form = drupal_rebuild_form($form_id, $form_state, $args, $form_build_id);
  $ahah_form = $form['ahah_wrapper']['ahah'];
  unset($ahah_form['#prefix'], $ahah_form['#suffix']); // Prevent duplicate wrappers.
  drupal_json(array(
    'status'   => TRUE,
    'data'     => theme('status_messages') . drupal_render($ahah_form),
  ));
}

/**
 * Generic AHAH add
 */
function authcache_ahah_add($form, &$form_state) {
  if (isset($form_state['values']['ahah'])) {
    $ahah_form['ahah_form'] = $form_state['values']['ahah'];
  }

  $ahah_form['ahah_form'][] = array();

  unset($form_state['submit_handlers']);
  form_execute_handlers('submit', $form, $form_state);
  $form_state['ahah_form'] = $ahah_form;
  $form_state['rebuild'] = TRUE;
}

/**
 * Helper function, get authcache user roles
 * @param $all_roles = return all user roles
 * @return array of user roles
 */
function _authcache_get_roles($all_roles = FALSE) {
  $roles = user_roles();
  $roles[DRUPAL_AUTHENTICATED_RID] .= t(' (without additional roles)');
  if ($all_roles) {
    return $roles;
  }
  else {
    $authcache_roles = array();
    foreach (variable_get('authcache_roles', array()) as $key) {
      $authcache_roles[$key] = $roles[$key];
    }
    return $authcache_roles;
  }
}
