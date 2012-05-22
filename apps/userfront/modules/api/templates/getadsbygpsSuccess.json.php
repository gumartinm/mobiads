[
<?php foreach ($ads as $ad): ?>
  { "id" : "<?php echo $ad->getId()?>", "domain" : "<?php echo $ad->getDomain()?>", "link" : "<?php echo $ad->getLinks()?>" },
<?php endforeach ?>
]
