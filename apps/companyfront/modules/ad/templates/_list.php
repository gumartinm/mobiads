<table id="rounded-corner">
  <thead>
    <tr>
	  <th scope="col" class="rounded-company"><?php echo __('Phone Image Link') ?></th>
	  <th scope="col" class="rounded"><?php echo __('Company Category') ?></th>
      <th scope="col" class="rounded"><?php echo __('Ad Name') ?></th>
      <th scope="col" class="rounded"><?php echo __('Edit') ?></th>
      <th scope="col" class="rounded-q4"><?php echo __('Remove') ?></th>
    </tr>
  </thead>
  <tfoot>
    <tr>
        <td colspan="5" class="rounded-foot-left"><em><?php echo __('Ads List') ?></em></td>
        <td class="rounded-foot-right">&nbsp;</td>
    </tr>
  </tfoot>
  <tbody>
    <?php foreach ($ads as $ad): ?>
    <tr>
      <td><?php echo $ad->getAd()->getAdMobileImageLink() ?></td>
      <td><?php echo $ad->getAd()->getCompanyCategId() ?></td>
      <td><?php echo $ad->getAdName() ?></td>
	  <td><a href="<?php echo url_for('ad/edit?id='.$ad->getId()) ?>"><img src="/images/pencil_add.png" alt="" title="" border="0" /></a></td>
      <td><?php echo link_to('<img src="/images/inadminpanel/images/trash.png" alt="" title="" border="0" />', 'ad/delete?id='.$ad->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?></td>

    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
