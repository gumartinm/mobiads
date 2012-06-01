<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('office/'.($form->getObject()->isNew() ? 'create' : 'update').'?page='.$page.'&sort='.$sort.(!$form->getObject()->isNew() ? '&id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <fieldset>
  <legend><?php echo __('OFFICE') ?></legend>
  <table>
    <tbody> 
        <?php echo $form->renderGlobalErrors() ?>
        <?php echo $form->renderHiddenFields(false) ?>
        <?php echo $form['city_id']->renderRow(array('class' => 'validate-selection')) ?>
        <?php echo $form['office_street_address']->renderRow(array('class' => 'required')) ?>
        <?php echo $form['office_zip']->renderRow(array('class' => 'required')) ?>
        <?php echo $form['longitude']->renderRow(array('class' => 'required')) ?>
        <?php echo $form['latitude']->renderRow(array('class' => 'required')) ?>
    <tbody>
  </table>
  </fieldset>
  <table align="right">
        <tbody>
            <tr>
            <td>
                <a href="<?php echo url_for('office/index?page='.$page.'&sort='.$sort) ?>" class="bt_red"><strong><?php echo __('Back to list') ?></strong></a>
            </td>
            <td>
                <input type="submit" value="<?php echo __('Save') ?>" class="NFButton">
            </td>
            </tr>
        </tbody>
   </table>
</form>
