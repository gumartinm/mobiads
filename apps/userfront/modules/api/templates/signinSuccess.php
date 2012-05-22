<?php use_helper('I18N') ?>

<h1><center><?php echo __('Mobi-Ads Login', null, 'sf_guard') ?></center></h1>

<?php echo get_partial('sfGuardAuth/signin_form', array('form' => $form)) ?>
