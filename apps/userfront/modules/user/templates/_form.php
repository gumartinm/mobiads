<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('user/update?id='.$form->getObject()->getId()) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <fieldset>
  <legend><?php echo __('YOUR DATA') ?></legend>
  <table>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <?php echo $form['first_name']->renderRow(array('class' => 'required')) ?>
      <?php echo $form['last_name']->renderRow(array('class' => 'required')) ?>
      <?php echo $form['email_address']->renderRow(array('class' => 'required')) ?>
      <?php echo $form['language_id']->renderRow(array('class' => 'validate-selection')) ?>
    </tbody>
  </table>
  </fieldset>
   <?php echo $form->renderHiddenFields(false) ?>
   &nbsp;
    <table align="right">
        <tbody>
            <tr>
            <td>
                <a href="<?php echo url_for('user/index') ?>" class="bt_red"><strong><?php echo __('Back') ?></strong></a>
            </td>
            <td>
                <input type="submit" value="<?php echo __('Save') ?>" class="NFButton">
            </td>
            </tr>
        </tbody>
    </table>
</form>
