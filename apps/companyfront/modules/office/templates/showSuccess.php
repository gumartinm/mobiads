<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $office->getId() ?></td>
    </tr>
    <tr>
      <th>Company:</th>
      <td><?php echo $office->getCompanyId() ?></td>
    </tr>
    <tr>
      <th>City:</th>
      <td><?php echo $office->getCityId() ?></td>
    </tr>
    <tr>
      <th>Office gps:</th>
      <td><?php echo $office->getOfficeGps() ?></td>
    </tr>
    <tr>
      <th>Office street address:</th>
      <td><?php echo $office->getOfficeStreetAddress() ?></td>
    </tr>
    <tr>
      <th>Office zip:</th>
      <td><?php echo $office->getOfficeZip() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $office->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $office->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('office/edit?id='.$office->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('office/index') ?>">List</a>
