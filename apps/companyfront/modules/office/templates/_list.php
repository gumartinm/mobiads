<table id="rounded-corner">
  <thead>
    <tr>
	  <th scope="col" class="rounded-company"><?php echo __('Street Address') ?></th>
	  <th scope="col" class="rounded"><?php echo __('Longitude') ?></th>
	  <th scope="col" class="rounded"><?php echo __('Latitude') ?></th>
      <th scope="col" class="rounded"><?php echo __('Edit') ?></th>
      <th scope="col" class="rounded"><?php echo __('Link to Ads') ?></th>
      <th scope="col" class="rounded-q4"><?php echo __('Remove') ?></th>
    </tr>
  </thead>
  <tfoot>
    <tr>
        <td colspan="5" class="rounded-foot-left"><em><?php echo __('Offices List') ?></em></td>
        <td class="rounded-foot-right">&nbsp;</td>
    </tr>
  </tfoot>
  <tbody>
    <?php foreach ($offices as $office): ?>
    <tr>
      <td><?php echo $office->getOfficeStreetAddress() ?></td>
      <td><?php echo $office->getLongitude() ?></td>
	  <td><?php echo $office->getLatitude() ?></td>
	  <td><a href="<?php echo url_for('office/edit?id='.$office->getId()) ?>"><img src="/images/pencil_add.png" alt="" title="" border="0" /></a></td>
      <td><a href="<?php echo url_for('office/link?id='.$office->getId()) ?>"><img src="/images/link.png" alt="" title="" border="0" /></a></td>
      <td><?php echo link_to('<img src="/images/inadminpanel/images/trash.png" alt="" title="" border="0" />', 'office/delete?id='.$office->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?></td>

    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
