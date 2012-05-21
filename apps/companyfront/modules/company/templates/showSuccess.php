<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $company->getId() ?></td>
    </tr>
    <tr>
      <th>User:</th>
      <td><?php echo $company->getUserId() ?></td>
    </tr>
    <tr>
      <th>Company cif:</th>
      <td><?php echo $company->getCompanyCif() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('company/edit?id='.$company->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('company/index') ?>">List</a>
