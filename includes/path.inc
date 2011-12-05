<?php

/**
 * @file
 * Functions to handle paths in Drupal, including path aliasing.
 *
 * These functions are not loaded for cached pages, but modules that need
 * to use them in hook_init() or hook exit() can make them available, by
 * executing "drupal_bootstrap(DRUPAL_BOOTSTRAP_PATH);".
 */

/**
 * Initialize the $_GET['q'] variable to the proper normal path.
 */
function drupal_init_path() {
  if (!empty($_GET['q'])) {
    $_GET['q'] = drupal_get_normal_path(trim($_GET['q'], '/'));
  }
  else {
    $_GET['q'] = drupal_get_normal_path(variable_get('site_frontpage', 'node'));
  }
}

/**
 * Given an alias, return its Drupal system URL if one exists. Given a Drupal
 * system URL return one of its aliases if such a one exists. Otherwise,
 * return FALSE.
 *
 * @param $action
 *   One of the following values:
 *   - wipe: delete the alias cache.
 *   - alias: return an alias for a given Drupal system path (if one exists).
 *   - source: return the Drupal system URL for a path alias (if one exists).
 * @param $path
 *   The path to investigate for corresponding aliases or system URLs.
 * @param $path_language
 *   Optional language code to search the path with. Defaults to the page language.
 *   If there's no path defined for that language it will search paths without
 *   language.
 *
 * @return
 *   Either a Drupal system path, an aliased path, or FALSE if no path was
 *   found.
 */
