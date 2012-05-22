<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $general_category->getId() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $general_category->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $general_category->getUpdatedAt() ?></td>
    </tr>
    <tr>
      <th>Root:</th>
      <td><?php echo $general_category->getRootId() ?></td>
    </tr>
    <tr>
      <th>Lft:</th>
      <td><?php echo $general_category->getLft() ?></td>
    </tr>
    <tr>
      <th>Rgt:</th>
      <td><?php echo $general_category->getRgt() ?></td>
    </tr>
    <tr>
      <th>Level:</th>
      <td><?php echo $general_category->getLevel() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('category/edit?id='.$general_category->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('category/index') ?>">List</a>
