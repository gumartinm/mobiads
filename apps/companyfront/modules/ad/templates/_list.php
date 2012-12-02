<table id="rounded-corner">
  <thead>
    <tr>
	  <th scope="col" class="rounded-company"><?php echo __('Phone Image') ?></th>
	  <th scope="col" class="rounded"><?php echo __('Company Category') ?></th>
      <th scope="col" class="rounded"><?php echo __('Ad Name') ?></th>
      <th scope="col" class="rounded"><?php echo __('Longitude') ?></th>
      <th scope="col" class="rounded"><?php echo __('Latitude') ?></th>
      <th scope="col" class="rounded"><?php echo __('Edit') ?></th>
      <th scope="col" class="rounded-q4"></th>
    </tr>
  </thead>
  <tfoot>
    <tr>
        <td colspan="6" class="rounded-foot-left"><em><?php echo __('Ads List') ?></em></td>
        <td class="rounded-foot-right">&nbsp;</td>
    </tr>
  </tfoot>
  <tbody>
    <?php foreach ($ads as $ad): ?>
    <tr>
      <td><img src="<?php echo "/uploads/images/".$ad->getAd()->getAdMobileImage() ?>" width="80" height="80" alt="<?php echo $ad->getAdName() ?>"/></td>
      <td>
        <?php if ($ad->getAd()->getCompanyCategId() != null): ?>
            <?php echo $ad->getAd()->getCompanyCategory() ?>
        <?php endif; ?>
      </td>
      <td><?php echo $ad->getAdName() ?></td>
      <td><?php echo $ad->getAd()->getLongitude() ?></td>
      <td><?php echo $ad->getAd()->getLatitude() ?></td>
	  <td><a href="<?php echo url_for('ad/edit?id='.$ad->getAd()->getId().'&page='.$page) ?>"><img src="/images/pencil_add.png" alt="" title="" border="0" /></a></td>
      <td><?php echo link_to('<img src="/images/inadminpanel/images/trash.png" alt="" title="" border="0" />', 'ad/delete?id='.$ad->getAd()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?></td>

    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