function drupal_lookup_path($action, $path = '', $path_language = '') {
  global $language;
  // $map is an array with language keys, holding arrays of Drupal paths to alias relations
  /*
  static $map = array(), $no_src = array(), $count;
  */
  static $map = array(), $no_src = array();
  $path_language = $path_language ? $path_language : $language->language;
  
  // ************* Begin pathcache.module Path Caching Modifications **************

  // Drupal core checks to see if the url_alias table is empty on each request.
  // We assume that the table is nonempty, since it would be very silly to enable
  // the Path Cache module if you had no paths to cache. Thus, we have eliminated
  // the $count variable altogether.
  /* 
  
  // Use $count to avoid looking up paths in subsequent calls if there simply are no aliases
  if (!isset($count)) {
    $count = (int)db_result(db_query('SELECT pid FROM {url_alias} LIMIT 1'));
  }
  */

  // A wipe is most commonly performed by path_set_alias() in path.module via 
  // drupal_clear_path_cache() in common.inc. The intent it to clear the static
  // variables $map and $no_src, but we can also use it as an indicator that
  // the path cache is dirty.
  if ($action == 'wipe') {
    $map = array();
    $no_src = array();
    // This will flush the entire cache_path cache.
    // Drastic, but if running with a memcached caching backend, wildcards
    // are not supported so the whole bin must be flushed.
    cache_clear_all('*', 'cache_pathdst', TRUE);
    cache_clear_all('*', 'cache_pathsrc', TRUE);
  }
  elseif ($path != '') {
    // When action is 'alias' we are given a Drupal path and are looking to
    // see if there is an alias for it.
    if ($action == 'alias') {
      // First check the static variable in case we've looked up this system path earlier
      // in this request.
      if (isset($map[$path_language][$path])) {
        return $map[$path_language][$path];
      }
      // Not in the static variable. Try cache.
      $cid = $path . $path_language;
      $cache = cache_get($cid, 'cache_pathdst');
      if ($cache) {
        $map[$path_language][$path] = $cache->data;
        return $cache->data;
      }
      // Get the most fitting result falling back with alias without language.      
      $alias = db_result(db_query("SELECT dst FROM {url_alias} WHERE src = '%s' AND language IN('%s', '') ORDER BY language DESC", $path, $path_language));
      // Store in static variable in case we encounter the same system path again
      // during this request.
      $map[$path_language][$path] = $alias;
      // Store in cache.
      cache_set($cid, $alias, 'cache_pathdst', time() + variable_get('pathcache_expire', 43200)); // 12 hours
      return $alias;
    }
    // When action is 'source' we are given a URL alias and need to return the
    // Drupal path.
    // Check $no_src for this $path in case we've already determined that there
    // isn't a path that has this alias.
    elseif ($action == 'source' && !isset($no_src[$path_language][$path])) {
      $src = '';
      // Look for the value $path within the cached $map.
      if (!isset($map[$path_language]) || !($src = array_search($path, $map[$path_language]))) {
        $cid = $path . $path_language;
        $cache = cache_get($cid, 'cache_pathsrc');
        if ($cache) {
          $map[$path_language][$cache->data] = $path;
          return $cache->data;
        }
        
        // Get the most fitting result falling back with alias without language
        if ($src = db_result(db_query("SELECT src FROM {url_alias} WHERE dst = '%s' AND language IN('%s', '') ORDER BY language DESC", $path, $path_language))) {
          $map[$path_language][$src] = $path;
          cache_set($cid, $src, 'cache_pathsrc', time() + variable_get('pathcache_expire', 43200)); // 12 hours
        }
        else {
          // We can't record anything into $map because we do not have a valid
          // index and there is no need because we have not learned anything
          // about any Drupal path. Thus cache to $no_src.
          // Setting this flag makes the array_search($path, $map[$path_language]) test
          // above false, and skips to return $src, below.
          $no_src[$path_language][$path] = TRUE;
          // We cache that the src is the same as the dst so we don't have to fail
          // the cache hit and do a pointless query.
          cache_set($cid, $path, 'cache_pathsrc', time() + variable_get('pathcache_expire', 43200)); // 12 hours
        }
      }
      return $src;
    }
  }

  return FALSE;  
  // ************** End pathcache.module Path Caching Modifications ***************  
  
  // Use $count to avoid looking up paths in subsequent calls if there simply are no aliases
  if (!isset($count)) {
    $count = db_result(db_query('SELECT COUNT(pid) FROM {url_alias}'));
  }

  if ($action == 'wipe') {
    $map = array();
    $no_src = array();
    $count = NULL;
  }
  elseif ($count > 0 && $path != '') {
    if ($action == 'alias') {
      if (isset($map[$path_language][$path])) {
        return $map[$path_language][$path];
      }
      // Get the most fitting result falling back with alias without language
      $alias = db_result(db_query("SELECT dst FROM {url_alias} WHERE src = '%s' AND language IN('%s', '') ORDER BY language DESC, pid DESC", $path, $path_language));
      $map[$path_language][$path] = $alias;
      return $alias;
    }
    // Check $no_src for this $path in case we've already determined that there
    // isn't a path that has this alias
    elseif ($action == 'source' && !isset($no_src[$path_language][$path])) {
      // Look for the value $path within the cached $map
      $src = FALSE;
      if (!isset($map[$path_language]) || !($src = array_search($path, $map[$path_language]))) {
        // Get the most fitting result falling back with alias without language
        if ($src = db_result(db_query("SELECT src FROM {url_alias} WHERE dst = '%s' AND language IN('%s', '') ORDER BY language DESC, pid DESC", $path, $path_language))) {
          $map[$path_language][$src] = $path;
        }
        else {
          // We can't record anything into $map because we do not have a valid
          // index and there is no need because we have not learned anything
          // about any Drupal path. Thus cache to $no_src.
          $no_src[$path_language][$path] = TRUE;
        }
      }
      return $src;
    }
  }

  return FALSE;
}

/**
 * Given an internal Drupal path, return the alias set by the administrator.
 *
 * @param $path
 *   An internal Drupal path.
 * @param $path_language
 *   An optional language code to look up the path in.
 *
 * @return
 *   An aliased path if one was found, or the original path if no alias was
 *   found.
 */
function drupal_get_path_alias($path, $path_language = '') {
  $result = $path;
  if ($alias = drupal_lookup_path('alias', $path, $path_language)) {
    $result = $alias;
  }
  return $result;
}

