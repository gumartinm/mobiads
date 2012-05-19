<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $company_category->getId() ?></td>
    </tr>
    <tr>
      <th>Company:</th>
      <td><?php echo $company_category->getCompanyId() ?></td>
    </tr>
    <tr>
      <th>General categ:</th>
      <td><?php echo $company_category->getGeneralCategId() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $company_category->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $company_category->getUpdatedAt() ?></td>
    </tr>
    <tr>
      <th>Root:</th>
      <td><?php echo $company_category->getRootId() ?></td>
    </tr>
    <tr>
      <th>Lft:</th>
      <td><?php echo $company_category->getLft() ?></td>
    </tr>
    <tr>
      <th>Rgt:</th>
      <td><?php echo $company_category->getRgt() ?></td>
    </tr>
    <tr>
      <th>Level:</th>
      <td><?php echo $company_category->getLevel() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('category/edit?id='.$company_category->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('category/index') ?>">List</a>
