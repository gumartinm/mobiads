[
<?php foreach ($ads as $ad): ?>
  { "id" : "<?php echo $ad->getAd()->getId()?>", "image" : "<?php echo $ad->getAd()->getAdMobileImageLink() ?>", "link" : "<?php echo $ad->getAdLink()?>",
    "text" : "<?php echo $ad->getAdMobileText()?>", "adname" : "<?php echo $ad->getAdName()?>" },
<?php endforeach ?>
]
