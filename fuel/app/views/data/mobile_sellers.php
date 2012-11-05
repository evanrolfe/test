<p>Sellers</p>
<p>&nbsp;</p>
<? foreach($yachtshares as $yachtshare): ?>
<p><?= $yachtshare->boat_details['sellers_name']; ?></p>
<p><?= $yachtshare->name; ?><br />
  <?= $yachtshare->make; ?><br />
  <?= $yachtshare->location_specific; ?><br />
  <?= $yachtshare->share_size_num; ?>/<?= $yachtshare->share_size_den; ?> share £<?= $yachtshare->price; ?></p>
<p>Email: <a href="mailto:c.rolfe@ais.at">c.rolfe@ais.at</a></p>
<p>Home: <a href="tel:<?=$yachtshare->boat_details['telephone_home'];?>"><pre><?=$yachtshare->boat_details['telephone_home'];?></pre></a></p>
<p>Work: <a href="tel:<?=$yachtshare->boat_details['telephone_work'];?>"><pre><?=$yachtshare->boat_details['telephone_work'];?></pre></a></p>
<p>Mobile: <a href="tel:<?=$yachtshare->boat_details['telephone_mobile'];?>"><pre><?=$yachtshare->boat_details['telephone_mobile'];?></pre></a></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<? endforeach; ?>
