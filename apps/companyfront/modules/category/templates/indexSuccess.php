<h2><?php echo __('Company Category Index') ?></h2>

<?php include_partial('category/list', array('company_categories' => $pager->getResults())) ?>

<?php if ($pager->haveToPaginate()): ?>
  <div class="pagination">
    <a href="<?php echo url_for('companycategories_index') ?>?page=1"><?php echo __('first page') ?></a>

    <a href="<?php echo url_for('companycategories_index') ?>?page=<?php echo $pager->getPreviousPage() ?>"><?php echo __('<< prev') ?></a>

    <?php foreach ($pager->getLinks() as $page): ?>
      <?php if ($page == $pager->getPage()): ?>
        <?php echo $page ?>
      <?php else: ?>
        <a href="<?php echo url_for('companycategories_index') ?>?page=<?php echo $page ?>"><?php echo $page ?></a>
      <?php endif; ?>
    <?php endforeach; ?>

    <a href="<?php echo url_for('companycategories_index') ?>?page=<?php echo $pager->getNextPage() ?>"><?php echo __('next >>') ?></a>

    <a href="<?php echo url_for('companycategories_index') ?>?page=<?php echo $pager->getLastPage() ?>"><?php echo __('last page') ?></a>
  </div>
<?php endif; ?>

<a href="<?php echo url_for('category/new') ?>" class="bt_green"><span class="bt_green_lft"></span><strong>Create new Category</strong><span class="bt_green_r"></span></a>
