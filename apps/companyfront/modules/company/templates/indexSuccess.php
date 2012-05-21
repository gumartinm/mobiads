<h2><?php echo __('Your Company') ?></h2>

<table id="rounded-corner">
  <thead>
    <tr>
      <th scope="col" class="rounded-company"><?php echo __('Name') ?></th>
      <th scope="col" class="rounded-q4"><?php echo __('CIF') ?></th>
    </tr>
  </thead>
  <tfoot>
    <tr>
        <td colspan="1" class="rounded-foot-left"><em><?php echo __('Your data company') ?></em></td>
        <td class="rounded-foot-right">&nbsp;</td>
    </tr>
  </tfoot>
  <tbody>
    <tr>
      <td><?php echo $company->getCompanyName() ?></td>
      <td><?php echo $company->getCompany()->getCompanyCif() ?></td>
    </tr>
  </tbody>
</table>

<a href="<?php echo url_for('company/edit?id='.$company->getCompany()->getId()) ?>" class="bt_green"><span class="bt_green_lft"></span><strong><?php echo __('Edit Your Company') ?></strong><span class="bt_green_r"></span></a>