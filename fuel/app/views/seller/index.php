<div class="widget fluid" style="width: 450px;">

    <div class="whead">
		<div>
			<h6>Welcome <?=$user->name;?></h6>
		</div>
		<div style='text-align: right'>
			<a href="<?= Uri::create('seller/search'); ?>"><button class="buttonS bBlue" style="margin: 6px 6px;"><span class="icon-add"></span><span>New Yacht Share</span></button></a>
		</div>
		<div class="clear"></div>
	</div>

    <table cellpadding="0" cellspacing="0" width="100%" class="tDefault" id="resize2">
<?php if ($yachtshares): ?>
        <thead>
            <tr>
                <td class="sortCol"><div>Name<span></span></div></td>
                <td class="sortCol"><div>Location<span></span></div></td>
                <td class="sortCol"><div>Actions<span></span></div></td>
            </tr>
        </thead>
        <tbody>
	<?php foreach ($yachtshares as $boat): ?>
	        <tr class="boat">
	            <td class="boatname"><a href="<?= Uri::create('yachtshare/view/'.$boat->id); ?>"><?= $boat->name; ?></a></td>
	            <td><?= $boat->location_specific; ?></td>
	            <td><a href="<?= Uri::create('file/yachtshare/'.$boat->id); ?>">Upload Files</a></td>
	        </tr>
	<?php endforeach; ?>
<?php else: ?>
			<tr>
				<td>You have not yet created any yacht shares, click the upper right-hand button to do so.</td>
			</tr>
        </tbody>
<?php endif; ?>
    </table>
</div>

