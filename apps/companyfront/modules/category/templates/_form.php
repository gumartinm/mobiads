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
    </tbody>
  </table>
  </fieldset>
  <fieldset>
  <legend class="optional"><?php echo __('INTERNATIONALIZATION') ?></legend>
  <table id="rounded-cornergus">
  <thead>
    <tr>
        <th> </th>
        <th scope="col" class="rounded-companygus"><?php echo __('Language') ?></th>
        <th scope="col" class="rounded-companygus"><?php echo __('Category Name and Description') ?></th>
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
        <?php echo $form['new']['company_categ_name']->render(array('class' => 'required')) ?>
        <?php echo $form['new']['company_categ_name']->renderError() ?>
        <?php echo $form['new']['company_categ_description']->render(array('class' => 'required')) ?>
        <?php echo $form['new']['company_categ_description']->renderError() ?>
        <?php echo $form['new']['id'] ?>
        <?php echo $form['new']['id']->renderError() ?>
    </td>
    <td></td>
    </tr>
  <?php endif; ?>
  <?php foreach ($form['CompanyCategoryDescription'] as $companyCategDescription): ?>
    <tr>
    <td><?php echo __('Current Entry:') ?></td>
    <td>
        <?php echo $companyCategDescription['language_id']->render(array('class' => 'validate-selection')) ?>
        <?php echo $companyCategDescription['language_id']->renderError() ?>
    </td>
    <td>
        <?php echo $companyCategDescription['company_categ_name']->render(array('class' => 'required')) ?>
        <?php echo $companyCategDescription['company_categ_name']->renderError() ?>
        <?php echo $companyCategDescription['company_categ_description']->render(array('class' => 'required')) ?>
        <?php echo $companyCategDescription['company_categ_description']->renderError() ?>
    </td>
    <td>
        <?php echo $companyCategDescription['delete'] ?>
        <?php echo $companyCategDescription['delete']->renderError() ?>
        <?php echo $companyCategDescription['id'] ?>
        <?php echo $companyCategDescription['id']->renderError() ?>
    </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
  </table>
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
