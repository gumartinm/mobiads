<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<?php use_javascript('/sfFormExtraPlugin/js/double_list.js') ?>

<form action="<?php echo url_for('office/'.($form->getObject()->isNew() ? 'createLink' : 'updateLink').'?officeId='.$officeId.(!$form->getObject()->isNew() ? '&id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<a href="<?php echo url_for('office/index?page='.$page.'&sort='.$sort) ?>"><?php echo __('Back to list') ?></a>
          <input type="submit" value=<?php echo __('Save') ?> />
        </td>
      </tr>
    </tfoot>
    <tbody>
        <?php echo $form ?>
    </tbody>
  </table>
</form>
