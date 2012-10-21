    <table cellpadding="0" cellspacing="0" width="100%" class="tDefault" id="resize2" >
<?php if ($shares): ?>
        <thead>
            <tr>
                <td class="sortCol" width="50px"><div>id<span></span></div></td>
                <td class="sortCol"><div>Boat name<span></span></div></td>
                <td class="sortCol"><div>Location<span></span></div></td>
                <td class="sortCol"><div>Length (ft)<span></span></div></td>
                <td class="sortCol"><div>Fraction<span></span></div></td>
                <td class="sortCol" width="400px"><div>Sale progress<span></span></div></td>
				<td class="sortCol">Action steps</td>
            </tr>
        </thead>
        <tbody>
	<?php foreach ($shares as $share): ?>
	        <tr>
	            <td><?= $share->id; ?></td>
	            <td><?= $share->boat->name; ?></td>
	            <td><?= $share->boat->location; ?></td>
	            <td><?= $share->boat->length; ?></td>
	            <td><?= $share->fraction; ?></td>
	            <td>
					<?= sizeof($share->active_actionsteps()); ?>
					<ul  class="ui-progressbar ui-widget ui-widget-content ui-corner-all" >
<? foreach($share->active_actionsteps() as $actionstep): ?>
<? $width = sizeof($available_actionsteps)-1; ?>
<li title="<?= $actionstep->title; ?><br><?= Date::forge($actionstep->created_at)->format('%d %b %Y'); ?>" class="tipN ui-progressbar-value ui-widget-header ui-corner-left" style="margin-left: 0; width: <?= $width; ?>%; " original-title="hello world"></li><? endforeach; ?></ul>
				</td>
				<td>

					<span class="icos-search"></span> 
					<? $buyer_id = ($share->active_buyer_id()) ? $share->active_buyer_id() : '0'; ?>
					<a href="<?= Uri::create('actionstep/create/'.$share->id.'/'.$buyer_id); ?>" id="formDialog_open"><span class="icos-add"></span></a> 
				</td>
	        </tr>
	<?php endforeach; ?>
<?php else: ?>
			<tr>
				<td>No shares available</td>
			</tr>
        </tbody>
<?php endif; ?>
    </table>
