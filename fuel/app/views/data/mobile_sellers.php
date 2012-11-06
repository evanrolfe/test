<p>Sellers</p>
<p>&nbsp;</p>
<? foreach($yachtshares as $yachtshare): ?>
<p><?= $yachtshare->boat_details['sellers_name']; ?></p>
<p><?= $yachtshare->name; ?><br />
  <?= $yachtshare->make; ?><br />
  <?= $yachtshare->location_specific; ?><br />
  <?= $yachtshare->share_size_num; ?>/<?= $yachtshare->share_size_den; ?> share £<?= $yachtshare->price; ?></p>
<p>Email: <a href="mailto:c.rolfe@ais.at">c.rolfe@ais.at</a></p>
<p>Home: <a href="tel:<?=$yachtshare->boat_details['telephone_home'];?>"><?=$yachtshare->boat_details['telephone_home'];?></a></p>
<p>Work: <a href="tel:<?=$yachtshare->boat_details['telephone_work'];?>"><?=$yachtshare->boat_details['telephone_work'];?></a></p>
<p>Mobile: <a href="tel:<?=$yachtshare->boat_details['telephone_mobile'];?>"><?=$yachtshare->boat_details['telephone_mobile'];?></a></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<? endforeach; ?>
