<?= render('settings/_nav'); ?>

<div class="widget">
    <div class="whead">
		<h6>Listing Yachtshare Fields</h6>
		<div style='text-align: right'>
			<a href="<?= Uri::create('formfield/order'); ?>"><button class="buttonS bBlue" style="margin: 6px 6px;" type="button">Change Order</button></a>
			<a href="<?= Uri::create('formfield/create'); ?>"><button class="buttonS bBlue" style="margin: 6px 6px;" type="button"><span class="icon-add"></span>New</button></a>
		</div>
		<div class="clear"></div>
	</div>

    <table cellpadding="0" cellspacing="0" width="100%" class="tEvan">
<? if ($seller_fields): ?>
        <thead>
            <tr>
                <td class="sortCol"><div>Key<span></span></div></td>
                <td class="sortCol"><div>Name<span></span></div></td>
            </tr>
        </thead>
        <tbody>
	<? foreach ($seller_fields as $formfield): ?>
	        <tr>
	            <td><?= $formfield->key; ?></td>
	            <td><?= $formfield->tag; ?></td>
	        </tr>
	<? endforeach; ?>
<? else: ?>
			<tr>
				<td>No proforma fields available.</td>
			</tr>
        </tbody>
<? endif; ?>
    </table>
</div>

<div class="widget">
    <div class="whead">
		<h6>Listing Buyer Fields</h6>
		<div style='text-align: right'>
			<a href="<?= Uri::create('formfieldbuyer/order'); ?>"><button class="buttonS bBlue" style="margin: 6px 6px;" type="button">Change Order</button></a>
			<a href="<?= Uri::create('formfieldbuyer/create'); ?>"><button class="buttonS bBlue" style="margin: 6px 6px;" type="button"><span class="icon-add"></span>New</button></a>
		</div>
		<div class="clear"></div>
	</div>

    <table cellpadding="0" cellspacing="0" width="100%" class="tEvan">
<? if ($buyer_fields): ?>
        <thead>
            <tr>
                <td class="sortCol"><div>label<span></span></div></td>
                <td class="sortCol"><div>type<span></span></div></td>
                <td class="sortCol"><div>options<span></span></div></td>
            </tr>
        </thead>
        <tbody>
	<? foreach ($buyer_fields as $formfield): ?>
	        <tr>
	            <td><?= $formfield->label; ?></td>
	            <td><?= $formfield->type; ?></td>
	            <td><?= $formfield->options; ?></td>
	        </tr>
	<? endforeach; ?>
<? else: ?>
			<tr>
				<td>No proforma fields available.</td>
			</tr>
        </tbody>
<? endif; ?>
    </table>
</div>
