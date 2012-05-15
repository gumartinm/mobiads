<h2><?php echo __('Ads List') ?></h2>

<form action="<?php echo url_for('ad/indexLanguage') ?>" method="post" <?php $formLanguage->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <table>
    <tbody>
      <tr>
        <td><?php echo $formLanguage->renderHiddenFields(false) ?></td>
        <td><?php echo $formLanguage ?></td>
        <td><input type="submit" value=<?php echo __('Update') ?> /></td>
      </tr>
    </tbody>
  </table>
</form>

<?php include_partial('ad/list', array('ads' => $pager->getResults())) ?>

<?php if ($pager->haveToPaginate()): ?>
  <div class="pagination">
    <a href="<?php echo url_for('ads_index') ?>?page=1"><?php echo __('first page') ?></a>

    <a href="<?php echo url_for('ads_index') ?>?page=<?php echo $pager->getPreviousPage() ?>"><?php echo __('<< prev') ?></a>

    <?php foreach ($pager->getLinks() as $page): ?>
      <?php if ($page == $pager->getPage()): ?>
        <?php echo $page ?>
      <?php else: ?>
        <a href="<?php echo url_for('ads_index') ?>?page=<?php echo $page ?>"><?php echo $page ?></a>
      <?php endif; ?>
    <?php endforeach; ?>

    <a href="<?php echo url_for('ads_index') ?>?page=<?php echo $pager->getNextPage() ?>"><?php echo __('next >>') ?></a>

    <a href="<?php echo url_for('ads_index') ?>?page=<?php echo $pager->getLastPage() ?>"><?php echo __('last page') ?></a>
  </div>
<?php endif; ?>

  <a href="<?php echo url_for('ad/new') ?>" class="bt_green"><span class="bt_green_lft"></span><strong><?php echo __('Ad Office') ?></strong><span class="bt_green_r"></span></a>

