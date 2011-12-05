+------------------------------------------------------------------------------+
|  Locale Cache module provides much better caching for locale strings.        |
|  You will probably get most benefits of this module only using a             |
|  fast cache backend like APC, Memcache, Redis, MongoDB, etc.                 |
|                                                                              |
|  Author: Andrey Tretyakov http://drupal.org/user/169459                      |
|  Based on code from the core D6 locale module.                               |                                             |
+------------------------------------------------------------------------------+

List of improvements over D6 core behavior

   1. Long strings are cached too in per-string entries, so after some time all 
      strings are in cache and we skip the database completely.
      This can result in significant performance gain if the cache backend is 
      much faster than database. At minimum, this can lower the load on your 
      database.
      
   2. Configurable string length limit for the main locale cache (like D7).
      Strings longer than the limit are "long" by the module terms. By changing 
      this value you can balance between the size of the main locale cache 
      (thus php memory usage), and number of additional per-string requests for 
      "long" strings.
      
   3. If a new string is found, the main locale cache entry is cleared (updated) 
      only if we are actually going to cache the string.
      Core mindlessly clears the cache without checking.
      
   4. Shorter version of string (a hash) can be used as an id for the main 
      locale cache entry.
      This can save some memory (both for php and for cache backend) and 
      bandwidth at the cost of processing time (calculating the hash). If for 
      some reason you are CPU-bound, it makes sense to keep this disabled.
      
   5. As a result of (4), long untranslated strings can be cached in the main 
      cache too.
      This feature can be both good and bad, depending on many factors. If you 
      want to minimize cache backend access at the cost of increased memory 
      usage, you can try to enable this. It only makes sense to enable this when
      hashing for source strings is enabled.
      
   6. Main locale cache can be set to rebuild only on cron.
      Say, you've added 100 new strings (that fit in the main cache) to your 
      site. In core, in a worst case scenario locale cache would rebuild 
      N=100 (!) times, resulting in a major load increase. With this feature 
      enabled, worst case scenario is 
      N =~ (total time to discover new strings) / (cron interval).
      Note that this feature doesn't break anything, it simply delays rebuilding 
      of the cache. New string translations keep working with only 
      difference: they are not cached until next rebuild.
      Turning this feature on is recommended for production systems, where most 
      translations are done, with only minor additions from time to time.
      
   7. Locale cache "stampede protection"
      While the locale cache is rebuilding, parallel requests still use the old 
      cache. In core parallel requests bombard the database during rebuild.

The module has several settings, stored in variables:

 'locale_cache_use_hash_id' (boolean)
    Whether to hash source strings for the main cache entry. 
    Default: FALSE (disabled)

 'locale_cache_include_long_untranslated' (boolean)
    Whether to include long untranslated string in the main cache entry.
    Strings are considered "long" if they are longer than 'locale_cache_length'.
    Default: FALSE (disabled)
  
 'locale_cache_length' (integer)
    Maximum length of source strings, which translations are going to be cached
    in the main locale cache.
    Default: 75
  
 'locale_cache_hashing_threshold' (integer)
    Strings longer than this will be hashed, if hashing is enabled.
    Default: 32

 'locale_cache_cron_rebuild' (boolean)
    Whether to use cron for rebuilding main locale cache.
    Default: FALSE (disabled)

 'locale_cache_debug_mode' (boolean)
    If TRUE, collects statistics about locale cache misses and time spent
    on fetching locale data. The statistics is printed at the bottom of the page
    for users with the "access devel information" permission.
    Default: FALSE (disabled)
 
 