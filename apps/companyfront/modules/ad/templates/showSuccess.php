<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $ad->getId() ?></td>
    </tr>
    <tr>
      <th>Company:</th>
      <td><?php echo $ad->getCompanyId() ?></td>
    </tr>
    <tr>
      <th>Company categ:</th>
      <td><?php echo $ad->getCompanyCategId() ?></td>
    </tr>
    <tr>
      <th>Ad mobile image link:</th>
      <td><?php echo $ad->getAdMobileImageLink() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $ad->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $ad->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('ad/edit?id='.$ad->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('ad/index') ?>">List</a>
