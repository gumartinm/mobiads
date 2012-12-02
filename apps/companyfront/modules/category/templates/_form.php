<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('category/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <fieldset>
  <legend><?php echo __('GENERAL CATEGORY AND PARENT COMPANY CATEGORY') ?></legend>
  <table>
    <tbody>
            <?php echo $form['general_categ_id']->renderRow(array('class' => 'validate-selection')) ?>
            <?php echo $form['general_categ_id']->renderError() ?>
            <?php echo $form['parent_category']->renderRow(array('class' => 'validate-selection')) ?>
            <?php echo $form['parent_category']->renderError() ?>
            <?php echo $form['company_categ_name']->renderRow(array('class' => 'required')) ?>
            <?php echo $form['company_categ_name']->renderError() ?>
            <?php echo $form['company_categ_description']->renderRow(array('class' => 'required')) ?>
            <?php echo $form['company_categ_description']->renderError() ?>
    </tbody>
  </table>
  <?php echo $form->renderGlobalErrors() ?>
  <?php echo $form->renderHiddenFields(false) ?>
  </fieldset>
  &nbsp;
  <table align="right">
        <tbody>
            <tr>
            <td>
                <a href="<?php echo url_for('category/index?page=') ?>" class="bt_red"><strong><?php echo __('Back to list') ?></strong></a>
            </td>
            <td>
                <input type="submit" value="<?php echo __('Update') ?>" class="NFButton">
            </td>
            </tr>
        </tbody>
   </table>
</form>
