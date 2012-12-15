<?php use_helper('I18N') ?>
<h1><?php echo __('Oops! You do not have proper credentials. Try again.', null, 'sf_guard') ?></h1>

<?php echo get_component('sfGuardAuth', 'signin_form') ?>