/**
 * Given a path alias, return the internal path it represents.
 *
 * @param $path
 *   A Drupal path alias.
 * @param $path_language
 *   An optional language code to look up the path in.
 *
 * @return
 *   The internal path represented by the alias, or the original alias if no
 *   internal path was found.
 */
function drupal_get_normal_path($path, $path_language = '') {
  $result = $path;
  if ($src = drupal_lookup_path('source', $path, $path_language)) {
    $result = $src;
  }
  if (function_exists('custom_url_rewrite_inbound')) {
    // Modules may alter the inbound request path by reference.
    custom_url_rewrite_inbound($result, $path, $path_language);
  }
  return $result;
}

/**
 * Return a component of the current Drupal path.
 *
 * When viewing a page at the path "admin/content/types", for example, arg(0)
 * would return "admin", arg(1) would return "content", and arg(2) would return
 * "types".
 *
 * Avoid use of this function where possible, as resulting code is hard to read.
 * Instead, attempt to use named arguments in menu callback functions. See the
 * explanation in menu.inc for how to construct callbacks that take arguments.
 *
 * @param $index
 *   The index of the component, where each component is separated by a '/'
 *   (forward-slash), and where the first component has an index of 0 (zero).
 * @param $path
 *   A path to break into components. Defaults to the path of the current page.
 *
 * @return
 *   The component specified by $index, or NULL if the specified component was
 *   not found. If called without arguments, it returns an array containing all
 *   the components of the current path.
 */
function arg($index = NULL, $path = NULL) {
  static $arguments;

  if (!isset($path)) {
    $path = $_GET['q'];
  }
  if (!isset($arguments[$path])) {
    $arguments[$path] = explode('/', $path);
  }
  if (!isset($index)) {
    return $arguments[$path];
  }
  if (isset($arguments[$path][$index])) {
    return $arguments[$path][$index];
  }
}

/**
 * Get the title of the current page, for display on the page and in the title bar.
 *
 * @return
 *   The current page's title.
 */
function drupal_get_title() {
  $title = drupal_set_title();

  // during a bootstrap, menu.inc is not included and thus we cannot provide a title
  if (!isset($title) && function_exists('menu_get_active_title')) {
    $title = check_plain(menu_get_active_title());
  }

  return $title;
}

/**
 * Set the title of the current page, for display on the page and in the title bar.
 *
 * @param $title
 *   Optional string value to assign to the page title; or if set to NULL
 *   (default), leaves the current title unchanged.
 *
 * @return
 *   The updated title of the current page.
 */
function drupal_set_title($title = NULL) {
  static $stored_title;

  if (isset($title)) {
    $stored_title = $title;
  }
  return $stored_title;
}

/**
 * Check if the current page is the front page.
 *
 * @return
 *   Boolean value: TRUE if the current page is the front page; FALSE if otherwise.
 */
function drupal_is_front_page() {
  static $is_front_page;

  if (!isset($is_front_page)) {
    // As drupal_init_path updates $_GET['q'] with the 'site_frontpage' path,
    // we can check it against the 'site_frontpage' variable.
    $is_front_page = ($_GET['q'] == drupal_get_normal_path(variable_get('site_frontpage', 'node')));
  }

  return $is_front_page;
}

/**
 * Check if a path matches any pattern in a set of patterns.
 *
 * @param $path
 *   The path to match.
 * @param $patterns
 *   String containing a set of patterns separated by \n, \r or \r\n.
 *
 * @return
 *   1 if there is a match, 0 if there is not a match.
 */
function drupal_match_path($path, $patterns) {
  static $regexps;

  if (!isset($regexps[$patterns])) {
    $regexps[$patterns] = '/^('. preg_replace(array('/(\r\n?|\n)/', '/\\\\\*/', '/(^|\|)\\\\<front\\\\>($|\|)/'), array('|', '.*', '\1'. preg_quote(variable_get('site_frontpage', 'node'), '/') .'\2'), preg_quote($patterns, '/')) .')$/';
  }
  return preg_match($regexps[$patterns], $path);
}
