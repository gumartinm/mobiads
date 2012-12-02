<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('company/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <fieldset>
  <legend><?php echo __('LOGO AND CIF') ?></legend>
  <table>
    <tbody>
            <?php echo $form['company_logo']->renderRow(array('class' => 'required')) ?>
            <?php echo $form['company_cif']->renderRow(array('class' => 'required')) ?>
            <?php echo $form['company_cif']->renderError() ?>
            <?php echo $form['company_name']->renderRow(array('class' => 'required')) ?>
            <?php echo $form['company_name']->renderError() ?>
    </tbody>
  </table>
  <?php echo $form->renderGlobalErrors() ?>
  <?php echo $form->renderHiddenFields(false) ?>
  </fieldset>
  <table align="right">
        <tbody>
            <tr>
            <td>
                <a href="<?php echo url_for('company/index') ?>" class="bt_red"><strong><?php echo __('Back') ?></strong></a>
            </td>
            <td>
                <input type="submit" value="<?php echo __('Update') ?>" class="NFButton">
            </td>
            </tr>
        </tbody>
    </table>
</form>
