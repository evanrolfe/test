<?= render('settings/_nav'); ?>

<div class="widget">
    <div class="whead">
		<h6>Listing Email Templates</h6>
		<div class="clear"></div>
	</div>

    <table cellpadding="0" cellspacing="0" width="100%" class="tEvan">
<? if ($emailtemplates): ?>
        <thead>
            <tr>
                <td class="sortCol"><div>Subject<span></span></div></td>
                <td class="sortCol"><div>Body<span></span></div></td>
                <td class="sortCol"><div>Tag<span></span></div></td>
                <td class="sortCol"><div>Edit<span></span></div></td>
            </tr>
        </thead>
        <tbody>
	<? foreach ($emailtemplates as $email): ?>		<tr>

			<td><?= $email->subject; ?></td>
			<td><?= substr($email->body,0,100); ?>...</td>
			<td><?= $email->tag; ?></td>
			<td><a href="<?=Uri::create('emailtemplate/edit/'.$email->id);?>">Edit</a></td>
		</tr>
	<? endforeach; ?>
<? else: ?>
			<tr>
				<td>No emails available.</td>
			</tr>
<? endif; ?>
        </tbody>
    </table>
</div>
