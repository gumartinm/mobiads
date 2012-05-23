<h2><?php echo __('General Categories') ?></h2>


<script type="text/javascript">
        $(document).ready(function()  {
            $("#rounded-corner").treeTable();
        });
</script>
<script type="text/javascript">
    $.fn.CheckCategories = function() {
        var checked = [];
        $('#rounded-corner :checked').each(function() {
                checked.push($(this).val());
               });
        $.post('<?php echo url_for('category/choose') ?>', {'checked[]': checked},
            function(data){
                alert("hola");
        }, "json");
    };
</script>



<table id="rounded-corner">
  <thead>
    <tr>
      <th scope="col" class="rounded-company"><?php echo __('General Category Name') ?></th>
      <th scope="col" class="rounded-q4"><?php echo __('Selected') ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($generalCategories as $category): ?>
    <tr id="node-<?php echo $category->getId()?>" <?php
      // insert hierarchical info
      $node = $category->getNode();
      if ($node->isValidNode() && $node->hasParent() && ($node->getParent()->getId() != '1'))
      {
        echo 'class="child-of-node-'.$node->getParent()->getId().'"';
      }
      ?>>
      <td><a><?php echo $category ?></a></td>
      <td><input type="checkbox" id="chosen" class="NFCheck" value="<?php echo $category->getId() ?>"
      <?php foreach ($category->getUserBaskets() as $userBasket): ?>
        <?php if ($userBasket->getUserId() == $userId): ?>
            checked
            <?php break ?>
        <?php endif; ?>
      <?php endforeach; ?>
      ></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<input type="button" class="NFButtonToRight" value="<?php echo __('Select') ?>" onClick="$(this).CheckCategories();"/>