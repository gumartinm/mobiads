<h1>Offices List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Company</th>
      <th>City</th>
      <th>Office gps</th>
      <th>Office street address</th>
      <th>Office zip</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($offices as $office): ?>
    <tr>
      <td><a href="<?php echo url_for('office/show?id='.$office->getId()) ?>"><?php echo $office->getId() ?></a></td>
      <td><?php echo $office->getCompanyId() ?></td>
      <td><?php echo $office->getCityId() ?></td>
      <td><?php echo $office->getOfficeGps() ?></td>
      <td><?php echo $office->getOfficeStreetAddress() ?></td>
      <td><?php echo $office->getOfficeZip() ?></td>
      <td><?php echo $office->getCreatedAt() ?></td>
      <td><?php echo $office->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('office/new') ?>">New</a>
