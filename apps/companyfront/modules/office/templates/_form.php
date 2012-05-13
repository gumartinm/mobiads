<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('office/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<a href="<?php echo url_for('office/index') ?>">Back to list</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'office/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['company_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['company_id']->renderError() ?>
          <?php echo $form['company_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['city_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['city_id']->renderError() ?>
          <?php echo $form['city_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['office_gps']->renderLabel() ?></th>
        <td>
          <?php echo $form['office_gps']->renderError() ?>
          <?php echo $form['office_gps'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['office_street_address']->renderLabel() ?></th>
        <td>
          <?php echo $form['office_street_address']->renderError() ?>
          <?php echo $form['office_street_address'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['office_zip']->renderLabel() ?></th>
        <td>
          <?php echo $form['office_zip']->renderError() ?>
          <?php echo $form['office_zip'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['created_at']->renderLabel() ?></th>
        <td>
          <?php echo $form['created_at']->renderError() ?>
          <?php echo $form['created_at'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['updated_at']->renderLabel() ?></th>
        <td>
          <?php echo $form['updated_at']->renderError() ?>
          <?php echo $form['updated_at'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
