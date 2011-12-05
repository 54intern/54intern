<?php
  /**
   * The logout link for the user meta block
   *
   * We need this to make it translatable
   */
?>
<?php global $user; ?>
<?php print l(t('Logout'), 'logout'); ?> | <?php print l(t('My account'), "user/{$user->uid}"); ?>
