<h2><?php echo __('General Categories') ?></h2>


<script type="text/javascript">
        $(document).ready(function()  {
            $("#rounded-corner").treeTable();
        });
</script>
<script type="text/javascript">
    //TODO: I am wasting space in the data base because if a parent category is checked directly we know the child categories
    //are as well selected. So, we do not really need to send every checked category, just the parent ones.
    $.fn.CheckCategories = function() {
        var checked = [];
        $('#rounded-corner :checked').each(function() {
                checked.push($(this).val());
               });
        $.post('<?php echo url_for('category/choose') ?>', {'checked[]': checked},
            function(data){
                alert("Updated successfully!");
        }, "json");
    };
</script>
<script type="text/javascript">
    function hierarchyCheck(node, checkedInput) {
        $("table.treeTable tbody tr.child-of-" + node[0].id).each(function(data){
            $(this).children('td').eq(1).find('input').prop('checked', checkedInput);
            $(this).children('td').eq(1).find('input').prop('disabled', checkedInput);
            hierarchyCheck($(this), checkedInput);
        });

    }
    $(document).ready(function(){
        $('[id^=node]').change(function(){
            var checkedInput = false;
            if($(this).children('td').eq(1).find('input').is(':checked')) {
                checkedInput = true;
            }
            hierarchyCheck($(this), checkedInput);
        });
    });

    $(document).ready(function(){
        $('[id^=node]').each(function(data){
            if($(this).children('td').eq(1).find('input').is(':checked')) {
                hierarchyCheck($(this), true);
            }
        });
    });
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
      if ($node->isValidNode() && $node->hasParent() && ($node->getParent()->getLevel() != '0'))
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
