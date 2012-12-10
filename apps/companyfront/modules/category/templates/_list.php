<script type="text/javascript">
        $(document).ready(function()  {
            $("#rounded-corner").treeTable();
        });
</script>

<table id="rounded-corner">
  <thead>
    <tr>
      <th scope="col" class="rounded-company"><?php echo __('Company Category') ?></th>
	  <th scope="col" class="rounded"><?php echo __('Current General Category') ?></th>
      <th scope="col" class="rounded"><?php echo __('Edit') ?></th>
      <th scope="col" class="rounded-q4"></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($company_categories as $company_category): ?>
    <tr id="node-<?php echo $company_category->getId()?>" <?php
	  // insert hierarchical info
	  $node = $company_category->getNode();
	  if ($node->isValidNode() && $node->hasParent() && ($node->getParent()->getLevel() != '0'))
      {
      	echo 'class="child-of-node-'.$node->getParent()->getId().'"';
      }
      ?>>
      <td>
        <a>
           <?php echo $company_category ?>
        </a>
      </td >
	  <td>
        <?php if ($company_category->getGeneralCategId() != null): ?>
            <?php echo $company_category->getGeneralCategory() ?>
        <?php endif; ?>
      </td>
      <td>
        <?php if ($company_category->getId() != 1): ?>
         <a href="<?php echo url_for('category/edit?id='.$company_category->getId()) ?>">
         <img src="/images/pencil_add.png" alt="" title="" border="0" /></a>
        <?php else: ?>
	     <a><img src="/images/cross.png" alt="" title="" border="0" /></a>
        <?php endif; ?>
      </td>
      <td>
        <?php if ($company_category->getId() != 1): ?>	  
         <?php echo link_to('<img src="/images/inadminpanel/images/trash.png" alt="" title="" border="0" />', 'category/delete?id='.$company_category->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
        <?php else: ?>
         <a><img src="/images/cross.png" alt="" title="" border="0" /></a>
        <?php endif; ?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody> 
</table>
