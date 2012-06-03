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
            <?php echo $form['company_logo']->renderError() ?>
            <?php echo $form['company_cif']->renderRow(array('class' => 'required')) ?>
            <?php echo $form['company_cif']->renderError() ?>
    </tbody>
  </table>
  <fieldset>
  <legend class="optional"><?php echo __('INTERNATIONALIZATION') ?></legend>
  <table id="rounded-cornergus">
  <thead>
    <tr>
        <th> </th>
        <th scope="col" class="rounded-companygus"><?php echo __('Language') ?></th>
        <th scope="col" class="roundedgus"><?php echo __('Company Name') ?></th>
        <th scope="col" class="rounded-q4gus"><?php echo __('Remove') ?></th>
    </tr>
  </thead>
  <tbody>
    <?php if (isset($form['new'])): ?>
    <tr>
    <td><?php echo __('New Entry:') ?></td>
    <td>
        <?php echo $form['new']['language_id']->render(array('class' => 'validate-selection')) ?>
        <?php echo $form['new']['language_id']->renderError() ?>
    </td>
    <td>
        <?php echo $form['new']['company_name']->render(array('class' => 'required')) ?>
        <?php echo $form['new']['company_name']->renderError() ?>
        <?php echo $form['new']['id'] ?>
        <?php echo $form['new']['id']->renderError() ?>
    </td>
    <td>
    </td>
    </tr>
    <?php endif; ?>
    <?php foreach ($form['CompanyDescription'] as $companyDescription): ?>
    <tr>
    <td><?php echo __('Current Entry:') ?></td>
    <td>
        <?php echo $companyDescription['language_id']->render(array('class' => 'validate-selection')) ?>
        <?php echo $companyDescription['language_id']->renderError() ?>
    </td>
    <td>
        <?php echo $companyDescription['company_name']->render(array('class' => 'required')) ?>
        <?php echo $companyDescription['company_name']->renderError() ?>
    </td>
    <td>
        <?php echo $companyDescription['delete'] ?>
        <?php echo $companyDescription['delete']->renderError() ?>
        <?php echo $companyDescription['id'] ?>
        <?php echo $companyDescription['id']->renderError() ?>
    </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
  </table>
  <?php echo $form->renderHiddenFields(false) ?>
  </fieldset>
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
