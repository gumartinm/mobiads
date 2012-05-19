<script type="text/javascript">
        $(document).ready(function()  {
            $("#rounded-corner").treeTable();
        });
</script>

<script type="text/javascript">
jQuery(document).ready(function(){
  $("#associate").click(function(event){
      event.preventDefault();
      event.stopPropagation();
      window.open('<?php echo url_for('categgeneral/index') ?>', '', 'scrollbars,resizable,status,width=888,height=888');
  });
});
</script>


<table id="rounded-corner">
  <thead>
    <tr>
      <th scope="col" class="rounded-company">Name</th>
	  <th scope="col" class="rounded">Current General Category</th>
      <th scope="col" class="rounded">Associate/Delete</th>
      <th scope="col" class="rounded">Edit</th>
      <th scope="col" class="rounded-q4">Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($company_categories as $categ_empresa): ?>
    <tr id="node-<?php echo $categ_empresa->getId()?>" <?php
	  // insert hierarchical info
	  $node = $categ_empresa->getNode();
	  if ($node->isValidNode() && $node->hasParent() && ($node->getParent()->getId() != '1'))
      {
      	echo 'class="child-of-node-'.$node->getParent()->getId().'"';
      }
      ?>>
      <td>
        <a>
           <?php echo $categ_empresa ?>
        </a>
      </td >
	  <td>
          <?php echo $categ_empresa->getGeneralCategory() ?>
      </td>
      <td>
        <?php if ($categ_empresa->getId() != 1): ?>
         <?php if ($categ_empresa->getGeneralCategId() != null): ?>
          <a href="<?php echo url_for('categgeneral/deleteassociation?idcompanycateg='.$categ_empresa->getId()) ?>">
          <img src="/images/link_break.png" alt="" title="" border="0" /></a>
         <?php else: ?>
          <a><img src="/images/link.png" alt="" title="" border="0" /></a>
         <?php endif; ?>
        <?php else: ?>
		 <a><img src="/images/cross.png" alt="" title="" border="0" /></a>
        <?php endif; ?>
      </td>
      <td>
        <?php if ($categ_empresa->getId() != 1): ?>
         <a href="<?php echo url_for('categempresa/edit?id='.$categ_empresa->getId()) ?>">
         <img src="/images/pencil_add.png" alt="" title="" border="0" /></a>
        <?php else: ?>
	     <a><img src="/images/cross.png" alt="" title="" border="0" /></a>
        <?php endif; ?>
      </td>
      <td>
        <?php if ($categ_empresa->getId() != 1): ?>	  
         <?php echo link_to('<img src="/images/inadminpanel/images/trash.png" alt="" title="" border="0" />', 'categempresa/delete?id='.$categ_empresa->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
        <?php else: ?>
         <a><img src="/images/cross.png" alt="" title="" border="0" /></a>
        <?php endif; ?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody> 
</table>
