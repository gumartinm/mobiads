<?php use_helper('I18N') ?>

<form action="<?php echo url_for('@register_index') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <fieldset>
  <legend><?php echo __('REGISTER', null, 'sf_guard') ?></legend>
  <table>
    <tbody>
        <?php echo $form->renderGlobalErrors() ?>
        <?php echo $form->renderHiddenFields(false) ?>
        <?php echo $form['first_name']->renderRow(array('class' => 'required')) ?>
        <?php echo $form['last_name']->renderRow(array('class' => 'required')) ?>
        <?php echo $form['email_address']->renderRow(array('class' => 'required')) ?>
        <?php echo $form['username']->renderRow(array('class' => 'required')) ?>
        <?php echo $form['password']->renderRow(array('class' => 'required')) ?>
        <?php echo $form['password_again']->renderRow(array('class' => 'required')) ?>
        <?php echo $form['language_id']->renderRow(array('class' => 'validate-selection')) ?>
        <?php echo $form['new']['company_cif']->renderRow(array('class' => 'required')) ?>
        <?php echo $form['new']['company_logo']->renderRow(array('class' => 'required')) ?>
        <?php echo $form['new']['company_name']->renderRow(array('class' => 'required')) ?>
        <?php echo $form['captcha']->RenderRow() ?>
    </tbody>
  </table>
  </fieldset>
  <table align="right">
    <tbody>
        <tr>
        <td>
        <input type="submit" name="register" value="<?php echo __('Register', null, 'sf_guard') ?>" class="NFButton"/>
        </td>
        <tr>
    </tbody>
  </table>
</form>
