<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
	<title>Yacht Fractions</title>
	<?php echo render('_includes'); ?>
</head>
<body>
<?php echo render('_flash_messages'); ?>
<div style="width: 100%;" align="center">
<div class="widget" style="width: 600px;">
    <div class="whead">
		<div>
			<h6>New Yacht Share</h6>
		</div>
		<div class="clear"></div>
	</div>

    <div class="formRow">
		We have found the following yacht(s) with that name - you can save time by copying the data from that boat:
		<div class="clear"></div>
	</div>
</div>
<div class="widget" style="width: 600px;" id="list">
    <div class="whead">
		<div>
			<h6>Search Results</h6>
		</div>
		<div class="clear"></div>
	</div>

    <table cellpadding="0" cellspacing="0" width="100%" class="tDefault" id="resize2">
<?php if ($yachtshares): ?>
        <thead>
            <tr>
                <td class="sortCol"><div>Boat Name<span></span></div></td>
                <td class="sortCol"><div>Location<span></span></div></td>
                <td class="sortCol"><div><span></span></div></td>
            </tr>
        </thead>
        <tbody>
	<?php foreach ($yachtshares as $yachtshare): ?>
	        <tr class="boat">
	            <td><?= $yachtshare->name; ?></td>
	            <td><?= $yachtshare->location_specific; ?></td>
	            <td><a href="<?= Uri::create('yachtshare/create/'.$yachtshare->id); ?>">This is my boat - copy the details!</a></td>
	        </tr>
	<?php endforeach; ?>
<?php else: ?>
			<tr>
				<td>No yachts have been found with that name.</td>
			</tr>
        </tbody>
<?php endif; ?>
    </table>
		<div class="clear"></div>
	<div class="whead">
		<h6 style="opacity: 0.0;">-</h6>
		<div style='text-align: right;'>
			<a href="<?=Uri::create('yachtshare/create');?>"><button class="buttonS bBlue" style="margin: 6px 6px;">My yacht is not listed here, I will enter the details myself.</button></a>
		</div>
		<div class="clear"></div>
	</div>
</div>
<a href="<? Uri::create('session/logout'); ?>">Logout</a>
</div>
