<table cellpadding="0" cellspacing="0" width="100%" class="tEvan">
<? if ($fields): ?>
    <thead>
        <tr>
            <td class="sortCol"><div>label<span></span></div></td>
            <td class="sortCol"><div>Tag<span></span></div></td>
            <td class="sortCol"><div>Type<span></span></div></td>
            <td class="sortCol"><div>Actions<span></span></div></td>
        </tr>
    </thead>
    <tbody>
<? foreach ($fields as $formfield): ?>
	<script type="text/javascript">
	$(function(){
		var $dialog = $('<div></div>')
			.html('Are you sure you want to delete this form field?<br><?=$formfield->label;?>')
			.dialog({
				autoOpen: false,
				title: "Deleting formfield",
				modal: true,
				buttons: {
				    "Yes": function () {
						location.href="<?= Uri::create('formfieldbuyer/delete/'.$formfield->id); ?>";
				    },
				    "No": function () {
				        $(this).dialog("close");
				    }
				}
			});

		$('#formfield_<?=$formfield->id;?>').click(function() {
			$dialog.dialog('open');
			// prevent the default action, e.g., following a link
			return false;
		});
	});
	</script>

        <tr>
            <td><?= $formfield->label; ?></td>
            <td><?= $formfield->tag; ?></td>
            <td><?= $formfield->type; ?></td>
            <td><a href="<?=Uri::create('formfieldbuyer/edit/'.$formfield->id);?>">Edit</a><? if(!$formfield->search_field): ?> - <a href="#" id="formfield_<?=$formfield->id;?>">Del</a><? endif; ?></td>
        </tr>
<? endforeach; ?>
<? else: ?>
		<tr>
			<td>No form fields available.</td>
		</tr>
    </tbody>
<? endif; ?>
</table>
