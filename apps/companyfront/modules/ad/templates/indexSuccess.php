<h2><?php echo __('Ads List') ?></h2>

<script type="text/javascript">
    $(document).ready(function(){
        $('#languageselect_id').change(function() {
            $('#chooselanguage').submit();
        });
    });
</script>

<form id="chooselanguage" action="<?php echo url_for('ad/indexLanguage') ?>" method="post" <?php $formLanguage->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<table align="right">
    <tr>
    <td>
        <?php echo $formLanguage->renderHiddenFields(false) ?>
        <?php echo $formLanguage['id']->render(array('class' => 'validate-selection')) ?>
    </td>
    <tr>
</table>
</form>



<?php if ($pager->haveToPaginate()): ?>
    <?php include_partial('ad/list', array('ads' => $pager->getResults(), 'userLanguageId' => $userLanguageId, 'page' => $pager->getPage())) ?>
<?php else: ?>
    <?php include_partial('ad/list', array('ads' => $pager->getResults(), 'userLanguageId' => $userLanguageId, 'page' => '1')) ?>
<?php endif; ?>


<?php if ($pager->haveToPaginate()): ?>
  <div class="pagination">
    <a href="<?php echo url_for('ads_index') ?>?page=1&language=<?php echo $languageCode ?>"><?php echo __('first page') ?></a>

    <a href="<?php echo url_for('ads_index') ?>?page=<?php echo $pager->getPreviousPage() ?>&language=<?php echo $languageCode ?>"><?php echo __('<< prev') ?></a>

    <?php foreach ($pager->getLinks() as $page): ?>
      <?php if ($page == $pager->getPage()): ?>
        <?php echo $page ?>
      <?php else: ?>
        <a href="<?php echo url_for('ads_index') ?>?page=<?php echo $page ?>&language=<?php echo $languageCode ?>"><?php echo $page ?></a>
      <?php endif; ?>
    <?php endforeach; ?>

    <a href="<?php echo url_for('ads_index') ?>?page=<?php echo $pager->getNextPage() ?>&language=<?php echo $languageCode ?>"><?php echo __('next >>') ?></a>

    <a href="<?php echo url_for('ads_index') ?>?page=<?php echo $pager->getLastPage() ?>&language=<?php echo $languageCode ?>"><?php echo __('last page') ?></a>
  </div>
<?php endif; ?>


<?php if ($pager->haveToPaginate()): ?>
    <a href="<?php echo url_for('ad/new?page='.$pager->getPage()) ?>" class="bt_green"><span class="bt_green_lft"></span><strong><?php echo __('Create new Ad') ?></strong><span class="bt_green_r"></span></a>
<?php else: ?>
    <a href="<?php echo url_for('ad/new?page=1') ?>" class="bt_green"><span class="bt_green_lft"></span><strong><?php echo __('Create new Ad') ?></strong><span class="bt_green_r"></span></a>
<?php endif; ?>
