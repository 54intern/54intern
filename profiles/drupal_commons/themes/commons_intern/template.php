<?php
// $Id: template.php 8021 2010-10-19 13:01:34Z sheena $

function commons_intern_commons_core_info_block() {
  $content = '';
  
  $content .= '<div id="acquia-footer-message">';

  $content .= '<a href="http://localhost/54intern" title="' . t('Shixiquan Tech social business software') . '">';
  $content .= theme('image', 'profiles/drupal_commons/images/commons_droplet.png', t('Shixiquan Tech social business software'), t('Shixiquan Tech social business software'));
  $content .= '</a>';
  $content .= '<span>';
  $content .= '实习圈 @2011-2011 沪ICP证084383号';
  $content .= '</span>';
  $content .= '</div>';

  return $content;
}
