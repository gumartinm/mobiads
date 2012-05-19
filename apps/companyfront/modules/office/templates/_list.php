<table id="rounded-corner">
  <thead>
    <tr>
      <th scope="col" class="rounded-company"><a href="<?php echo url_for('offices_index') ?>?page=<?php echo $page ?>&sort=country"><?php echo __('Country') ?></a></th>
      <th scope="col" class="rounded"><a href="<?php echo url_for('offices_index') ?>?page=<?php echo $page ?>&sort=region"><?php echo __('Region') ?></a></th>
	  <th scope="col" class="rounded"><a href="<?php echo url_for('offices_index') ?>?page=<?php echo $page ?>&sort=city"><?php echo __('City') ?></a></th>
      <th scope="col" class="rounded"><a href="<?php echo url_for('offices_index') ?>?page=<?php echo $page ?>&sort=address"><?php echo __('Street Address') ?></a></th>
      <th scope="col" class="rounded"><a href="<?php echo url_for('offices_index') ?>?page=<?php echo $page ?>&sort=zip"><?php echo __('ZIP') ?></a></th>
	  <th scope="col" class="rounded"><?php echo __('Longitude') ?></th>
	  <th scope="col" class="rounded"><?php echo __('Latitude') ?></th>
      <th scope="col" class="rounded"><?php echo __('Edit') ?></th>
      <th scope="col" class="rounded"><?php echo __('Link to Ads') ?></th>
      <th scope="col" class="rounded-q4"></th>
    </tr>
  </thead>
  <tfoot>
    <tr>
        <td colspan="9" class="rounded-foot-left"><em><?php echo __('Offices List') ?></em></td>
        <td class="rounded-foot-right">&nbsp;</td>
    </tr>
  </tfoot>
  <tbody>
    <?php foreach ($offices as $office): ?>
    <tr>
      <td><?php echo $office->getCity()->getRegion()->getCountry() ?></td>
      <td><?php echo $office->getCity()->getRegion() ?></td>
      <td><?php echo $office->getCity() ?></td>
      <td><?php echo $office->getOfficeStreetAddress() ?></td>
      <td><?php echo $office->getOfficeZip() ?></td>
      <td><?php echo $office->getLongitude() ?></td>
	  <td><?php echo $office->getLatitude() ?></td>
	  <td><a href="<?php echo url_for('office/edit?id='.$office->getId().'&page='.$page.'&sort='.$sort) ?>"><img src="/images/pencil_add.png" alt="" title="" border="0" /></a></td>
      <td><a href="<?php echo url_for('office/link?id='.$office->getId().'&page='.$page.'&sort='.$sort) ?>"><img src="/images/link.png" alt="" title="" border="0" /></a></td>
      <td><?php echo link_to('<img src="/images/inadminpanel/images/trash.png" alt="" title="" border="0" />', 'office/delete?id='.$office->getId().'&page='.$page.'&sort='.$sort, array('method' => 'delete', 'confirm' => 'Are you sure?')) ?></td>

    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
