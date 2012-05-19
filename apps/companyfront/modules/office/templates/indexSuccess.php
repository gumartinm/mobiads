<h2><?php echo __('Offices Index') ?></h2>

<?php if ($pager->haveToPaginate()): ?>
    <?php include_partial('office/list', array('offices' => $pager->getResults(), 'page' => $pager->getPage(), 'sort' => $sort)) ?>
<?php else: ?>
    <?php include_partial('office/list', array('offices' => $pager->getResults(), 'page' => '1', 'sort' => $sort)) ?>
<?php endif; ?>


<?php if ($pager->haveToPaginate()): ?>
  <div class="pagination">
    <a href="<?php echo url_for('offices_index') ?>?page=1&sort=<?php echo $sort ?>"><?php echo __('first page') ?></a>

    <a href="<?php echo url_for('offices_index') ?>?page=<?php echo $pager->getPreviousPage() ?>&sort=<?php echo $sort ?>"><?php echo __('<< prev') ?></a>

    <?php foreach ($pager->getLinks() as $page): ?>
      <?php if ($page == $pager->getPage()): ?>
        <?php echo $page ?>
      <?php else: ?>
        <a href="<?php echo url_for('offices_index') ?>?page=<?php echo $page ?>&sort=<?php echo $sort ?>"><?php echo $page ?></a>
      <?php endif; ?>
    <?php endforeach; ?>

    <a href="<?php echo url_for('offices_index') ?>?page=<?php echo $pager->getNextPage() ?>&sort=<?php echo $sort ?>"><?php echo __('next >>') ?></a>

    <a href="<?php echo url_for('offices_index') ?>?page=<?php echo $pager->getLastPage() ?>&sort=<?php echo $sort ?>"><?php echo __('last page') ?></a>
  </div>
<?php endif; ?>

<?php if ($pager->haveToPaginate()): ?>
    <a href="<?php echo url_for('office/new?page='.$pager->getPage().'&sort='.$sort) ?>" class="bt_green"><span class="bt_green_lft"></span><strong><?php echo __('Create new Office') ?></strong><span class="bt_green_r"></span></a>
<?php else: ?>
    <a href="<?php echo url_for('office/new?page=1'.'&sort='.$sort) ?>" class="bt_green"><span class="bt_green_lft"></span><strong><?php echo __('Create new Office') ?></strong><span class="bt_green_r"></span></a>
<?php endif; ?>
